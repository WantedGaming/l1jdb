<?php
// Admin header include file
// Gets included at the top of every admin page

// Make sure session is started
if (session_status() == PHP_SESSION_NONE) {
    init_session();
}

// Get current user if logged in
if (isset($user) && $user->isLoggedIn()) {
    $currentUser = $user->getCurrentUser();
} else {
    // Redirect to login if not logged in
    header('Location: ' . SITE_URL . '/admin/login.php');
    exit;
}

// Set default page title if not set
if (!isset($pageTitle)) {
    $pageTitle = 'Admin Dashboard - ' . SITE_NAME;
} else {
    $pageTitle = $pageTitle . ' - Admin - ' . SITE_NAME;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <!-- CSS files -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>/assets/img/favicon/favicon.ico" type="image/x-icon">
</head>
<body class="admin-body">
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container admin-header-container">
            <!-- Admin Logo -->
            <a href="<?php echo SITE_URL; ?>/admin/index.php" class="admin-logo">
                <img src="<?php echo SITE_URL; ?>/assets/img/favicon/favicon.ico" alt="<?php echo SITE_NAME; ?> Logo">
                <h1><?php echo SITE_NAME; ?> Admin</h1>
            </a>
            
            <!-- Admin Navigation -->
            <nav class="admin-nav">
                <ul class="admin-nav-list">
                    <li class="admin-nav-item">
                        <a href="<?php echo SITE_URL; ?>/admin/index.php" class="admin-nav-link">Dashboard</a>
                    </li>
                    <li class="admin-nav-item dropdown">
                        <a href="#" class="admin-nav-link dropdown-toggle">Content</a>
                        <div class="dropdown-menu">
                            <a href="<?php echo SITE_URL; ?>/admin/weapons/index.php" class="dropdown-item">Weapons</a>
                            <a href="<?php echo SITE_URL; ?>/admin/armor/index.php" class="dropdown-item">Armor</a>
                            <a href="<?php echo SITE_URL; ?>/admin/items/index.php" class="dropdown-item">Items</a>
                            <a href="<?php echo SITE_URL; ?>/admin/maps/index.php" class="dropdown-item">Maps</a>
                            <a href="<?php echo SITE_URL; ?>/admin/monsters/index.php" class="dropdown-item">Monsters</a>
                            <a href="<?php echo SITE_URL; ?>/admin/dolls/index.php" class="dropdown-item">Dolls</a>
                        </div>
                    </li>
                    <li class="admin-nav-item">
                        <a href="<?php echo SITE_URL; ?>/admin/activity/index.php" class="admin-nav-link">Activity Log</a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="<?php echo SITE_URL; ?>" class="admin-nav-link">View Site</a>
                    </li>
                </ul>
                
                <!-- Admin User Dropdown -->
                <div class="admin-user-dropdown dropdown">
                    <div class="dropdown-toggle">
                        <img src="<?php echo SITE_URL; ?>/assets/img/favicon/12650.png" alt="Admin" class="admin-user-img">
                        <span class="admin-user-name"><?php echo htmlspecialchars($currentUser['login']); ?></span>
                    </div>
                    <div class="dropdown-menu">
                        <a href="<?php echo SITE_URL; ?>/admin/logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Admin Scripts -->
        <script src="<?php echo SITE_URL; ?>/assets/js/admin.js"></script>
        <script src="<?php echo SITE_URL; ?>/assets/js/error-monitor.js"></script>
    </header>
