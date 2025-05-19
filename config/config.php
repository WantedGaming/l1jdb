<?php
// Database Connection Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'l1j_remastered');
define('DB_USER', 'root');
define('DB_PASS', '');
define('CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'L1J-R Database');
define('SITE_URL', 'http://localhost/l1jdb/');
define('ADMIN_EMAIL', 'admin@example.com');

// Pagination Settings
define('ITEMS_PER_PAGE', 12);

// File Upload Settings
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/assets/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Session Settings
define('SESSION_NAME', 'l1jdb_session');
define('SESSION_LIFETIME', 7200); // 2 hours in seconds

// Security Settings
define('HASH_COST', 12); // For password_hash

// Error Reporting Settings
define('DISPLAY_ERRORS', true); // Set to false in production

// Set timezone
date_default_timezone_set('UTC');

// config/config.php - Add this with your other configuration constants
define('DEV_MODE', true); // Set to false in production
define('ERROR_MONITOR_ENABLED', DEV_MODE); // Enable error monitoring in development

// Categories
define('CATEGORIES', [
    'weapons' => 'Weapons',
    'armor' => 'Armor',
    'items' => 'Items',
    'maps' => 'Maps',
    'monsters' => 'Monsters',
    'dolls' => 'Dolls'
]);

// Admin Activity Types
define('ACTIVITY_TYPES', [
    'login' => 'Login',
    'logout' => 'Logout',
    'create' => 'Create',
    'update' => 'Update',
    'delete' => 'Delete',
    'view' => 'View'
]);

// Initialize error reporting based on configuration
if (DISPLAY_ERRORS) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Add this to ensure the logs directory exists
$logDir = __DIR__ . '/../logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// Remove the problematic line:
// error_log($error_message, 3, $logDir . '/error.log');

// Initialize session
function init_session() {
    session_name(SESSION_NAME);
    session_start([
        'cookie_lifetime' => SESSION_LIFETIME,
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Lax'
    ]);
}

// Custom error handler
function custom_error_handler($errno, $errstr, $errfile, $errline) {
    $error_message = date('Y-m-d H:i:s') . " Error: [$errno] $errstr in $errfile on line $errline\n";
    error_log($error_message, 3, $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/logs/error.log');
    
    if (DISPLAY_ERRORS) {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 4px;'>";
        echo "<strong>Error:</strong> $errstr in $errfile on line $errline";
        echo "</div>";
    }
    
    return true;
}

// Set custom error handler
set_error_handler('custom_error_handler');
