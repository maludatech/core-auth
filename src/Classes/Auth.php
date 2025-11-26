<?php

require_once __DIR__ . "/Dbh.php";
require_once __DIR__ . "/User.php";
require_once __DIR__ . "/Token.php";
require_once __DIR__ . "/Mailer.php";
require_once __DIR__ . "/RememberToken.php";

class Auth extends Dbh
{
    private User $userModel;
    private RememberToken $rememberModel;
    private Mailer $mailer;

    // cookie name for remember-me
    private string $cookieName = 'coreauth_remember';

    public function __construct()
    {
        $this->userModel = new User();
        $this->rememberModel = new RememberToken();
        $this->mailer = new Mailer();

        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    //    SIGNUP + VERIFICATION
    public function signup(string $username, string $email, string $password, string $role = 'user'): array|bool
    {
        // basic checks
        if (empty($username) || empty($email) || empty($password)) {
            return ['error' => 'Fill all fields'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Invalid email'];
        }
        if ($this->userModel->findByEmail($email)) {
            return ['error' => 'Email already used'];
        }

        // create
        $this->userModel->create($username, $email, $password, $role);

        // create verification token and email
        $user = $this->userModel->findByEmail($email);
        $token = Token::createRandom();
        $token = Token::hash($token);
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour

        // store token in email_verification_tokens
        $pdo = $this->userModel->connect();
        $stmt = $pdo->prepare("INSERT INTO email_verification_tokens (user_id, token, expires_at) VALUES (:userId, :token, :expiresAt)");
        $stmt->execute([':userId' => $user['id'], ':token' => $token, ':expiresAt' => $expiresAt]);

        // build URL and send
        $verifyUrl = $this->makeUrl('/public/verify.php?token=' . $token . '&userId=' . $user['id']);
        $body = $this->renderEmailTemplate(__DIR__ . '/../views/emails/verify-email.php', ['verifyUrl' => $verifyUrl]);

        $this->mailer->send($email, 'Verify your email', $body);

        return true;
    }

    public function verifyEmail(string $token, int $userId): bool
    {
        $pdo = $this->userModel->connect();
        $stmt = $pdo->prepare("SELECT * FROM email_verification_tokens WHERE user_id = :userId LIMIT 1");
        $stmt->execute([':userId' => $userId]);
        $row = $stmt->fetch();

        if (!$row) return false;
        if ($row['expires_at'] < date('Y-m-d H:i:s')) return false;

        if (hash_equals($row['token'], Token::hash($token))) {
            $this->userModel->verifyEmail($userId);
            // delete token
            $stmt = $pdo->prepare("DELETE FROM email_verification_tokens WHERE id = :id");
            $stmt->execute([':id' => $row['id']]);
            return true;
        }

        return false;
    }

    //  LOGIN / LOGOUT
    public function login(string $email, string $password, bool $remember = false): array|bool
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) return ['error' => 'User not found'];

        if (!password_verify($password, $user['password'])) {
            return ['error' => 'Incorrect credentials'];
        }

        // create session
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // optional: only allow login if email verified
        if ((int)$user['email_verified'] === 0) {
            // you could force verification, or mark warning
            // we'll allow login but you can protect routes via role+email_verified checks
        }

        // create remember-me cookie if requested
        if ($remember) $this->createRememberMe($user['id']);

        return true;
    }

    public function logout(): void
    {
        // remove remember-me cookie & DB token
        $this->clearRememberCookie();

        // destroy session securely
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }

    //       REMEMBER-ME
    private function createRememberMe(int $userId): void
    {
        // selector + validator pattern
        $selector = bin2hex(random_bytes(16)); // 32 chars
        $validator = bin2hex(random_bytes(32)); // 64 chars
        $hashedValidator = hash('sha256', $validator);
        $expires = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days

        // store in DB
        $this->rememberModel->store($userId, $selector, $hashedValidator, $expires);

        // set cookie: selector:validator (clear validator kept client-side)
        $cookieValue = $selector . ':' . $validator;
        setcookie($this->cookieName, $cookieValue, time() + (86400 * 30), '/', '', false, true); // secure flag false for localhost
    }

    public function checkRememberMe(): bool
    {
        if (isset($_SESSION['user_id'])) return true; // already logged in

        if (empty($_COOKIE[$this->cookieName])) return false;

        $parts = explode(':', $_COOKIE[$this->cookieName]);
        if (count($parts) !== 2) return false;

        [$selector, $validator] = $parts;
        $row = $this->rememberModel->findBySelector($selector);
        if (!$row) {
            $this->clearRememberCookie();
            return false;
        }

        // check expiration
        if ($row['expires_at'] < date('Y-m-d H:i:s')) {
            $this->rememberModel->deleteById((int)$row['id']);
            $this->clearRememberCookie();
            return false;
        }

        // verify validator
        if (hash_equals($row['hashed_validator'], hash('sha256', $validator))) {
            // auto-login
            $user = $this->userModel->findById((int)$row['user_id']);
            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        } else {
            // possible theft: delete all tokens for user
            $this->rememberModel->deleteById((int)$row['id']);
            $this->clearRememberCookie();
        }

        return false;
    }

    private function clearRememberCookie(): void
    {
        if (!empty($_COOKIE[$this->cookieName])) {
            // if cookie present, remove DB entry if possible
            $parts = explode(':', $_COOKIE[$this->cookieName]);
            if (count($parts) === 2) {
                $sel = $parts[0];
                $row = $this->rememberModel->findBySelector($sel);
                if ($row) $this->rememberModel->deleteById((int)$row['id']);
            }

            setcookie($this->cookieName, '', time() - 3600, '/', '', false, true);
            unset($_COOKIE[$this->cookieName]);
        }
    }

    /* -------------------------
       PASSWORD RESET
       ------------------------- */

    public function requestPasswordReset(string $email): bool
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) return false;

        $token = Token::createRandom();
        $hash = Token::hash($token);
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour

        // store
        $pdo = $this->userModel->connect();
        $stmt = $pdo->prepare("INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (:userId, :token, :expiresAt)");
        $stmt->execute([':userId' => $user['id'], ':token' => $hash, ':expiresAt' => $expiresAt]);

        // send email
        $resetUrl = $this->makeUrl('/public/new-password.php?token=' . $token . '&userId=' . $user['id']);
        $body = $this->renderEmailTemplate(__DIR__ . '/../views/emails/reset-password.php', ['resetUrl' => $resetUrl]);

        $this->mailer->send($email, 'Reset your password', $body);
        return true;
    }

    public function resetPassword(string $token, int $userId, string $newPassword): bool
    {
        $pdo = $this->userModel->connect();
        $stmt = $pdo->prepare("SELECT * FROM password_reset_tokens WHERE user_id = :userId LIMIT 1");
        $stmt->execute([':userId' => $userId]);
        $row = $stmt->fetch();
        if (!$row) return false;
        if ($row['expires_at'] < date('Y-m-d H:i:s')) return false;

        if (hash_equals($row['token'], Token::hash($token))) {
            $this->userModel->updatePassword($userId, $newPassword);
            $del = $pdo->prepare("DELETE FROM password_reset_tokens WHERE id = :id");
            $del->execute([':id' => $row['id']]);
            return true;
        }

        return false;
    }

    /* -------------------------
       HELPERS
       ------------------------- */

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function user(): ?array
    {
        if (!$this->isLoggedIn()) return null;
        return $this->userModel->findById((int)$_SESSION['user_id']);
    }

    public function isAdmin(): bool
    {
        return $this->isLoggedIn() && ($_SESSION['role'] ?? '') === 'admin';
    }

    private function makeUrl(string $path): string
    {
        // adjust to your server layout; public folder assumption
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        // You might want to change '/public' depending on your routing
        return $proto . '://' . $host . $path;
    }

    private function renderEmailTemplate(string $file, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}
