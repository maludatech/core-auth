<?php

declare(strict_types=1);

require_once __DIR__ . "/Dbh.php";

class RememberToken extends Dbh
{
    public function store(int $userId, string $selector, string $hashedValidator, string $expiresAt)
    {
        $stmt = $this->connect()->prepare(
            "INSERT INTO remember_me_tokens (user_id, selector, hashed_validator, expires_at)
             VALUES (:userId, :selector, :hashedValidator, :expiresAt)"
        );
        $stmt->execute([
            ':userId' => $userId,
            ':selector' => $selector,
            ':hashedValidator'  => $hashedValidator,
            ':expiresAt' => $expiresAt
        ]);
    }

    public function findBySelector(string $selector)
    {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM remember_me_tokens WHERE selector = :selector LIMIT 1"
        );
        $stmt->execute([':selector' => $selector]);
        return $stmt->fetch();
    }

    public function deleteById(int $id)
    {
        $stmt = $this->connect()->prepare("DELETE FROM remember_me_tokens WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function deleteByUserId(int $userId)
    {
        $stmt = $this->connect()->prepare("DELETE FROM remember_me_tokens WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
    }

    public function purgeExpired()
    {
        $stmt = $this->connect()->prepare("DELETE FROM remember_me_tokens WHERE expires_at < NOW()");
        $stmt->execute();
    }
}
