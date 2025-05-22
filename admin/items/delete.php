<?php
// Admin item delete page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Item.php';
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

// Initialize item model
$itemModel = new Item();

// Get item ID from URL
$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get item details
$item = $itemModel->getItemById($itemId);

// If item not found, redirect to list page
if (!$item) {
    header('Location: index.php');
    exit;
}

// Handle delete confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if ($itemModel->deleteItem($itemId)) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Log activity with null-safe username
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'delete',
            "Deleted item: {$item['desc_en']} (ID: $itemId)",
            'item',
            $itemId
        );
        
        // Redirect to items list with success message
        header('Location: index.php?deleted=1');
        exit;
    } else {
        $errorMessage = "Failed to delete item. Please try again.";
    }
}

// Set page title
$pageTitle = "Delete Item: " . cleanItemName($item['desc_en']);

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
                        <i class="fas fa-arrow-left"></i> Back to Items
                    </a>
                    <a href="../../public/items/detail.php?id=<?php echo $itemId; ?>" class="admin-button admin-button-info">
                        <i class="fas fa-eye"></i> View Item
                    </a>
                </div>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <!-- Delete Confirmation -->
            <div class="admin-delete-container">
                <div class="admin-delete-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h2>Are you sure you want to delete this item?</h2>
                    <p>This action cannot be undone. The item will be permanently removed from the database.</p>
                </div>
                
                <!-- Item Preview -->
                <div class="admin-delete-preview">
                    <div class="admin-detail-layout">
                        <!-- Image Card -->
                        <div class="admin-image-card">
                            <h3 class="admin-form-header">Item Preview</h3>
                            <div class="admin-image-container">
                                <img src="<?php echo getItemIconUrl($item['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?>" class="admin-image-large">
                                <div class="admin-status-indicator success">Icon: <?php echo $item['iconId']; ?></div>
                            </div>
                        </div>
                        
                        <!-- Basic Info Card -->
                        <div class="admin-form-section" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none; background-color: var(--admin-dark);">
                            <h3 class="admin-form-header">Basic Information</h3>
                            
                            <div class="admin-detail-info">
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Item ID:</div>
                                    <div class="admin-detail-value"><?php echo $item['item_id']; ?></div>
                                </div>
                                
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Name (English):</div>
                                    <div class="admin-detail-value"><?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?></div>
                                </div>
                                
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Name (Korean):</div>
                                    <div class="admin-detail-value"><?php echo htmlspecialchars(cleanItemName($item['desc_kr'] ?? 'N/A')); ?></div>
                                </div>
                                
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Item Type:</div>
                                    <div class="admin-detail-value"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['item_type']))); ?></div>
                                </div>
                                
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Use Type:</div>
                                    <div class="admin-detail-value"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['use_type']))); ?></div>
                                </div>
                                
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Material:</div>
                                    <div class="admin-detail-value"><?php echo formatMaterial($item['material']); ?></div>
                                </div>
                                
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Grade:</div>
                                    <div class="admin-detail-value"><?php echo formatArmorGrade($item['itemGrade']); ?></div>
                                </div>
                                
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Weight:</div>
                                    <div class="admin-detail-value"><?php echo $item['weight']; ?></div>
                                </div>
                                
                                <?php if (isset($item['max_charge_count']) && $item['max_charge_count'] > 0): ?>
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Max Charges:</div>
                                    <div class="admin-detail-value"><?php echo $item['max_charge_count']; ?></div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($item['note'])): ?>
                                <div class="admin-detail-row">
                                    <div class="admin-detail-label">Description:</div>
                                    <div class="admin-detail-value"><?php echo nl2br(htmlspecialchars($item['note'])); ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Item Stats (if any non-zero values exist) -->
                <div class="admin-form-section">
                    <h3 class="admin-form-section-title">Additional Properties</h3>
                    
                    <div class="admin-stats-grid">
                        <?php
                        // Combat stats
                        $combatStats = [
                            'Small Damage' => $item['dmg_small'] ?? 0,
                            'Large Damage' => $item['dmg_large'] ?? 0,
                            'Short Hit' => $item['shortHit'] ?? 0,
                            'Long Hit' => $item['longHit'] ?? 0,
                            'Short Damage' => $item['shortDmg'] ?? 0,
                            'Long Damage' => $item['longDmg'] ?? 0
                        ];
                        
                        // Stat bonuses
                        $statBonuses = [
                            'STR' => $item['add_str'] ?? 0,
                            'CON' => $item['add_con'] ?? 0,
                            'DEX' => $item['add_dex'] ?? 0,
                            'INT' => $item['add_int'] ?? 0,
                            'WIS' => $item['add_wis'] ?? 0,
                            'CHA' => $item['add_cha'] ?? 0,
                            'HP' => $item['add_hp'] ?? 0,
                            'MP' => $item['add_mp'] ?? 0,
                            'HP Regen' => $item['add_hpr'] ?? 0,
                            'MP Regen' => $item['add_mpr'] ?? 0,
                            'SP' => $item['add_sp'] ?? 0
                        ];
                        
                        // Resistances
                        $resistances = [
                            'Stone Resist' => $item['regist_stone'] ?? 0,
                            'Sleep Resist' => $item['regist_sleep'] ?? 0,
                            'Freeze Resist' => $item['regist_freeze'] ?? 0,
                            'Blind Resist' => $item['regist_blind'] ?? 0,
                            'Skill Resist' => $item['regist_skill'] ?? 0,
                            'Spirit Resist' => $item['regist_spirit'] ?? 0,
                            'Dragon Resist' => $item['regist_dragon'] ?? 0,
                            'Fear Resist' => $item['regist_fear'] ?? 0,
                            'All Resist' => $item['regist_all'] ?? 0
                        ];
                        
                        // Combine all stats
                        $allStats = array_merge($combatStats, $statBonuses, $resistances);
                        
                        // Filter out zero values
                        $nonZeroStats = array_filter($allStats, function($value) {
                            return $value != 0;
                        });
                        
                        if (!empty($nonZeroStats)):
                            foreach ($nonZeroStats as $statName => $statValue): ?>
                            <div class="admin-stat-item">
                                <span class="admin-stat-label"><?php echo $statName; ?>:</span>
                                <span class="admin-stat-value"><?php echo $statValue; ?></span>
                            </div>
                            <?php endforeach;
                        else: ?>
                        <p class="admin-no-stats">No additional stats or bonuses.</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Item Properties -->
                    <div class="admin-properties-section">
                        <h4>Item Properties:</h4>
                        <div class="admin-property-badges">
                            <?php if ($item['bless']): ?>
                            <span class="admin-property-badge positive">Blessed</span>
                            <?php endif; ?>
                            
                            <?php if ($item['trade']): ?>
                            <span class="admin-property-badge negative">Cannot Trade</span>
                            <?php endif; ?>
                            
                            <?php if ($item['retrieve']): ?>
                            <span class="admin-property-badge negative">Cannot Store</span>
                            <?php endif; ?>
                            
                            <?php if ($item['specialretrieve']): ?>
                            <span class="admin-property-badge negative">Cannot Store Special</span>
                            <?php endif; ?>
                            
                            <?php if ($item['cant_delete']): ?>
                            <span class="admin-property-badge negative">Cannot Delete</span>
                            <?php endif; ?>
                            
                            <?php if ($item['cant_sell']): ?>
                            <span class="admin-property-badge negative">Cannot Sell</span>
                            <?php endif; ?>
                            
                            <?php if ($item['merge'] === 'true'): ?>
                            <span class="admin-property-badge positive">Stackable</span>
                            <?php endif; ?>
                            
                            <?php if ($item['poisonRegist'] === 'true'): ?>
                            <span class="admin-property-badge positive">Poison Resistant</span>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['Magic_name'])): ?>
                            <span class="admin-property-badge magic">Magic: <?php echo htmlspecialchars($item['Magic_name']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Form -->
                <form method="post" class="admin-delete-form">
                    <div class="admin-form-buttons">
                        <a href="index.php" class="admin-button admin-button-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <a href="edit.php?id=<?php echo $itemId; ?>" class="admin-button admin-button-primary">
                            <i class="fas fa-edit"></i> Edit Instead
                        </a>
                        <button type="submit" name="confirm_delete" class="admin-button admin-button-danger" onclick="return confirm('Are you absolutely sure you want to delete this item? This action cannot be undone!');">
                            <i class="fas fa-trash-alt"></i> Delete Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<style>
.admin-delete-container {
    max-width: 1000px;
    margin: 0 auto;
}

.admin-delete-warning {
    background-color: #dc3545;
    color: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 30px;
}

.admin-delete-warning i {
    font-size: 3rem;
    margin-bottom: 15px;
    display: block;
}

.admin-delete-warning h2 {
    margin: 0 0 10px 0;
    font-size: 1.5rem;
}

.admin-delete-warning p {
    margin: 0;
    font-size: 1.1rem;
    opacity: 0.9;
}

.admin-delete-preview {
    margin-bottom: 30px;
}

.admin-detail-info {
    display: grid;
    gap: 15px;
}

.admin-detail-row {
    display: grid;
    grid-template-columns: 150px 1fr;
    gap: 15px;
    padding: 10px 0;
    border-bottom: 1px solid var(--admin-border);
}

.admin-detail-row:last-child {
    border-bottom: none;
}

.admin-detail-label {
    font-weight: 600;
    color: var(--admin-text-muted);
}

.admin-detail-value {
    color: var(--admin-text);
}

.admin-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.admin-stat-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 12px;
    background-color: var(--admin-background);
    border: 1px solid var(--admin-border);
    border-radius: 4px;
}

.admin-stat-label {
    font-weight: 500;
    color: var(--admin-text-muted);
}

.admin-stat-value {
    font-weight: 600;
    color: var(--admin-primary);
}

.admin-no-stats {
    color: var(--admin-text-muted);
    font-style: italic;
    text-align: center;
    padding: 20px;
}

.admin-properties-section {
    margin-top: 20px;
}

.admin-properties-section h4 {
    margin-bottom: 10px;
    color: var(--admin-text);
}

.admin-property-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.admin-property-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

.admin-property-badge.positive {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.admin-property-badge.negative {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.admin-property-badge.magic {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.admin-delete-form {
    background-color: var(--admin-card-background);
    padding: 20px;
    border-radius: 8px;
    border: 2px dashed #dc3545;
}

.admin-form-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
}

@media (max-width: 768px) {
    .admin-detail-row {
        grid-template-columns: 1fr;
        gap: 5px;
    }
    
    .admin-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-form-buttons {
        flex-direction: column;
    }
}
</style>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>