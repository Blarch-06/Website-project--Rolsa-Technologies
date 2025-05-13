<?php
$host = 'localhost';
$db = 'rolsa_technologies'; // Your database name
$user = 'root'; // Default XAMPP username
$pass = ''; // Default XAMPP password (leave blank)

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>