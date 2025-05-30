<?php
// includes/header.php
// Main header template with dropdown navigation

// Get current page for active navigation
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$current_dir = basename(dirname($_SERVER['PHP_SELF']));

// Helper function to check if nav item is active
function isNavActive($page, $section = '') {
    global $current_page, $current_dir;
    
    if ($section && $current_dir === $section) {
        return true;
    }
    
    return $current_page === $page;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>MMORPG Database</title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/main.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>assets/img/favicon.ico">
    
    <?php if (isset($additional_css)): ?>
        <?php foreach ($additional_css as $css): ?>
            <link rel="stylesheet" href="<?php echo BASE_URL . $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-container">
                <!-- Logo -->
                <a href="<?php echo BASE_URL; ?>" class="logo">
                    <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="L1J-R Database Logo">
                    <h1>L1J-R DB</h1>
                </a>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-button" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Main Navigation -->
                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item <?php echo isNavActive('index') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE_URL; ?>" class="nav-link">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        
                        <li class="nav-item <?php echo (in_array($current_dir, ['weapons', 'armor', 'items', 'maps', 'monsters', 'dolls'])) ? 'active' : ''; ?>">
                            <a href="#" class="nav-link has-dropdown">
                                <i class="fas fa-database"></i> Database
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="<?php echo BASE_URL; ?>public/weapons/" class="dropdown-item">
                                    <i class="fas fa-sword"></i> Weapons
                                </a>
                                <a href="<?php echo BASE_URL; ?>public/armor/" class="dropdown-item">
                                    <i class="fas fa-shield-alt"></i> Armor
                                </a>
                                <a href="<?php echo BASE_URL; ?>public/items/" class="dropdown-item">
                                    <i class="fas fa-gem"></i> Items
                                </a>
                                <a href="<?php echo BASE_URL; ?>public/maps/" class="dropdown-item">
                                    <i class="fas fa-map"></i> Maps
                                </a>
                                <a href="<?php echo BASE_URL; ?>public/monsters/" class="dropdown-item">
                                    <i class="fas fa-dragon"></i> Monsters
                                </a>
                                <a href="<?php echo BASE_URL; ?>public/dolls/" class="dropdown-item">
                                    <i class="fas fa-chess-pawn"></i> Dolls
                                </a>
                            </div>
                        </li>
                        
                        <li class="nav-item <?php echo ($current_dir === 'admin') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE_URL; ?>admin/" class="nav-link">
                                <i class="fas fa-cog"></i> Admin
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User Profile -->
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-profile">
                    <div class="user-avatar">
                        <img src="<?php echo BASE_URL; ?>assets/img/avatars/default.png" alt="User Avatar">
                    </div>
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </div>
                <?php else: ?>
                <div class="user-profile">
                    <a href="<?php echo BASE_URL; ?>login.php" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <nav class="nav-mobile" id="mobileNav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>" class="nav-link">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-database"></i> Database
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="<?php echo BASE_URL; ?>public/weapons/" class="dropdown-item">
                            <i class="fas fa-sword"></i> Weapons
                        </a>
                        <a href="<?php echo BASE_URL; ?>public/armor/" class="dropdown-item">
                            <i class="fas fa-shield-alt"></i> Armor
                        </a>
                        <a href="<?php echo BASE_URL; ?>public/items/" class="dropdown-item">
                            <i class="fas fa-gem"></i> Items
                        </a>
                        <a href="<?php echo BASE_URL; ?>public/maps/" class="dropdown-item">
                            <i class="fas fa-map"></i> Maps
                        </a>
                        <a href="<?php echo BASE_URL; ?>public/monsters/" class="dropdown-item">
                            <i class="fas fa-dragon"></i> Monsters
                        </a>
                        <a href="<?php echo BASE_URL; ?>public/dolls/" class="dropdown-item">
                            <i class="fas fa-chess-pawn"></i> Dolls
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>admin/" class="nav-link">
                        <i class="fas fa-cog"></i> Admin
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>profile.php" class="nav-link">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>login.php" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BASE_URL; ?>register.php" class="nav-link">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobileNav');
            mobileNav.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileNav = document.getElementById('mobileNav');
            const mobileButton = document.querySelector('.mobile-menu-button');
            
            if (!mobileNav.contains(event.target) && !mobileButton.contains(event.target)) {
                mobileNav.classList.remove('active');
            }
        });

        // Handle dropdown clicks on mobile
        document.querySelectorAll('.nav-mobile .nav-link.has-dropdown').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const dropdown = this.nextElementSibling;
                const isOpen = dropdown.classList.contains('active');
                
                // Close all other dropdowns
                document.querySelectorAll('.nav-mobile .dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('active');
                });
                
                // Toggle this dropdown
                if (!isOpen) {
                    dropdown.classList.add('active');
                } else {
                    dropdown.classList.remove('active');
                }
            });
        });
    </script>