<?php
// Start the session if not already started
session_start();

// Clear all session variables
session_unset(); 

// Destroy the session
session_destroy();

// Redirect to home page (or login page) after logout
header('Location: home.php');  // Change this to 'login.php' if you want to redirect to the login page
exit();
?>
