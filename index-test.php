<?php
// Simple test index.php to diagnose the issue
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Testing Basic Components</h1>";

// Test config
require_once __DIR__ . '/config/config.php';
echo "<p>✓ Config loaded</p>";

// Test database
require_once __DIR__ . '/config/database.php';
$db = Database::getInstance();
echo "<p>✓ Database connected</p>";

// Initialize session
init_session();
echo "<p>✓ Session initialized</p>";

// Include header
include 'includes/header.php';
?>

<main>
    <section class="section">
        <div class="container">
            <h2>Database Test</h2>
            <p>If you can see this, the basic components are working.</p>
        </div>
    </section>
</main>

<?php
// Include footer
include 'includes/footer.php';
?>