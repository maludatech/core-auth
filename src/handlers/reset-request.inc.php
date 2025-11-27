<?php
require_once __DIR__ . '/../Classes/Auth.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../forgot-password.php");
    exit();
}

$auth = new Auth();
$email = $_POST['email'] ?? '';

if ($auth->requestPasswordReset($email)) {
    header("Location: ../forgot-password.php?sent=1");
} else {
    $_SESSION['reset_request_error'] = "Email not found";
    header("Location: ../forgot-password.php");
}
exit();
