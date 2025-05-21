<?php
// Admin bin_item_common detail view
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

// Get name ID from URL
$nameId = isset($_GET['name_id']) ? (int)$_GET['name_id'] : 0;

// Get bin data
$binData = $armorModel->getBinItemData($nameId);

// If bin data not found, redirect to list page
if (!$binData) {
    header('Location: index.php');
    exit;
}

// Get all armor items related to this bin data
$relatedArmor = $armorModel->getArmorByNameId($nameId);

// Set page title
$pageTitle = "Bin Data: ID " . $nameId;

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
            
            <!-- Bin Data Details -->
            <div class="admin-detail-card">
                <div class="admin-detail-section">
                    <h2 class="admin-detail-title">Bin Item Common Details</h2>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Name ID</div>
                        <div class="admin-detail-value"><?php echo $binData['name_id']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Icon ID</div>
                        <div class="admin-detail-value">
                            <?php echo $binData['icon_id']; ?>
                            <?php if (!empty($binData['icon_id'])): ?>
                            <img src="<?php echo $armorModel->getArmorIconUrl($binData['icon_id']); ?>" alt="Icon" class="admin-detail-icon">
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Sprite ID</div>
                        <div class="admin-detail-value"><?php echo $binData['sprite_id']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Description ID</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($binData['desc_id'] ?? 'None'); ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Real Description</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($binData['real_desc'] ?? 'None'); ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Korean Description</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($binData['desc_kr'] ?? 'None'); ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Material</div>
                        <div class="admin-detail-value"><?php echo $binData['material']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Weight (per 1000)</div>
                        <div class="admin-detail-value"><?php echo $binData['weight_1000ea']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Real Weight</div>
                        <div class="admin-detail-value"><?php echo $binData['real_weight']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Level Limit</div>
                        <div class="admin-detail-value">
                            Min: <?php echo $binData['level_limit_min']; ?> 
                            Max: <?php echo $binData['level_limit_max']; ?>
                        </div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Body Part</div>
                        <div class="admin-detail-value"><?php echo $binData['body_part']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">AC</div>
                        <div class="admin-detail-value"><?php echo $binData['ac']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Cost</div>
                        <div class="admin-detail-value"><?php echo $binData['cost']; ?></div>
                    </div>
                    
                    <div class="admin-detail-row">
                        <div class="admin-detail-label">Item Category</div>
                        <div class="admin-detail-value"><?php echo $binData['item_category']; ?></div>
                    </div>
                </div>

                <div class="admin-detail-section">
                    <h3 class="admin-detail-subtitle">Class Restrictions</h3>
                    
                    <div class="admin-permission-grid">
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Prince:</span>
                            <span class="admin-permission-value <?php echo $binData['prince_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['prince_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Knight:</span>
                            <span class="admin-permission-value <?php echo $binData['knight_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['knight_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Elf:</span>
                            <span class="admin-permission-value <?php echo $binData['elf_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['elf_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Magician:</span>
                            <span class="admin-permission-value <?php echo $binData['magician_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['magician_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Dark Elf:</span>
                            <span class="admin-permission-value <?php echo $binData['darkelf_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['darkelf_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Dragon Knight:</span>
                            <span class="admin-permission-value <?php echo $binData['dragonknight_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['dragonknight_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Illusionist:</span>
                            <span class="admin-permission-value <?php echo $binData['illusionist_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['illusionist_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Warrior:</span>
                            <span class="admin-permission-value <?php echo $binData['warrior_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['warrior_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Fencer:</span>
                            <span class="admin-permission-value <?php echo $binData['fencer_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['fencer_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                        
                        <div class="admin-permission-item">
                            <span class="admin-permission-label">Lancer:</span>
                            <span class="admin-permission-value <?php echo $binData['lancer_permit'] === 'true' ? 'allowed' : 'denied'; ?>">
                                <?php echo $binData['lancer_permit'] === 'true' ? 'Allowed' : 'Denied'; ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($binData['equip_bonus_list'])): ?>
                <div class="admin-detail-section">
                    <h3 class="admin-detail-subtitle">Equipment Bonus</h3>
                    <pre class="admin-detail-code"><?php echo htmlspecialchars($binData['equip_bonus_list']); ?></pre>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($binData['armor_series_info'])): ?>
                <div class="admin-detail-section">
                    <h3 class="admin-detail-subtitle">Armor Series Info</h3>
                    <pre class="admin-detail-code"><?php echo htmlspecialchars($binData['armor_series_info']); ?></pre>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($binData['lucky_bag_reward_list'])): ?>
                <div class="admin-detail-section">
                    <h3 class="admin-detail-subtitle">Lucky Bag Reward List</h3>
                    <pre class="admin-detail-code"><?php echo htmlspecialchars($binData['lucky_bag_reward_list']); ?></pre>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Related Armor Items -->
            <?php if (!empty($relatedArmor)): ?>
            <div class="admin-related-section">
                <h2 class="admin-section-title">Related Armor Items</h2>
                
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Name (EN)</th>
                                <th>Name (KR)</th>
                                <th>Type</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($relatedArmor as $armor): ?>
                            <tr>
                                <td><?php echo $armor['item_id']; ?></td>
                                <td>
                                    <img src="<?php echo $armorModel->getArmorIconUrl($armor['iconId']); ?>" alt="<?php echo htmlspecialchars($armor['desc_en']); ?>" class="admin-table-icon">
                                </td>
                                <td><?php echo htmlspecialchars($armor['desc_en']); ?></td>
                                <td><?php echo htmlspecialchars($armor['desc_kr']); ?></td>
                                <td><?php echo $armor['type']; ?></td>
                                <td><?php echo $armor['itemGrade']; ?></td>
                                <td class="admin-actions">
                                    <a href="../../public/armor/detail.php?id=<?php echo $armor['item_id']; ?>" class="admin-button admin-button-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?php echo $armor['item_id']; ?>" class="admin-button admin-button-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </section>
</main>

<style>
/* Bin Data Detail Styles */
.admin-detail-card {
    background-color: var(--admin-primary);
    border-radius: var(--border-radius);
    box-shadow: var(--admin-shadow);
    border: 1px solid var(--admin-border);
    margin-bottom: var(--spacing-lg);
    overflow: hidden;
}

.admin-detail-section {
    padding: var(--spacing-lg);
    border-bottom: 1px solid var(--admin-border);
}

.admin-detail-section:last-child {
    border-bottom: none;
}

.admin-detail-title {
    font-size: 1.25rem;
    margin-top: 0;
    margin-bottom: var(--spacing-lg);
    color: var(--admin-accent);
    font-weight: 600;
}

.admin-detail-subtitle {
    font-size: 1.1rem;
    margin-top: 0;
    margin-bottom: var(--spacing-md);
    color: var(--text);
    font-weight: 600;
}

.admin-detail-row {
    display: flex;
    margin-bottom: var(--spacing-sm);
    padding: var(--spacing-sm) 0;
    border-bottom: 1px solid var(--admin-border);
}

.admin-detail-row:last-child {
    border-bottom: none;
}

.admin-detail-label {
    width: 200px;
    font-weight: 500;
    color: var(--admin-light);
}

.admin-detail-value {
    flex: 1;
    color: var(--text);
}

.admin-detail-icon {
    height: 24px;
    width: 24px;
    vertical-align: middle;
    margin-left: var(--spacing-sm);
    border-radius: 4px;
}

.admin-detail-code {
    background-color: var(--admin-secondary);
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    overflow-x: auto;
    font-family: monospace;
    white-space: pre-wrap;
    max-height: 300px;
    overflow-y: auto;
    color: var(--text);
    margin: 0;
}

.admin-permission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: var(--spacing-md);
}

.admin-permission-item {
    background-color: var(--admin-secondary);
    padding: var(--spacing-sm) var(--spacing-md);
    border-radius: var(--border-radius);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-permission-label {
    font-weight: 500;
    color: var(--admin-light);
}

.admin-permission-value {
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.8rem;
}

.admin-permission-value.allowed {
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
}

.admin-permission-value.denied {
    background-color: rgba(108, 117, 125, 0.2);
    color: #6c757d;
}

.admin-related-section {
    margin-top: var(--spacing-xl);
}

.admin-section-title {
    font-size: 1.25rem;
    margin-bottom: var(--spacing-md);
    color: var(--text);
    border-bottom: 1px solid var(--admin-border);
    padding-bottom: var(--spacing-sm);
}
</style>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>