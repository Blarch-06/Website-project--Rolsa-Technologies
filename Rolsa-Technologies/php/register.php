<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the email already exists in the database
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$checkStmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Email already exists
        header("Location: ../register.html?error=email_in_use");
        exit;
    }
    $checkStmt->close();

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        // Redirect to a styled success page
        header("Location: registration-success.php");
        exit;
    } else {
        die("Error executing statement: " . $stmt->error);
    }
}
?>