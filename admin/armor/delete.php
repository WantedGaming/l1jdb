<?php
// Admin armor delete confirmation page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Armor.php';
require_once '../../includes/functions.php';

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $result = $armorModel->deleteArmor($armorId);
    
    if ($result['success']) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Build detailed deletion message
        $deletionDetails = "Deleted armor: {$armor['desc_en']} (ID: $armorId). ";
        $deletionDetails .= "Related records deleted: ";
        $deletionDetails .= "Droplists: {$result['report']['droplist']}";
        
        // Log activity with null-safe username and detailed deletion info
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'delete',
            $deletionDetails,
            'armor',
            $armorId
        );
        
        // Store deletion report in session for display on the index page
        $_SESSION['deletion_report'] = $result['report'];
        
        // Redirect to the armor list with success message and detailed report
        header('Location: index.php?deleted=1&armor_name=' . urlencode($armor['desc_en']));
        exit;
    } else {
        $errorMessage = $result['message'] ?? "Failed to delete armor. Please try again.";
    }
}

// Set page title
$pageTitle = "Confirm Delete: " . cleanItemName($armor['desc_en']);

// Include admin header
include '../../includes/admin-header.php';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <div class="admin-header-actions">
                <h1 class="admin-page-title"><?php echo $pageTitle; ?></h1>
                <div class="admin-header-buttons">
                    <a href="index.php" class="admin-button admin-button-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Armor
                    </a>
                </div>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <!-- Delete Confirmation Card -->
            <div class="admin-delete-container">
                <div class="admin-delete-card">
                    <div class="admin-delete-header">
                        <i class="fas fa-exclamation-triangle admin-delete-icon"></i>
                        <h2 class="admin-delete-title">Confirm Deletion</h2>
                    </div>
                    
                    <div class="admin-delete-content">
                        <p class="admin-delete-message">
                            Are you sure you want to delete the armor <strong><?php echo htmlspecialchars(cleanItemName($armor['desc_en'])); ?></strong>?
                            This action cannot be undone.
                        </p>
                        
                        <div class="admin-delete-details">
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">ID:</span>
                                <span class="admin-delete-value"><?php echo $armor['item_id']; ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Name (EN):</span>
                                <span class="admin-delete-value"><?php echo htmlspecialchars(cleanItemName($armor['desc_en'])); ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Name (KR):</span>
                                <span class="admin-delete-value"><?php echo htmlspecialchars(cleanItemName($armor['desc_kr'])); ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Type:</span>
                                <span class="admin-delete-value"><?php echo formatArmorType($armor['type']); ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">AC:</span>
                                <span class="admin-delete-value"><?php echo $armor['ac']; ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Grade:</span>
                                <span class="admin-delete-value"><?php echo formatGrade($armor['itemGrade']); ?></span>
                            </div>
                            <?php if ($armor['Set_Id'] > 0): ?>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Set ID:</span>
                                <span class="admin-delete-value"><?php echo $armor['Set_Id']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="admin-alert admin-alert-warning">
                            <p><strong>Warning:</strong> This will also delete all related data:</p>
                            <ul class="admin-alert-list">
                                <li>Monster drop entries for this armor</li>
                            </ul>
                            <p>You will receive a detailed report of deleted items after confirmation.</p>
                        </div>
                    </div>
                    
                    <div class="admin-delete-actions">
                        <form action="delete.php?id=<?php echo $armorId; ?>" method="post">
                            <button type="submit" name="confirm_delete" value="1" class="admin-button admin-button-danger">
                                <i class="fas fa-trash-alt"></i> Confirm Delete
                            </button>
                            <a href="index.php" class="admin-button admin-button-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
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