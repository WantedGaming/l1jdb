<?php
// Include configuration
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../classes/User.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Log the user out
$user->logout();

// Redirect to login page
header('Location: login.php?logout=success');
exit;
?>