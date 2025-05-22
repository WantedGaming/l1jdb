<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Item.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize item model
$itemModel = new Item();

// Initialize database for global functions
$db = Database::getInstance();

// Get item ID from URL
$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get item details
$item = $itemModel->getItemById($itemId);

// If item not found, redirect to list page
if (!$item) {
    header('Location: index.php');
    exit;
}

// Get item stats
$itemStats = $itemModel->getItemStats($itemId);

// Get item delay info
$itemDelay = $itemModel->getItemDelayInfo($itemId);

// Set page title
$pageTitle = cleanItemName($item['desc_en']) . ' - Item Details';

// Include header
$heroTitle = cleanItemName($item['desc_en']);
$heroSubtitle = ucfirst(strtolower(str_replace('_', ' ', $item['item_type'])));
include '../../includes/header.php';
include '../../includes/hero.php';
?>

<!-- Main Content -->
<main>
    <section class="detail-section">
        <div class="container">
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Item has been updated successfully.
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                New item has been created successfully.
            </div>
            <?php endif; ?>
            
            <div class="detail-container">
                <!-- Title Card -->
                <div class="detail-title-card">
                    <h1 class="detail-title"><?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?></h1>
                    <p class="detail-category"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['item_type']))); ?> - <?php echo formatGrade($item['itemGrade']); ?> Grade</p>
                    <div class="detail-id">
                        <span>Item ID: <?php echo $item['item_id']; ?></span>
                    </div>
                </div>
                
                <!-- First Row: Image and Basic Info -->
                <div class="detail-layout">
                    <!-- Image Card -->
                    <div class="detail-image-card">
                        <h3 class="detail-stat-title">Image Preview</h3>
                        <div class="detail-image-container">
                            <img src="<?php echo getItemIconUrl($item['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?>" class="detail-img">
                        </div>
                    </div>
                    
                    <!-- Basic Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Basic</h3>
                        <div class="detail-stats single-column">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Name</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Korean</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars(cleanItemName($item['desc_kr'])); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Item Type</span>
                                <span class="detail-stat-value"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['item_type']))); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Use Type</span>
                                <span class="detail-stat-value"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['use_type']))); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Material</span>
                                <span class="detail-stat-value"><?php echo formatMaterial($item['material']); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Weight</span>
                                <span class="detail-stat-value"><?php echo $item['weight']; ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Grade</span>
                                <span class="detail-stat-value"><?php echo formatGrade($item['itemGrade']); ?></span>
                            </div>
                            
                            <?php if (isset($item['max_charge_count']) && $item['max_charge_count'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Charges</span>
                                <span class="detail-stat-value"><?php echo $item['max_charge_count']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($item['food_volume']) && $item['food_volume'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Food Volume</span>
                                <span class="detail-stat-value"><?php echo $item['food_volume']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($item['min_lvl']) && $item['min_lvl'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Min Level</span>
                                <span class="detail-stat-value"><?php echo $item['min_lvl']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($item['max_lvl']) && $item['max_lvl'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Max Level</span>
                                <span class="detail-stat-value"><?php echo $item['max_lvl']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($item['bless']) && $item['bless'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Blessed</span>
                                <span class="detail-stat-value"><?php echo $item['bless'] == 1 ? 'Yes' : 'No'; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- If item has damage or attack stats, show them -->
                <?php if ($item['dmg_small'] > 0 || $item['dmg_large'] > 0 || $item['shortHit'] > 0 || $item['longHit'] > 0): ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Damage Stats</h3>
                    <div class="detail-stats">
                        <?php if ($item['dmg_small'] > 0 || $item['dmg_large'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Damage Range</span>
                            <span class="detail-stat-value"><?php echo formatDamageRange($item['dmg_small'], $item['dmg_large']); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($item['shortHit'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Short Range Hit</span>
                            <span class="detail-stat-value"><?php echo formatStatBonus($item['shortHit']); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($item['shortDmg'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Short Range Damage</span>
                            <span class="detail-stat-value"><?php echo formatStatBonus($item['shortDmg']); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($item['longHit'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Long Range Hit</span>
                            <span class="detail-stat-value"><?php echo formatStatBonus($item['longHit']); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($item['longDmg'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Long Range Damage</span>
                            <span class="detail-stat-value"><?php echo formatStatBonus($item['longDmg']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Attribute Bonuses -->
                <?php if (hasStatBonuses($item)): ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Attribute Bonuses</h3>
                    <div class="detail-stats">
                        <?php 
                        $statBonuses = ['add_str' => 'STR', 'add_dex' => 'DEX', 'add_con' => 'CON', 'add_int' => 'INT', 'add_wis' => 'WIS', 'add_cha' => 'CHA'];
                        foreach ($statBonuses as $statField => $statName): 
                            if (isset($item[$statField]) && $item[$statField] != 0):
                        ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label"><?php echo $statName; ?></span>
                            <span class="detail-stat-value"><?php echo formatStatBonus($item[$statField]); ?></span>
                        </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- HP/MP Bonuses -->
                <?php
                $hasResourceBonus = false;
                $resourceStats = ['add_hp', 'add_mp', 'add_hpr', 'add_mpr', 'add_sp'];
                foreach($resourceStats as $stat) {
                    if (isset($item[$stat]) && $item[$stat] != 0) {
                        $hasResourceBonus = true;
                        break;
                    }
                }
                
                if ($hasResourceBonus):
                ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Resource Bonuses</h3>
                    <div class="detail-stats">
                        <?php 
                        $resourceBonuses = ['add_hp' => 'HP', 'add_mp' => 'MP', 'add_hpr' => 'HP Regen', 'add_mpr' => 'MP Regen', 'add_sp' => 'Spell Power'];
                        foreach ($resourceBonuses as $statField => $statLabel): 
                            if (isset($item[$statField]) && $item[$statField] != 0):
                        ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label"><?php echo $statLabel; ?></span>
                            <span class="detail-stat-value"><?php echo formatStatBonus($item[$statField]); ?></span>
                        </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Delay Information (if applicable) -->
                <?php if (!empty($itemDelay) && ($itemDelay['delay_id'] > 0 || $itemDelay['delay_time'] > 0)): ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Usage Delay</h3>
                    <div class="detail-stats">
                        <?php if ($itemDelay['delay_id'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Delay Group</span>
                            <span class="detail-stat-value"><?php echo $itemDelay['delay_id']; ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($itemDelay['delay_time'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Delay Time</span>
                            <span class="detail-stat-value"><?php echo $itemDelay['delay_time'] / 1000; ?> seconds</span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($itemDelay['delay_effect'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Delay Effect</span>
                            <span class="detail-stat-value"><?php echo $itemDelay['delay_effect']; ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Resistances -->
                <?php
                $resistanceFields = [
                    'regist_stone' => 'Stone Resistance',
                    'regist_sleep' => 'Sleep Resistance',
                    'regist_freeze' => 'Freeze Resistance',
                    'regist_blind' => 'Blind Resistance',
                    'regist_skill' => 'Skill Resistance',
                    'regist_spirit' => 'Spirit Resistance',
                    'regist_dragon' => 'Dragon Resistance',
                    'regist_fear' => 'Fear Resistance',
                    'regist_all' => 'All Resistance'
                ];
                
                if (hasResistances($item, array_keys($resistanceFields))):
                ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Resistances</h3>
                    <div class="detail-stats">
                        <?php foreach($resistanceFields as $field => $label): ?>
                            <?php if (isset($item[$field]) && $item[$field] != 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label"><?php echo $label; ?></span>
                                <span class="detail-stat-value"><?php echo formatPercentage($item[$field], 0); ?></span>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <?php if (isset($item['poisonRegist']) && $item['poisonRegist'] == 'true'): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Poison Resistance</span>
                            <span class="detail-stat-value">Yes</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Item Properties -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Item Properties</h3>
                    <div class="detail-properties">
                        <div class="detail-property-grid">
                            <div class="detail-property <?php echo isset($item['bless']) && $item['bless'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($item['bless']) && $item['bless'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Blessed</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($item['trade']) && $item['trade'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($item['trade']) && $item['trade'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Trade</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($item['retrieve']) && $item['retrieve'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($item['retrieve']) && $item['retrieve'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Store</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($item['specialretrieve']) && $item['specialretrieve'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($item['specialretrieve']) && $item['specialretrieve'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Store Special</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($item['cant_delete']) && $item['cant_delete'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($item['cant_delete']) && $item['cant_delete'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Delete</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($item['cant_sell']) && $item['cant_sell'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($item['cant_sell']) && $item['cant_sell'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Sell</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($item['merge']) && $item['merge'] == 'true' ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($item['merge']) && $item['merge'] == 'true' ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Stackable</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Class Restrictions -->
                <div class="detail-classes-section">
                    <h3 class="detail-stat-title">Used By</h3>
                    <div class="detail-classes">
                        <?php 
                        $classRestrictions = getClassRestrictions($item);
                        foreach ($classRestrictions as $classKey => $classData): 
                        ?>
                        <div class="detail-class <?php echo $classData['can_use'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name"><?php echo $classData['name']; ?></span>
                            <span class="detail-class-status"><?php echo $classData['can_use'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Magic Name Section -->
                <?php if (isset($item['Magic_name']) && !empty($item['Magic_name'])): ?>
                <div class="detail-description">
                    <h3 class="detail-description-title">Magic Effect</h3>
                    <div class="detail-description-content">
                        <?php echo htmlspecialchars($item['Magic_name']); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Description Section -->
                <?php if (!empty($item['note'])): ?>
                <div class="detail-description">
                    <h3 class="detail-description-title">Description</h3>
                    <div class="detail-description-content">
                        <?php echo nl2br(htmlspecialchars($item['note'])); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Monsters Dropped By -->
                <div class="detail-drops-section">
                    <h3 class="detail-stat-title">Dropped By</h3>
                    <?php
                    $drops = getItemDrops($itemId, $db);
                    
                    if (empty($drops)):
                    ?>
                    <div class="detail-drops-content">
                        <p class="detail-placeholder-text">This item is not dropped by any monsters.</p>
                    </div>
                    <?php else: ?>
                    <div class="monster-drop-table">
                        <table class="drop-table">
                            <thead>
                                <tr>
                                    <th class="drop-table-monster">Monster</th>
                                    <th class="drop-table-level">Level</th>
                                    <th class="drop-table-chance">Drop Rate</th>
                                    <th class="drop-table-amount">Amount</th>
                                    <?php if (array_filter($drops, function($d) { return $d['Enchant'] > 0; })): ?>
                                    <th class="drop-table-enchant">Enchant</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($drops as $drop): ?>
                                <tr class="<?php echo $drop['is_bossmonster'] == 'true' ? 'drop-row-boss' : ''; ?>">
                                    <td class="drop-table-monster">
                                        <div class="monster-info">
                                            <img src="<?php echo getMonsterSpriteUrl($drop['spriteId']); ?>" alt="<?php echo htmlspecialchars($drop['mobname_en']); ?>" class="monster-sprite">
                                            <span class="monster-name"><?php echo htmlspecialchars($drop['mobname_en']); ?><?php echo $drop['is_bossmonster'] == 'true' ? ' <span class="boss-tag">Boss</span>' : ''; ?></span>
                                        </div>
                                    </td>
                                    <td class="drop-table-level"><?php echo $drop['lvl']; ?></td>
                                    <td class="drop-table-chance"><?php echo formatPercentage($drop['chance'] / 1000, 2); ?></td>
                                    <td class="drop-table-amount"><?php echo $drop['min'] == $drop['max'] ? $drop['min'] : $drop['min'] . '-' . $drop['max']; ?></td>
                                    <?php if (array_filter($drops, function($d) { return $d['Enchant'] > 0; })): ?>
                                    <td class="drop-table-enchant"><?php echo $drop['Enchant'] > 0 ? '+' . $drop['Enchant'] : '-'; ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="detail-footer">
                    <a href="index.php" class="detail-back-button">&larr; Back to Items List</a>
                    
                    <?php if ($user->isAdmin()): ?>
                    <a href="../../admin/items/edit.php?id=<?php echo $item['item_id']; ?>" class="detail-edit-button">Edit Item</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Include footer
include '../../includes/footer.php';
?>