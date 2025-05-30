<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "PHP is working!<br>";
echo "PHP Version: " . phpversion() . "<br>";

// Test database configuration
require_once 'config/config.php';
echo "Config loaded successfully<br>";

// Test database connection
try {
    require_once 'config/database.php';
    $db = Database::getInstance();
    echo "Database connection successful<br>";
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "<br>";
}

// Test includes
try {
    require_once 'includes/functions.php';
    echo "Functions loaded successfully<br>";
} catch (Exception $e) {
    echo "Functions error: " . $e->getMessage() . "<br>";
}

phpinfo();
?>