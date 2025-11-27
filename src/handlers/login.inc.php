<?php
require_once __DIR__ . '/../Classes/Auth.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}

$auth = new Auth();

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

$result = $auth->login($email, $password, $remember);

if ($result === true) {
    header("Location: ../dashboard.php");
} else {
    $_SESSION['login_error'] = $result['error'] ?? 'Login failed';
    header("Location: ../login.php");
}
exit();
