<?php
// Start session to access session variables
session_start();

// Destroy the session to log out the user
session_destroy();

// Set logout message
$logOutmsg = "You have been logged out successfully.";

// Redirect to login page with logout message
header("Location: ../frontend/login.php?success=" . urlencode($logOutmsg));
exit();
?>