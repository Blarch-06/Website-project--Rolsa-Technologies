<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Clear the login cookie
setcookie("user_logged_in", "", time() - 3600, "/"); // Expire the cookie

// Redirect to the login page
header("Location: ../login.html");
exit;
?>