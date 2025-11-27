<?php
require_once __DIR__ . '/../Classes/Auth.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../signup.php");
    exit();
}

$auth = new Auth();

$username = $_POST['username'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$result = $auth->signup($username, $email, $password);

if ($result === true) {
    header("Location: ../login.php?signup=success");
} else {
    $_SESSION['signup_error'] = $result['error'] ?? 'Unknown error';
    header("Location: ../signup.php");
}
exit();
