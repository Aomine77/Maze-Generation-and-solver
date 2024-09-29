<?php
session_start();
session_destroy();  // Destroy the session
header('Location: Authentication/login.php');  // Redirect to the login page
exit();
?>
