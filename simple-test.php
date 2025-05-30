<?php
// Simplest possible test - just header and footer
require_once __DIR__ . '/config/config.php';
init_session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Test</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/main.css">
</head>
<body>
    <h1>Simple Test Page</h1>
    <p>This is a simple test to see if the basic setup works.</p>
    <p>BASE_URL: <?php echo BASE_URL; ?></p>
    <p>SITE_URL: <?php echo SITE_URL; ?></p>
</body>
</html>