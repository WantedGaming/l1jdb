<?php
// Admin footer include file
// Gets included at the bottom of every admin page
?>

    <!-- Admin Footer -->
    <footer class="admin-footer">
        <div class="container">
            <div class="admin-footer-content">
                <p class="admin-footer-text">
                    &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> Admin Panel
                </p>
                <p class="admin-footer-version">
                    Version 1.0.0
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Admin Scripts -->
    <script src="<?php echo SITE_URL; ?>/assets/js/admin.js"></script>
</body>
</html>
