<?php
// Admin monsters deletion page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Monster.php';
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

// Initialize monsters model
$monstersModel = new Monster();

// Get monster ID from URL
$monsterId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($monsterId <= 0) {
    header('Location: index.php?error=Invalid monster ID');
    exit;
}

// Get existing monster data
$monster = $monstersModel->getMonsterById($monsterId);
if (!$monster) {
    header('Location: index.php?error=Monster not found');
    exit;
}

// Handle deletion confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $result = $monstersModel->deleteMonster($monsterId);
    
    if ($result) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Log activity
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'delete',
            "Deleted monster: {$monster['desc_en']} (ID: $monsterId)",
            'monster',
            $monsterId
        );
        
        // Redirect to index with success message
        header('Location: index.php?deleted=1&monster_name=' . urlencode($monster['desc_en']));
        exit;
    } else {
        $errorMessage = "Failed to delete monster. Please try again.";
    }
}

// Include admin header
include '../../includes/admin-header.php';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <div class="admin-header-actions">
                <h1 class="admin-page-title">Delete Monster</h1>
                <a href="index.php" class="admin-button admin-button-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Monsters
                </a>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
            <?php endif; ?>
            
            <div class="admin-delete-confirmation">
                <div class="admin-delete-monster-info">
                    <div class="admin-delete-icon">
                        <?php if ($monster['spriteId']): ?>
                        <img src="../../assets/img/icons/ms<?php echo $monster['spriteId']; ?>.png" 
                             alt="Monster <?php echo htmlspecialchars($monster['desc_en']); ?>" 
                             class="admin-monster-icon-large"
                             onerror="this.src='../../assets/img/placeholders/monster.png'">
                        <?php else: ?>
                        <img src="../../assets/img/placeholders/monster.png" alt="No image" class="admin-monster-icon-large">
                        <?php endif; ?>
                    </div>
                    
                    <div class="admin-delete-details">
                        <h2><?php echo htmlspecialchars($monster['desc_en']); ?></h2>
                        <?php if (!empty($monster['desc_kr'])): ?>
                        <p class="admin-monster-kr-name"><?php echo htmlspecialchars($monster['desc_kr']); ?></p>
                        <?php endif; ?>
                        
                        <div class="admin-monster-stats">
                            <div class="admin-stat-item">
                                <span class="admin-stat-label">ID:</span>
                                <span class="admin-stat-value"><?php echo $monster['npcid']; ?></span>
                            </div>
                            <div class="admin-stat-item">
                                <span class="admin-stat-label">Level:</span>
                                <span class="admin-stat-value"><?php echo $monster['lvl']; ?></span>
                            </div>
                            <div class="admin-stat-item">
                                <span class="admin-stat-label">HP:</span>
                                <span class="admin-stat-value"><?php echo number_format($monster['hp']); ?></span>
                            </div>
                            <div class="admin-stat-item">
                                <span class="admin-stat-label">Experience:</span>
                                <span class="admin-stat-value"><?php echo number_format($monster['exp']); ?></span>
                            </div>
                            <div class="admin-stat-item">
                                <span class="admin-stat-label">Type:</span>
                                <span class="admin-stat-value"><?php echo htmlspecialchars($monster['impl']); ?></span>
                            </div>
                            <?php if (!empty($monster['family'])): ?>
                            <div class="admin-stat-item">
                                <span class="admin-stat-label">Family:</span>
                                <span class="admin-stat-value"><?php echo htmlspecialchars($monster['family']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="admin-delete-warning">
                    <div class="admin-warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="admin-warning-content">
                        <h3>Warning: This action cannot be undone!</h3>
                        <p>You are about to permanently delete this monster from the database. This will:</p>
                        <ul>
                            <li>Remove the monster record completely</li>
                            <li>Remove any associated spawn data</li>
                            <li>Remove any associated drop lists</li>
                            <li>Remove any related skill or behavior data</li>
                        </ul>
                        <p><strong>Are you absolutely sure you want to proceed?</strong></p>
                    </div>
                </div>
                
                <div class="admin-delete-actions">
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="confirm_delete" value="1">
                        <button type="submit" class="admin-button admin-button-danger admin-button-large">
                            <i class="fas fa-trash"></i> Yes, Delete Monster
                        </button>
                    </form>
                    
                    <a href="index.php" class="admin-button admin-button-secondary admin-button-large">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    
                    <a href="edit.php?id=<?php echo $monster['npcid']; ?>" class="admin-button admin-button-primary admin-button-large">
                        <i class="fas fa-edit"></i> Edit Instead
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.admin-delete-confirmation {
    max-width: 800px;
    margin: 0 auto;
    background: #fff;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.admin-delete-monster-info {
    display: flex;
    align-items: flex-start;
    gap: 2rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #eee;
}

.admin-delete-icon {
    flex-shrink: 0;
}

.admin-delete-details h2 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.admin-monster-kr-name {
    color: #666;
    font-style: italic;
    margin-bottom: 1rem;
}

.admin-monster-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 0.5rem;
}

.admin-stat-item {
    display: flex;
    justify-content: space-between;
    padding: 0.25rem 0;
}

.admin-stat-label {
    font-weight: 600;
    color: #555;
}

.admin-stat-value {
    color: #333;
}

.admin-delete-warning {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 4px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.admin-warning-icon {
    color: #856404;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.admin-warning-content h3 {
    margin: 0 0 1rem 0;
    color: #856404;
}

.admin-warning-content p {
    margin-bottom: 1rem;
    color: #856404;
}

.admin-warning-content ul {
    margin-bottom: 1rem;
    color: #856404;
}

.admin-warning-content ul li {
    margin-bottom: 0.5rem;
}

.admin-delete-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.admin-button-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .admin-delete-monster-info {
        flex-direction: column;
        text-align: center;
    }
    
    .admin-monster-stats {
        grid-template-columns: 1fr;
    }
    
    .admin-delete-actions {
        flex-direction: column;
    }
    
    .admin-button-large {
        width: 100%;
    }
}
</style>

<?php include '../../includes/admin-footer.php'; ?> 