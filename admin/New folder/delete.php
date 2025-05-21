<?php
// Admin armor delete confirmation page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Armor.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Initialize armor model
$armorModel = new Armor();

// Get armor ID from URL
$armorId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get armor details
$armor = $armorModel->getArmorById($armorId);

// If armor not found, redirect to list page
if (!$armor) {
    header('Location: index.php');
    exit;
}

// Handle delete confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if ($armorModel->deleteArmor($armorId)) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Log activity with null-safe username
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'delete',
            "Deleted armor: {$armor['desc_en']} (ID: $armorId)",
            'armor',
            $armorId
        );
        
        // Redirect to index page with success message
        header('Location: index.php?deleted=1');
        exit;
    } else {
        $errorMessage = "Failed to delete armor. Please try again.";
    }
}

// Set page title
$pageTitle = "Delete Armor: " . $armor['desc_en'];

// Include admin header
include '../../includes/admin-header.php';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <div class="admin-delete-container">
                <div class="admin-delete-card">
                    <div class="admin-delete-header">
                        <i class="fas fa-exclamation-triangle admin-delete-icon"></i>
                        <h2 class="admin-delete-title">Delete Armor Item</h2>
                    </div>
                    
                    <div class="admin-delete-content">
                        <?php if (isset($errorMessage)): ?>
                        <div class="admin-alert admin-alert-danger">
                            <?php echo $errorMessage; ?>
                        </div>
                        <?php endif; ?>
                        
                        <p class="admin-delete-message">
                            Are you sure you want to delete this armor item? This action cannot be undone.
                        </p>
                        
                        <div class="admin-delete-details">
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">ID:</span>
                                <span class="admin-delete-value"><?php echo $armor['item_id']; ?></span>
                            </div>
                            
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Name (EN):</span>
                                <span class="admin-delete-value"><?php echo htmlspecialchars($armor['desc_en']); ?></span>
                            </div>
                            
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Name (KR):</span>
                                <span class="admin-delete-value"><?php echo htmlspecialchars($armor['desc_kr'] ?? ''); ?></span>
                            </div>
                            
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Type:</span>
                                <span class="admin-delete-value"><?php echo $armor['type']; ?></span>
                            </div>
                            
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Grade:</span>
                                <span class="admin-delete-value"><?php echo $armor['itemGrade']; ?></span>
                            </div>
                            
                            <?php if ($armor['Set_Id'] > 0): ?>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Set ID:</span>
                                <span class="admin-delete-value"><?php echo $armor['Set_Id']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="admin-delete-actions">
                        <form action="delete.php?id=<?php echo $armorId; ?>" method="post">
                            <a href="index.php" class="admin-button admin-button-secondary">Cancel</a>
                            <button type="submit" name="confirm_delete" value="1" class="admin-button admin-button-danger">Delete Permanently</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>