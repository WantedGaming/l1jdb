<?php
// Footer include file
// Gets included at the bottom of every public-facing page
?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-container">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="<?php echo SITE_URL; ?>/assets/img/favicon/favicon.ico" alt="<?php echo SITE_NAME; ?> Logo">
                    </div>
                    <p class="footer-text">
                        <?php echo SITE_NAME; ?> is a comprehensive database website for the MMORPG game world.
                        Explore weapons, armor, items, maps, monsters, and magical dolls.
                    </p>
                </div>
                
                <div class="footer-section">
                    <h3 class="footer-title">Database Categories</h3>
                    <ul class="footer-links">
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/public/weapons/index.php">Weapons</a></li>
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/public/armor/index.php">Armor</a></li>
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/public/items/index.php">Items</a></li>
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/public/maps/index.php">Maps</a></li>
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/public/monsters/index.php">Monsters</a></li>
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/public/dolls/index.php">Dolls</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/public/search.php">Advanced Search</a></li>
                        <li class="footer-link"><a href="<?php echo SITE_URL; ?>/admin/login.php">Admin Login</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
