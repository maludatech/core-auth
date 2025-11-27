<?php
require_once __DIR__ . '/../Classes/Auth.php';
require_once __DIR__ . '/../Classes/User.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../profile.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$userId   = $_SESSION['user_id'];
$current  = $_POST['current_password'] ?? '';
$newPass  = $_POST['new_password'] ?? '';

$userModel = new User();
$user = $userModel->findById($userId);

if (!$user) {
    $_SESSION['password_error'] = "User not found";
    header("Location: ../profile.php");
    exit();
}

// verify old password
if (!password_verify($current, $user['password'])) {
    $_SESSION['password_error'] = "Incorrect current password";
    header("Location: ../profile.php");
    exit();
}

// update
$userModel->updatePassword($userId, $newPass);

header("Location: ../profile.php?password=updated");
exit();
