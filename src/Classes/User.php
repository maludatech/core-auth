<?php

declare(strict_types=1);

require_once "/Dbh.php";

class User extends Dbh
{

    // Create a new user
    public function create($username, $email, $password, $role = "user")
    {
        $sql = "INSERT INTO users (username, email, password, role) 
                VALUES (:username, :email, :password, :role)";
        $stmt = $this->connect()->prepare($sql);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);

        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $hashedPassword,
            ":role" => $role
        ]);
    }

    // Find a user by email
    public function findByEmail($email)
    {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM users WHERE email = :email LIMIT 1"
        );
        $stmt->execute([":email" => $email]);
        return $stmt->fetch();
    }

    // Find a user by ID
    public function findById($id)
    {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM users WHERE id = :id LIMIT 1"
        );
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    // Verify user's email
    public function verifyEmail($userId)
    {
        $stmt = $this->connect()->prepare(
            "UPDATE users SET email_verified = 1 WHERE id = :id"
        );
        $stmt->execute([":id" => $userId]);
    }

    // Update user profile
    public function updateProfile($id, $username, $profilePic = null)
    {
        $sql = "UPDATE users SET username = :username, profile_pic = :profile_pic WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);

        $stmt->execute([
            ":username" => $username,
            ":profile_pic" => $profilePic,
            ":id" => $id
        ]);
    }

    public function updatePassword($id, $password)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([":password" => $hashedPassword, ":id" => $id]);
    }
}
