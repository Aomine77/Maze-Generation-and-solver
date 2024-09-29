<?php
include 'authentication/config.php';
include 'authentication/session.php';

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Delete the user from the database
$delete_sql = "DELETE FROM maze_user WHERE user_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $user_id);
$delete_stmt->execute();
$delete_stmt->close();

// Log the user out and redirect to the login page or goodbye page
session_destroy();
header('Location: Authentication/login.php');
exit();
?>
