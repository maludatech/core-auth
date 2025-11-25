<?php

declare(strict_types=1);

require_once 'Dbh.php';

class User extends Dbh
{
    //Create user
    public function createUser(string $username, string $email, string $password)
    {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        return $stmt->execute();
    }

    //Get User by email
    public function getUserByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    //Get User by ID
    public function getUserById(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    //Update profile
    public function updateProfile(int $userId, string $username, $profilePic = null)
    {
        $sql = "UPDATE users SET username = :username, profile_pic = :profile_pic WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":profile_pic", $profilePic);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }

    //Change password
    public function changePassword(int $userId, string $newPassword)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, ['cost' => 12]);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
