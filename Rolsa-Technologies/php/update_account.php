<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Update email
$stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
$stmt->bind_param("si", $email, $user_id);
$stmt->execute();
$stmt->close();

// Update password if provided
if (!empty($password)) {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
    $stmt->bind_param("si", $password_hash, $user_id);
    $stmt->execute();
    $stmt->close();
}

$_SESSION['success'] = "Account updated successfully.";
header("Location: dashboard.php");
exit;
?>