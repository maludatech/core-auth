<?php
require_once __DIR__ . '/../Classes/Auth.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}

$auth = new Auth();

$token     = $_POST['token'] ?? '';
$userId    = (int)($_POST['userId'] ?? 0);
$password  = $_POST['password'] ?? '';

if (!$token || !$userId || !$password) {
    $_SESSION['reset_error'] = "Invalid request";
    header("Location: ../new-password.php?token=$token&userId=$userId");
    exit();
}

if ($auth->resetPassword($token, $userId, $password)) {
    header("Location: ../login.php?reset=success");
} else {
    $_SESSION['reset_error'] = "Reset failed or link expired";
    header("Location: ../new-password.php?token=$token&userId=$userId");
}
exit();
