<?php
// Header include file
// Gets included at the top of every public-facing page

// Make sure session is started
if (session_status() == PHP_SESSION_NONE) {
    init_session();
}

// Check if user is logged in
$isLoggedIn = isset($user) && $user->isLoggedIn();
$isAdmin = $isLoggedIn && $user->isAdmin();

// Get current user if logged in
$currentUser = null;
if ($isLoggedIn) {
    $currentUser = $user->getCurrentUser();
}

// Set default page title if not set
if (!isset($pageTitle)) {
    $pageTitle = SITE_NAME;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>/assets/img/favicon/favicon.ico" type="image/x-icon">
	
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container header-container">
            <!-- Logo -->
            <a href="<?php echo SITE_URL; ?>" class="logo">
                <img src="<?php echo SITE_URL; ?>/assets/img/favicon/favicon.ico" alt="<?php echo SITE_NAME; ?> Logo">
                <h1><?php echo SITE_NAME; ?></h1>
            </a>
            
            <!-- Navigation -->
            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">Database</a>
                        <div class="dropdown-menu">
                            <a href="<?php echo SITE_URL; ?>/public/weapons/index.php" class="dropdown-item">Weapons</a>
                            <a href="<?php echo SITE_URL; ?>/public/armor/index.php" class="dropdown-item">Armor</a>
                            <a href="<?php echo SITE_URL; ?>/public/items/index.php" class="dropdown-item">Items</a>
                            <a href="<?php echo SITE_URL; ?>/public/maps/index.php" class="dropdown-item">Maps</a>
                            <a href="<?php echo SITE_URL; ?>/public/monsters/index.php" class="dropdown-item">Monsters</a>
                            <a href="<?php echo SITE_URL; ?>/public/dolls/index.php" class="dropdown-item">Dolls</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo SITE_URL; ?>/public/search.php" class="nav-link">Advanced Search</a>
                    </li>
                    <?php if ($isAdmin): ?>
                    <li class="nav-item">
                        <a href="<?php echo SITE_URL; ?>/admin/index.php" class="nav-link">Admin Dashboard</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">Account</a>
                        <div class="dropdown-menu">
                            <?php if ($isLoggedIn && $currentUser): ?>
                            <span class="dropdown-item user-greeting">Hello, <?php echo htmlspecialchars($currentUser['login']); ?></span>
                            <a href="<?php echo SITE_URL; ?>/admin/logout.php" class="dropdown-item">Logout</a>
                            <?php else: ?>
                            <a href="<?php echo SITE_URL; ?>/admin/login.php" class="dropdown-item">Admin Login</a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
