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
$username = $_POST['username'] ?? '';

if (!$username) {
    $_SESSION['profile_error'] = "Username cannot be empty.";
    header("Location: ../profile.php");
    exit();
}

$profilePic = null;

// Handle profile picture upload
if (!empty($_FILES['profile_pic']['name'])) {
    $fileTmp  = $_FILES['profile_pic']['tmp_name'];
    $fileName = time() . '_' . basename($_FILES['profile_pic']['name']);
    $target   = __DIR__ . '/../uploads/profile/' . $fileName;

    // Create folder if it doesn't exist
    if (!is_dir(__DIR__ . '/../uploads/profile/')) {
        mkdir(__DIR__ . '/../uploads/profile/', 0777, true);
    }

    if (move_uploaded_file($fileTmp, $target)) {
        $profilePic = $fileName;
    } else {
        $_SESSION['profile_error'] = "Profile picture upload failed.";
        header("Location: ../profile.php");
        exit();
    }
}

$userModel = new User();
$userModel->updateProfile($userId, $username, $profilePic);

// Update session username
$_SESSION['username'] = $username;

header("Location: ../profile.php?update=success");
exit();
