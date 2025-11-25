<?php

declare(strict_types=1);

require_once 'User.php';

class Auth
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    //Login user

    public function login($email, $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            return "Email not found";
        }

        if (!password_verify($password, $user["password"])) {
            return "Incorrect password";
        }

        $_SESSION["user_id"] = $user["id"];
        return true;
    }

    //Logout user
    public function logout()
    {
        session_destroy();
        return true;
    }


    //Check if user is logged in
    public function isLoggedIn()
    {
        return isset($_SESSION["user_id"]);
    }

    public function user()
    {
        if (!$this->isLoggedIn()) return null;

        return $this->userModel->getUserById($_SESSION["user_id"]);
    }
}
