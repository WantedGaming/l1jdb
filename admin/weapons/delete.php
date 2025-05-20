<?php
// Admin weapon delete confirmation page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Weapon.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Initialize weapons model
$weaponsModel = new Weapon();

// Get weapon ID from URL
$weaponId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get weapon details
$weapon = $weaponsModel->getWeaponById($weaponId);

// If weapon not found, redirect to list page
if (!$weapon) {
    header('Location: index.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $result = $weaponsModel->deleteWeapon($weaponId);
    
    if ($result['success']) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Build detailed deletion message
        $deletionDetails = "Deleted weapon: {$weapon['desc_en']} (ID: $weaponId). ";
        $deletionDetails .= "Related records deleted: ";
        $deletionDetails .= "Droplists: {$result['report']['droplist']}, ";
        $deletionDetails .= "Weapon Skills: {$result['report']['weapon_skill']}, ";
        $deletionDetails .= "Weapon Skill Models: {$result['report']['weapon_skill_model']}, ";
        $deletionDetails .= "Weapon Damage Entries: {$result['report']['weapon_damege']}";
        
        // Log activity with null-safe username and detailed deletion info
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'delete',
            $deletionDetails,
            'weapon',
            $weaponId
        );
        
        // Store deletion report in session for display on the index page
        $_SESSION['deletion_report'] = $result['report'];
        
        // Redirect to the weapons list with success message and detailed report
        header('Location: index.php?deleted=1&weapon_name=' . urlencode($weapon['desc_en']));
        exit;
    } else {
        $errorMessage = $result['message'] ?? "Failed to delete weapon. Please try again.";
    }
}

// Set page title
$pageTitle = "Confirm Delete: " . $weapon['desc_en'];

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
                        <i class="fas fa-arrow-left"></i> Back to Weapons
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
                            Are you sure you want to delete the weapon <strong><?php echo htmlspecialchars($weapon['desc_en']); ?></strong>?
                            This action cannot be undone.
                        </p>
                        
                        <div class="admin-delete-details">
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">ID:</span>
                                <span class="admin-delete-value"><?php echo $weapon['item_id']; ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Name (EN):</span>
                                <span class="admin-delete-value"><?php echo htmlspecialchars($weapon['desc_en']); ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Name (KR):</span>
                                <span class="admin-delete-value"><?php echo htmlspecialchars($weapon['desc_kr']); ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Type:</span>
                                <span class="admin-delete-value"><?php echo $weapon['type']; ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Damage:</span>
                                <span class="admin-delete-value"><?php echo $weapon['dmg_small']; ?>-<?php echo $weapon['dmg_large']; ?></span>
                            </div>
                            <div class="admin-delete-detail">
                                <span class="admin-delete-label">Grade:</span>
                                <span class="admin-delete-value"><?php echo $weapon['itemGrade']; ?></span>
                            </div>
                        </div>
                        
                        <div class="admin-alert admin-alert-warning">
                            <p><strong>Warning:</strong> This will also delete all related data:</p>
                            <ul class="admin-alert-list">
                                <li>Monster drop entries for this weapon</li>
                                <li>Weapon skills associated with this weapon</li>
                                <li>Weapon skill models for this weapon</li>
                                <li>Additional damage entries for this weapon</li>
                            </ul>
                            <p>You will receive a detailed report of deleted items after confirmation.</p>
                        </div>

<style>
.admin-alert {
    padding: 16px;
    border-radius: var(--border-radius);
}

.admin-alert p {
    margin-top: 0;
    margin-bottom: 12px;
}

.admin-alert p:last-child {
    margin-bottom: 0;
}

.admin-alert-list {
    margin: 8px 0 12px 24px;
    padding-left: 8px;
}

.admin-alert-list li {
    margin-bottom: 6px;
}

.admin-alert-list li:last-child {
    margin-bottom: 0;
}

.admin-alert-warning {
    background-color: rgba(255, 193, 7, 0.1);
    border-left: 3px solid var(--admin-warning);
    color: var(--admin-warning);
}
</style>
                    </div>
                    
                    <div class="admin-delete-actions">
                        <form action="delete.php?id=<?php echo $weaponId; ?>" method="post">
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