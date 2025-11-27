<?php
require_once __DIR__ . '/../Classes/Auth.php';
session_start();

$auth = new Auth();

$token  = $_GET['token'] ?? '';
$userId = (int)($_GET['userId'] ?? 0);

if (!$token || !$userId) {
    exit('Invalid verification link.');
}

if ($auth->verifyEmail($token, $userId)) {
    header("Location: ../login.php?verify=success");
} else {
    header("Location: ../login.php?verify=fail");
}
exit();
