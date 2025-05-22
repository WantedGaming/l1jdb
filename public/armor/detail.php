<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Armor.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize armor model
$armorModel = new Armor();

// Initialize database for global functions
$db = Database::getInstance();

// Get armor ID from URL
$armorId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get armor details
$armor = $armorModel->getArmorById($armorId);

// If armor not found, redirect to list page
if (!$armor) {
    header('Location: index.php');
    exit;
}

// Get armor stats
$armorStats = $armorModel->getArmorStats($armorId);

// Get armor set details if applicable
$armorSet = null;
$armorSetPieces = [];
if ($armor['Set_Id'] > 0) {
    $armorSet = $armorModel->getArmorSet($armor['Set_Id']);
    $armorSetPieces = $armorModel->getArmorSetPieces($armor['Set_Id']);
}

// Set page title
$pageTitle = cleanItemName($armor['desc_en']) . ' - Armor Details';

// Include header
$heroTitle = cleanItemName($armor['desc_en']);
$heroSubtitle = formatArmorType($armor['type']);
include '../../includes/header.php';
include '../../includes/hero.php';
?>

<!-- Main Content -->
<main>
    <section class="detail-section">
        <div class="container">
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Armor has been updated successfully.
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                New armor has been created successfully.
            </div>
            <?php endif; ?>
            
            <div class="detail-container">
                <!-- Title Card -->
                <div class="detail-title-card">
                    <h1 class="detail-title"><?php echo htmlspecialchars(cleanItemName($armor['desc_en'])); ?></h1>
                    <p class="detail-category"><?php echo formatArmorType($armor['type']); ?> - <?php echo formatGrade($armor['itemGrade']); ?> Grade</p>
                    <div class="detail-id">
                        <span>Item ID: <?php echo $armor['item_id']; ?></span>
                        <?php if ($armor['Set_Id'] > 0): ?>
                        <span>Set ID: <?php echo $armor['Set_Id']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- First Row: Image and Basic Info -->
                <div class="detail-layout">
                    <!-- Image Card -->
                    <div class="detail-image-card">
                        <h3 class="detail-stat-title">Image Preview</h3>
                        <div class="detail-image-container">
                            <img src="<?php echo getItemIconUrl($armor['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($armor['desc_en'])); ?>" class="detail-img">
                        </div>
                    </div>
                    
                    <!-- Basic Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Basic</h3>
                        <div class="detail-stats single-column">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Name</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars(cleanItemName($armor['desc_en'])); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Korean</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars(cleanItemName($armor['desc_kr'])); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Type</span>
                                <span class="detail-stat-value"><?php echo formatArmorType($armor['type']); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Material</span>
                                <span class="detail-stat-value"><?php echo formatMaterial($armor['material']); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Weight</span>
                                <span class="detail-stat-value"><?php echo $armor['weight']; ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Grade</span>
                                <span class="detail-stat-value"><?php echo formatGrade($armor['itemGrade']); ?></span>
                            </div>
                            
                            <?php if (isset($armor['safenchant']) && $armor['safenchant'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Safe Enchant</span>
                                <span class="detail-stat-value">+<?php echo $armor['safenchant']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($armor['min_lvl']) && $armor['min_lvl'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Min Level</span>
                                <span class="detail-stat-value"><?php echo $armor['min_lvl']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($armor['max_lvl']) && $armor['max_lvl'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Max Level</span>
                                <span class="detail-stat-value"><?php echo $armor['max_lvl']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($armor['bless']) && $armor['bless'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Blessed</span>
                                <span class="detail-stat-value"><?php echo $armor['bless'] == 1 ? 'Yes' : 'No'; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Second Row: Three Stat Cards -->
                <div class="detail-three-column-layout">
                    <!-- Defense Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Defense Stats</h3>
                        <div class="detail-stats single-column">
                            <div class="detail-stat">
                                <span class="detail-stat-label">AC</span>
                                <span class="detail-stat-value"><?php echo $armor['ac']; ?></span>
                            </div>
                            
                            <?php if (isset($armor['ac_sub']) && $armor['ac_sub'] != 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">AC Sub</span>
                                <span class="detail-stat-value"><?php echo formatStatBonus($armor['ac_sub']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($armorStats['m_def']) && $armorStats['m_def'] != 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Magic Defense</span>
                                <span class="detail-stat-value"><?php echo formatStatBonus($armorStats['m_def']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($armorStats['damage_reduction']) && $armorStats['damage_reduction'] != 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Damage Reduction</span>
                                <span class="detail-stat-value"><?php echo formatPercentage($armorStats['damage_reduction'], 0); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($armorStats['MagicDamageReduction']) && $armorStats['MagicDamageReduction'] != 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Magic Damage Reduction</span>
                                <span class="detail-stat-value"><?php echo formatPercentage($armorStats['MagicDamageReduction'], 0); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Stats Bonus Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Stats Bonus</h3>
                        <div class="detail-stats single-column">
                            <?php if (hasStatBonuses($armor)): ?>
                                <?php 
                                $statBonuses = ['add_str' => 'STR', 'add_con' => 'CON', 'add_dex' => 'DEX', 'add_int' => 'INT', 'add_wis' => 'WIS', 'add_cha' => 'CHA'];
                                foreach ($statBonuses as $statField => $statName): 
                                    if (isset($armor[$statField]) && $armor[$statField] != 0):
                                ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label"><?php echo $statName; ?></span>
                                    <span class="detail-stat-value"><?php echo formatStatBonus($armor[$statField]); ?></span>
                                </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            <?php else: ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">No Bonuses</span>
                                <span class="detail-stat-value">—</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Additional Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Additional Stats</h3>
                        <div class="detail-stats single-column">
                            <?php 
                            $hasAdditionalStats = false;
                            $additionalStats = ['add_hp' => 'HP', 'add_mp' => 'MP', 'add_hpr' => 'HP Regen', 'add_mpr' => 'MP Regen', 'add_sp' => 'Spell Power'];
                            foreach ($additionalStats as $statField => $statLabel) {
                                if (isset($armor[$statField]) && $armor[$statField] != 0) {
                                    $hasAdditionalStats = true;
                                    ?>
                                    <div class="detail-stat">
                                        <span class="detail-stat-label"><?php echo $statLabel; ?></span>
                                        <span class="detail-stat-value"><?php echo formatStatBonus($armor[$statField]); ?></span>
                                    </div>
                                    <?php
                                }
                            }
                            
                            if (!$hasAdditionalStats): 
                            ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">No Additional Stats</span>
                                <span class="detail-stat-value">—</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Third Row: Resistances and Element Defenses -->
                <div class="detail-layout">
                    <!-- Resistances Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Resistances</h3>
                        <div class="detail-stats single-column">
                            <?php if (hasResistances($armor, ['regist_stone', 'regist_sleep', 'regist_freeze', 'regist_blind', 'regist_skill', 'regist_spirit', 'regist_dragon', 'regist_fear', 'regist_all'])): ?>
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
                                
                                foreach ($resistanceFields as $field => $label) {
                                    if (isset($armor[$field]) && $armor[$field] != 0) {
                                        ?>
                                        <div class="detail-stat">
                                            <span class="detail-stat-label"><?php echo $label; ?></span>
                                            <span class="detail-stat-value"><?php echo formatPercentage($armor[$field], 0); ?></span>
                                        </div>
                                        <?php
                                    }
                                }
                                
                                // Special field for poison resistance
                                if (isset($armor['poisonRegist']) && $armor['poisonRegist'] == 'true') {
                                    ?>
                                    <div class="detail-stat">
                                        <span class="detail-stat-label">Poison Resistance</span>
                                        <span class="detail-stat-value">Yes</span>
                                    </div>
                                    <?php
                                }
                                ?>
                            <?php else: ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">No Resistances</span>
                                <span class="detail-stat-value">—</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Elemental Defenses -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Elemental Defenses</h3>
                        <div class="detail-stats single-column">
                            <?php
                            $hasElementalDefenses = false;
                            $elementalFields = [
                                'defense_water' => 'Water Defense',
                                'defense_wind' => 'Wind Defense',
                                'defense_fire' => 'Fire Defense',
                                'defense_earth' => 'Earth Defense',
                                'attr_all' => 'All Elements Defense'
                            ];
                            
                            foreach ($elementalFields as $field => $label) {
                                if (isset($armor[$field]) && $armor[$field] != 0) {
                                    $hasElementalDefenses = true;
                                    ?>
                                    <div class="detail-stat">
                                        <span class="detail-stat-label"><?php echo $label; ?></span>
                                        <span class="detail-stat-value"><?php echo formatStatBonus($armor[$field]); ?></span>
                                    </div>
                                    <?php
                                }
                            }
                            
                            if (!$hasElementalDefenses): 
                            ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">No Elemental Defenses</span>
                                <span class="detail-stat-value">—</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Item Properties -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Item Properties</h3>
                    <div class="detail-properties">
                        <div class="detail-property-grid">
                            <div class="detail-property <?php echo isset($armor['bless']) && $armor['bless'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($armor['bless']) && $armor['bless'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Blessed</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($armor['trade']) && $armor['trade'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($armor['trade']) && $armor['trade'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Trade</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($armor['retrieve']) && $armor['retrieve'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($armor['retrieve']) && $armor['retrieve'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Store</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($armor['specialretrieve']) && $armor['specialretrieve'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($armor['specialretrieve']) && $armor['specialretrieve'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Store Special</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($armor['cant_delete']) && $armor['cant_delete'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($armor['cant_delete']) && $armor['cant_delete'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Delete</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($armor['cant_sell']) && $armor['cant_sell'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($armor['cant_sell']) && $armor['cant_sell'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Sell</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if (isset($armor['PVPDamage']) || isset($armor['PVPDamageReduction'])): ?>
                <!-- PVP Stats Section -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">PVP Stats</h3>
                    <div class="detail-stats">
                        <?php
                        $pvpFields = [
                            'PVPDamage' => 'PVP Damage',
                            'PVPDamagePercent' => 'PVP Damage %',
                            'PVPDamageReduction' => 'PVP Damage Reduction',
                            'PVPDamageReductionPercent' => 'PVP Damage Reduction %',
                            'PVPMagicDamageReduction' => 'PVP Magic Damage Reduction',
                            'PVPReductionEgnor' => 'PVP Reduction Ignore',
                            'PVPMagicDamageReductionEgnor' => 'PVP Magic Damage Reduction Ignore',
                            'abnormalStatusPVPDamageReduction' => 'Abnormal Status PVP Damage Reduction'
                        ];
                        
                        foreach ($pvpFields as $field => $label) {
                            if (isset($armor[$field]) && $armor[$field] != 0) {
                                ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label"><?php echo $label; ?></span>
                                    <span class="detail-stat-value"><?php echo $armor[$field]; ?><?php echo strpos($field, 'Percent') !== false ? '%' : ''; ?></span>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Armor Set Section (if applicable) -->
                <?php if ($armorSet): ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Armor Set: <?php echo $armorSet['note']; ?></h3>
                    
                    <?php if (!empty($armorSetPieces)): ?>
                    <div class="detail-stats-card">
                        <h4 class="detail-stat-title">Set Pieces</h4>
                        <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px;">
                            <?php foreach ($armorSetPieces as $setPiece): ?>
                            <div class="card item-card">
                                <a href="detail.php?id=<?php echo $setPiece['item_id']; ?>" class="card-link-overlay"></a>
                                <div class="card-header">
                                    <h3 class="card-header-title"><?php echo formatArmorType($setPiece['type']); ?></h3>
                                </div>
                                <div class="card-img-container">
                                    <img src="<?php echo getItemIconUrl($setPiece['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($setPiece['desc_en'])); ?>" class="card-img">
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title"><?php echo htmlspecialchars(cleanItemName($setPiece['desc_en'])); ?></h3>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="detail-stats-card">
                        <h4 class="detail-stat-title">Set Bonuses</h4>
                        <div class="detail-stats">
                            <?php if ($armorSet['min_enchant'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Minimum Enchant Level</span>
                                <span class="detail-stat-value">+<?php echo $armorSet['min_enchant']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($armorSet['ac'] != 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">AC Bonus</span>
                                <span class="detail-stat-value"><?php echo formatStatBonus($armorSet['ac']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php
                            $setBonuses = [
                                'hp' => 'HP', 
                                'mp' => 'MP', 
                                'hpr' => 'HP Regen', 
                                'mpr' => 'MP Regen', 
                                'mr' => 'Magic Resistance',
                                'str' => 'STR',
                                'dex' => 'DEX',
                                'con' => 'CON',
                                'wis' => 'WIS',
                                'cha' => 'CHA',
                                'intl' => 'INT',
                                'sp' => 'Spell Power',
                                'shortCritical' => 'Short Critical',
                                'longCritical' => 'Long Critical',
                                'magicCritical' => 'Magic Critical'
                            ];
                            
                            foreach ($setBonuses as $field => $label) {
                                if (isset($armorSet[$field]) && $armorSet[$field] != 0) {
                                    ?>
                                    <div class="detail-stat">
                                        <span class="detail-stat-label"><?php echo $label; ?></span>
                                        <span class="detail-stat-value"><?php echo formatStatBonus($armorSet[$field]); ?></span>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Class Restrictions -->
                <div class="detail-classes-section">
                    <h3 class="detail-stat-title">Used By</h3>
                    <div class="detail-classes">
                        <?php 
                        $classRestrictions = getClassRestrictions($armor);
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
                <?php if (isset($armor['Magic_name']) && !empty($armor['Magic_name'])): ?>
                <div class="detail-description">
                    <h3 class="detail-description-title">Magic Effect</h3>
                    <div class="detail-description-content">
                        <?php echo htmlspecialchars($armor['Magic_name']); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Description Section -->
                <?php if (!empty($armor['note'])): ?>
                <div class="detail-description">
                    <h3 class="detail-description-title">Description</h3>
                    <div class="detail-description-content">
                        <?php echo nl2br(htmlspecialchars($armor['note'])); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Dropped By Section -->
                <div class="detail-drops-section">
                    <h3 class="detail-stat-title">Dropped By</h3>
                    <?php
                    $droppedBy = getItemDrops($armorId, $db);
                    
                    if (empty($droppedBy)):
                    ?>
                    <div class="detail-drops-content">
                        <p class="detail-placeholder-text">This armor is not dropped by any monsters.</p>
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
                                    <?php if (array_filter($droppedBy, function($d) { return $d['Enchant'] > 0; })): ?>
                                    <th class="drop-table-enchant">Enchant</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($droppedBy as $drop): ?>
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
                                    <?php if (array_filter($droppedBy, function($d) { return $d['Enchant'] > 0; })): ?>
                                    <td class="drop-table-enchant"><?php echo $drop['Enchant'] > 0 ? '+' . $drop['Enchant'] : '-'; ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Back to list button -->
                <div class="detail-footer">
                    <a href="index.php" class="detail-back-button">&larr; Back to Armor List</a>
                    
                    <?php if ($user->isAdmin()): ?>
                    <a href="../../admin/armor/edit.php?id=<?php echo $armor['item_id']; ?>" class="detail-edit-button">Edit Armor</a>
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