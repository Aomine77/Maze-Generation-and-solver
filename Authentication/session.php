<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: Authentication/login.php");
    exit();
}

// If logged in, the script continues and the user can access the page
?>
