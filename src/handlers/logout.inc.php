<?php
require_once __DIR__ . '/../Classes/Auth.php';
session_start();

$auth = new Auth();
$auth->logout();

header("Location: ../login.php?logout=success");
exit();
