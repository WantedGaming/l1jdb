<?php
// Admin item create page
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data with default values
    $itemData = [
        // Basic Information
        'desc_en' => $_POST['desc_en'] ?? '',
        'desc_kr' => $_POST['desc_kr'] ?? '',
        'item_type' => $_POST['item_type'] ?? 'OTHER',
        'use_type' => $_POST['use_type'] ?? 'NONE',
        'material' => $_POST['material'] ?? 'NONE(-)',
        'weight' => (int)($_POST['weight'] ?? 0),
        'itemGrade' => $_POST['itemGrade'] ?? 'NORMAL',
        
        // Visual properties
        'iconId' => (int)($_POST['iconId'] ?? 0),
        'spriteId' => (int)($_POST['spriteId'] ?? 0),
        
        // Item specific properties
        'max_charge_count' => (int)($_POST['max_charge_count'] ?? 0),
        'food_volume' => (int)($_POST['food_volume'] ?? 0),
        'min_lvl' => (int)($_POST['min_lvl'] ?? 0),
        'max_lvl' => (int)($_POST['max_lvl'] ?? 0),
        
        // Combat Stats
        'dmg_small' => (int)($_POST['dmg_small'] ?? 0),
        'dmg_large' => (int)($_POST['dmg_large'] ?? 0),
        'shortHit' => (int)($_POST['shortHit'] ?? 0),
        'longHit' => (int)($_POST['longHit'] ?? 0),
        'shortDmg' => (int)($_POST['shortDmg'] ?? 0),
        'longDmg' => (int)($_POST['longDmg'] ?? 0),
        
        // Stat Bonuses
        'add_str' => (int)($_POST['add_str'] ?? 0),
        'add_con' => (int)($_POST['add_con'] ?? 0),
        'add_dex' => (int)($_POST['add_dex'] ?? 0),
        'add_int' => (int)($_POST['add_int'] ?? 0),
        'add_wis' => (int)($_POST['add_wis'] ?? 0),
        'add_cha' => (int)($_POST['add_cha'] ?? 0),
        'add_hp' => (int)($_POST['add_hp'] ?? 0),
        'add_mp' => (int)($_POST['add_mp'] ?? 0),
        'add_hpr' => (int)($_POST['add_hpr'] ?? 0),
        'add_mpr' => (int)($_POST['add_mpr'] ?? 0),
        'add_sp' => (int)($_POST['add_sp'] ?? 0),
        
        // Resistances
        'regist_stone' => (int)($_POST['regist_stone'] ?? 0),
        'regist_sleep' => (int)($_POST['regist_sleep'] ?? 0),
        'regist_freeze' => (int)($_POST['regist_freeze'] ?? 0),
        'regist_blind' => (int)($_POST['regist_blind'] ?? 0),
        'regist_skill' => (int)($_POST['regist_skill'] ?? 0),
        'regist_spirit' => (int)($_POST['regist_spirit'] ?? 0),
        'regist_dragon' => (int)($_POST['regist_dragon'] ?? 0),
        'regist_fear' => (int)($_POST['regist_fear'] ?? 0),
        'regist_all' => (int)($_POST['regist_all'] ?? 0),
        'poisonRegist' => $_POST['poisonRegist'] ?? 'false',
        
        // Item Properties
        'bless' => isset($_POST['bless']) ? 1 : 1, // Default to blessed
        'trade' => isset($_POST['trade']) ? 1 : 0,
        'retrieve' => isset($_POST['retrieve']) ? 1 : 0,
        'specialretrieve' => isset($_POST['specialretrieve']) ? 1 : 0,
        'cant_delete' => isset($_POST['cant_delete']) ? 1 : 0,
        'cant_sell' => isset($_POST['cant_sell']) ? 1 : 0,
        'merge' => $_POST['merge'] ?? 'false',
        
        // Magic Properties
        'Magic_name' => $_POST['Magic_name'] ?? '',
        
        // Notes
        'note' => $_POST['note'] ?? '',
        
        // Additional required fields with defaults
        'item_name_id' => 0,
        'desc_powerbook' => $_POST['desc_en'] ?? '',
        'desc_id' => '',
        'ac_bonus' => 0,
        'm_def' => 0,
        'carryBonus' => 0,
        'defense_water' => 0,
        'defense_wind' => 0,
        'defense_fire' => 0,
        'defense_earth' => 0,
        'attr_all' => 0,
        'hitup_skill' => 0,
        'hitup_spirit' => 0,
        'hitup_dragon' => 0,
        'hitup_fear' => 0,
        'hitup_all' => 0,
        'hitup_magic' => 0,
        'damage_reduction' => 0,
        'MagicDamageReduction' => 0,
        'reductionEgnor' => 0,
        'reductionPercent' => 0,
        'PVPDamage' => 0,
        'PVPDamageReduction' => 0,
        'PVPDamageReductionPercent' => 0,
        'PVPMagicDamageReduction' => 0,
        'PVPReductionEgnor' => 0,
        'PVPMagicDamageReductionEgnor' => 0,
        'abnormalStatusDamageReduction' => 0,
        'abnormalStatusPVPDamageReduction' => 0,
        'PVPDamagePercent' => 0,
        'expBonus' => 0,
        'rest_exp_reduce_efficiency' => 0,
        'shortCritical' => 0,
        'longCritical' => 0,
        'magicCritical' => 0,
        'addDg' => 0,
        'addEr' => 0,
        'addMe' => 0,
        'imunEgnor' => 0,
        'stunDuration' => 0,
        'tripleArrowStun' => 0,
        'strangeTimeIncrease' => 0,
        'strangeTimeDecrease' => 0,
        'potionRegist' => 0,
        'potionPercent' => 0,
        'potionValue' => 0,
        'hprAbsol32Second' => 0,
        'mprAbsol64Second' => 0,
        'mprAbsol16Second' => 0,
        'hpPotionDelayDecrease' => 0,
        'hpPotionCriticalProb' => 0,
        'increaseArmorSkillProb' => 0,
        'attackSpeedDelayRate' => 0,
        'moveSpeedDelayRate' => 0,
        'buffDurationSecond' => 0,
        'locx' => 0,
        'locy' => 0,
        'mapid' => 0,
        'delay_id' => 0,
        'delay_time' => 0,
        'delay_effect' => 0,
        'save_at_once' => 1,
        'level' => 0,
        'attr' => 'NONE',
        'alignment' => 'NONE',
        'use_royal' => 0,
        'use_knight' => 0,
        'use_mage' => 0,
        'use_elf' => 0,
        'use_darkelf' => 0,
        'use_dragonknight' => 0,
        'use_illusionist' => 0,
        'use_warrior' => 0,
        'use_fencer' => 0,
        'use_lancer' => 0,
        'skill_type' => 'none',
        'etc_value' => 0,
        'limit_type' => 'NONE',
        'prob' => 0
    ];
    
    // Validate required fields
    $errors = [];
    if (empty($itemData['desc_en'])) {
        $errors[] = "English name is required.";
    }
    if (empty($itemData['desc_kr'])) {
        $errors[] = "Korean name is required.";
    }
    
    // Create item if no errors
    if (empty($errors)) {
        $itemId = $itemModel->createItem($itemData);
        if ($itemId) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Log activity with null-safe username
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'create',
                "Created new item: {$itemData['desc_en']} (ID: $itemId)",
                'item',
                $itemId
            );
            
            // Redirect to items list with success message
            header('Location: index.php?created=1');
            exit;
        } else {
            $errorMessage = "Failed to create item. Please try again.";
        }
    } else {
        $errorMessage = implode(' ', $errors);
    }
}

// Set default values for new item
$item = [
    'desc_en' => '',
    'desc_kr' => '',
    'item_type' => 'OTHER',
    'use_type' => 'NONE',
    'material' => 'NONE(-)',
    'weight' => 0,
    'itemGrade' => 'NORMAL',
    'iconId' => 0,
    'spriteId' => 0,
    'max_charge_count' => 0,
    'food_volume' => 0,
    'min_lvl' => 0,
    'max_lvl' => 0,
    'dmg_small' => 0,
    'dmg_large' => 0,
    'shortHit' => 0,
    'longHit' => 0,
    'shortDmg' => 0,
    'longDmg' => 0,
    'add_str' => 0,
    'add_con' => 0,
    'add_dex' => 0,
    'add_int' => 0,
    'add_wis' => 0,
    'add_cha' => 0,
    'add_hp' => 0,
    'add_mp' => 0,
    'add_hpr' => 0,
    'add_mpr' => 0,
    'add_sp' => 0,
    'regist_stone' => 0,
    'regist_sleep' => 0,
    'regist_freeze' => 0,
    'regist_blind' => 0,
    'regist_skill' => 0,
    'regist_spirit' => 0,
    'regist_dragon' => 0,
    'regist_fear' => 0,
    'regist_all' => 0,
    'poisonRegist' => 'false',
    'bless' => 1,
    'trade' => 0,
    'retrieve' => 0,
    'specialretrieve' => 0,
    'cant_delete' => 0,
    'cant_sell' => 0,
    'merge' => 'false',
    'Magic_name' => '',
    'note' => ''
];

// Set page title
$pageTitle = "Create New Item";

// Get item types and grades for dropdowns
$itemTypes = $itemModel->getItemTypes();
$itemUseTypes = $itemModel->getItemUseTypes();
$itemMaterials = $itemModel->getItemMaterials();
$itemGrades = $itemModel->getItemGrades();

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
                </div>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <!-- Create Item Form -->
            <div class="admin-form-container">
                <form action="create.php" method="post" class="admin-form">
                    
                    <!-- First Row: Image Preview and Basic Info -->
                    <div class="admin-detail-layout">
                        <!-- Image Preview Card -->
                        <div class="admin-image-card">
                            <h3 class="admin-form-header">Item Preview</h3>
                            <div class="admin-image-container">
                                <img id="itemPreview" src="<?php echo getItemIconUrl(0); ?>" alt="Item Preview" class="admin-image-large">
                                <div id="previewStatus" class="admin-status-indicator">No Icon</div>
                            </div>
                            
                            <div class="admin-form-group" style="margin-top: 20px;">
                                <label for="iconId" class="admin-form-label">Icon ID</label>
                                <input type="number" id="iconId" name="iconId" class="admin-form-input" value="<?php echo $item['iconId']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="spriteId" class="admin-form-label">Sprite ID</label>
                                <input type="number" id="spriteId" name="spriteId" class="admin-form-input" value="<?php echo $item['spriteId']; ?>">
                            </div>
                        </div>
                        
                        <!-- Basic Info Card -->
                        <div class="admin-form-section" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none; background-color: var(--admin-dark);">
                            <h3 class="admin-form-header">Basic Information</h3>
                            
                            <div class="admin-basic-form">
                                <div class="admin-form-group">
                                    <label for="desc_en" class="admin-form-label">Name (English)</label>
                                    <input type="text" id="desc_en" name="desc_en" class="admin-form-input" value="<?php echo htmlspecialchars($item['desc_en']); ?>" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="desc_kr" class="admin-form-label">Name (Korean)</label>
                                    <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" value="<?php echo htmlspecialchars($item['desc_kr']); ?>" required>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="item_type" class="admin-form-label">Item Type</label>
                                        <select id="item_type" name="item_type" class="admin-form-select" required>
                                            <?php foreach ($itemTypes as $type): ?>
                                            <option value="<?php echo $type; ?>" <?php echo ($item['item_type'] === $type) ? 'selected' : ''; ?>>
                                                <?php echo ucfirst(strtolower(str_replace('_', ' ', $type))); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="use_type" class="admin-form-label">Use Type</label>
                                        <select id="use_type" name="use_type" class="admin-form-select" required>
                                            <?php foreach ($itemUseTypes as $useType): ?>
                                            <option value="<?php echo $useType; ?>" <?php echo ($item['use_type'] === $useType) ? 'selected' : ''; ?>>
                                                <?php echo ucfirst(strtolower(str_replace('_', ' ', $useType))); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="material" class="admin-form-label">Material</label>
                                        <select id="material" name="material" class="admin-form-select" required>
                                            <?php foreach ($itemMaterials as $material): ?>
                                            <option value="<?php echo $material; ?>" <?php echo ($item['material'] === $material) ? 'selected' : ''; ?>>
                                                <?php echo formatMaterial($material); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="itemGrade" class="admin-form-label">Grade</label>
                                        <select id="itemGrade" name="itemGrade" class="admin-form-select" required>
                                            <?php foreach ($itemGrades as $grade): ?>
                                            <option value="<?php echo $grade; ?>" <?php echo ($item['itemGrade'] === $grade) ? 'selected' : ''; ?>>
                                                <?php echo formatArmorGrade($grade); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="weight" class="admin-form-label">Weight</label>
                                        <input type="number" id="weight" name="weight" class="admin-form-input" value="<?php echo $item['weight']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab Navigation -->
                    <div class="admin-tabs">
                        <ul class="admin-tabs-nav">
                            <li class="admin-tab-item active" data-tab="stats">Stats & Properties</li>
                            <li class="admin-tab-item" data-tab="bonuses">Stat Bonuses</li>
                            <li class="admin-tab-item" data-tab="resistance">Resistances</li>
                            <li class="admin-tab-item" data-tab="properties">Item Properties</li>
                            <li class="admin-tab-item" data-tab="description">Description</li>
                        </ul>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="admin-tabs-content">
                        
                        <!-- Stats & Properties Tab -->
                        <div class="admin-tab-pane active" id="stats-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Item Specific Properties</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="max_charge_count" class="admin-form-label">Max Charges</label>
                                        <input type="number" id="max_charge_count" name="max_charge_count" class="admin-form-input" value="<?php echo $item['max_charge_count']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="food_volume" class="admin-form-label">Food Volume</label>
                                        <input type="number" id="food_volume" name="food_volume" class="admin-form-input" value="<?php echo $item['food_volume']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="min_lvl" class="admin-form-label">Minimum Level</label>
                                        <input type="number" id="min_lvl" name="min_lvl" class="admin-form-input" value="<?php echo $item['min_lvl']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="max_lvl" class="admin-form-label">Maximum Level</label>
                                        <input type="number" id="max_lvl" name="max_lvl" class="admin-form-input" value="<?php echo $item['max_lvl']; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Combat Stats</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="dmg_small" class="admin-form-label">Small Damage</label>
                                        <input type="number" id="dmg_small" name="dmg_small" class="admin-form-input" value="<?php echo $item['dmg_small']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="dmg_large" class="admin-form-label">Large Damage</label>
                                        <input type="number" id="dmg_large" name="dmg_large" class="admin-form-input" value="<?php echo $item['dmg_large']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="shortHit" class="admin-form-label">Short Range Hit</label>
                                        <input type="number" id="shortHit" name="shortHit" class="admin-form-input" value="<?php echo $item['shortHit']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="longHit" class="admin-form-label">Long Range Hit</label>
                                        <input type="number" id="longHit" name="longHit" class="admin-form-input" value="<?php echo $item['longHit']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="shortDmg" class="admin-form-label">Short Range Damage</label>
                                        <input type="number" id="shortDmg" name="shortDmg" class="admin-form-input" value="<?php echo $item['shortDmg']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="longDmg" class="admin-form-label">Long Range Damage</label>
                                        <input type="number" id="longDmg" name="longDmg" class="admin-form-input" value="<?php echo $item['longDmg']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stat Bonuses Tab -->
                        <div class="admin-tab-pane" id="bonuses-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Attribute Bonuses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_str" class="admin-form-label">STR</label>
                                        <input type="number" id="add_str" name="add_str" class="admin-form-input" value="<?php echo $item['add_str']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_con" class="admin-form-label">CON</label>
                                        <input type="number" id="add_con" name="add_con" class="admin-form-input" value="<?php echo $item['add_con']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_dex" class="admin-form-label">DEX</label>
                                        <input type="number" id="add_dex" name="add_dex" class="admin-form-input" value="<?php echo $item['add_dex']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_int" class="admin-form-label">INT</label>
                                        <input type="number" id="add_int" name="add_int" class="admin-form-input" value="<?php echo $item['add_int']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_wis" class="admin-form-label">WIS</label>
                                        <input type="number" id="add_wis" name="add_wis" class="admin-form-input" value="<?php echo $item['add_wis']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_cha" class="admin-form-label">CHA</label>
                                        <input type="number" id="add_cha" name="add_cha" class="admin-form-input" value="<?php echo $item['add_cha']; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Resource Bonuses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hp" class="admin-form-label">HP</label>
                                        <input type="number" id="add_hp" name="add_hp" class="admin-form-input" value="<?php echo $item['add_hp']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mp" class="admin-form-label">MP</label>
                                        <input type="number" id="add_mp" name="add_mp" class="admin-form-input" value="<?php echo $item['add_mp']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_sp" class="admin-form-label">SP</label>
                                        <input type="number" id="add_sp" name="add_sp" class="admin-form-input" value="<?php echo $item['add_sp']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hpr" class="admin-form-label">HP Regen</label>
                                        <input type="number" id="add_hpr" name="add_hpr" class="admin-form-input" value="<?php echo $item['add_hpr']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mpr" class="admin-form-label">MP Regen</label>
                                        <input type="number" id="add_mpr" name="add_mpr" class="admin-form-input" value="<?php echo $item['add_mpr']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resistances Tab -->
                        <div class="admin-tab-pane" id="resistance-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Resistances</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_stone" class="admin-form-label">Stone Resistance (%)</label>
                                        <input type="number" id="regist_stone" name="regist_stone" class="admin-form-input" value="<?php echo $item['regist_stone']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_sleep" class="admin-form-label">Sleep Resistance (%)</label>
                                        <input type="number" id="regist_sleep" name="regist_sleep" class="admin-form-input" value="<?php echo $item['regist_sleep']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_freeze" class="admin-form-label">Freeze Resistance (%)</label>
                                        <input type="number" id="regist_freeze" name="regist_freeze" class="admin-form-input" value="<?php echo $item['regist_freeze']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_blind" class="admin-form-label">Blind Resistance (%)</label>
                                        <input type="number" id="regist_blind" name="regist_blind" class="admin-form-input" value="<?php echo $item['regist_blind']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_skill" class="admin-form-label">Skill Resistance (%)</label>
                                        <input type="number" id="regist_skill" name="regist_skill" class="admin-form-input" value="<?php echo $item['regist_skill']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_spirit" class="admin-form-label">Spirit Resistance (%)</label>
                                        <input type="number" id="regist_spirit" name="regist_spirit" class="admin-form-input" value="<?php echo $item['regist_spirit']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_dragon" class="admin-form-label">Dragon Resistance (%)</label>
                                        <input type="number" id="regist_dragon" name="regist_dragon" class="admin-form-input" value="<?php echo $item['regist_dragon']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_fear" class="admin-form-label">Fear Resistance (%)</label>
                                        <input type="number" id="regist_fear" name="regist_fear" class="admin-form-input" value="<?php echo $item['regist_fear']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_all" class="admin-form-label">All Resistance (%)</label>
                                        <input type="number" id="regist_all" name="regist_all" class="admin-form-input" value="<?php echo $item['regist_all']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="poisonRegist" class="admin-form-label">Poison Resistance</label>
                                        <select id="poisonRegist" name="poisonRegist" class="admin-form-select">
                                            <option value="false" <?php echo ($item['poisonRegist'] === 'false') ? 'selected' : ''; ?>>No</option>
                                            <option value="true" <?php echo ($item['poisonRegist'] === 'true') ? 'selected' : ''; ?>>Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Item Properties Tab -->
                        <div class="admin-tab-pane" id="properties-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Item Properties</h3>
                                
                                <div class="admin-property-toggles">
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="bless" name="bless" <?php echo $item['bless'] ? 'checked' : ''; ?>>
                                        <label for="bless">Blessed</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="trade" name="trade" <?php echo $item['trade'] ? 'checked' : ''; ?>>
                                        <label for="trade">Can Not Trade</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="retrieve" name="retrieve" <?php echo $item['retrieve'] ? 'checked' : ''; ?>>
                                        <label for="retrieve">Can Not Store</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="specialretrieve" name="specialretrieve" <?php echo $item['specialretrieve'] ? 'checked' : ''; ?>>
                                        <label for="specialretrieve">Can Not Store Special</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="cant_delete" name="cant_delete" <?php echo $item['cant_delete'] ? 'checked' : ''; ?>>
                                        <label for="cant_delete">Can Not Delete</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="cant_sell" name="cant_sell" <?php echo $item['cant_sell'] ? 'checked' : ''; ?>>
                                        <label for="cant_sell">Can Not Sell</label>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="merge" class="admin-form-label">Stackable</label>
                                        <select id="merge" name="merge" class="admin-form-select">
                                            <option value="false" <?php echo ($item['merge'] === 'false') ? 'selected' : ''; ?>>No</option>
                                            <option value="true" <?php echo ($item['merge'] === 'true') ? 'selected' : ''; ?>>Yes</option>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="Magic_name" class="admin-form-label">Magic Effect Name</label>
                                        <input type="text" id="Magic_name" name="Magic_name" class="admin-form-input" value="<?php echo htmlspecialchars($item['Magic_name']); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description Tab -->
                        <div class="admin-tab-pane" id="description-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Description</h3>
                                
                                <div class="admin-form-group">
                                    <label for="note" class="admin-form-label">Description / Notes</label>
                                    <textarea id="note" name="note" class="admin-form-textarea" rows="8"><?php echo htmlspecialchars($item['note']); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="admin-form-buttons">
                        <a href="index.php" class="admin-button admin-button-secondary">Cancel</a>
                        <button type="submit" class="admin-button admin-button-primary">Create Item</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab navigation functionality
    const tabItems = document.querySelectorAll('.admin-tab-item');
    const tabPanes = document.querySelectorAll('.admin-tab-pane');
    
    tabItems.forEach(function(tab) {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabItems.forEach(function(item) {
                item.classList.remove('active');
            });
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Hide all tab panes
            tabPanes.forEach(function(pane) {
                pane.classList.remove('active');
            });
            
            // Show corresponding tab pane
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId + '-tab').classList.add('active');
        });
    });
    
    // Icon Preview functionality
    const iconIdInput = document.getElementById('iconId');
    const itemPreview = document.getElementById('itemPreview');
    const previewStatus = document.getElementById('previewStatus');
    
    iconIdInput.addEventListener('change', function() {
        const iconId = this.value;
        if (iconId > 0) {
            const iconUrl = `/assets/images/icons/items/${iconId}.png`;
            
            // Test if image exists
            const img = new Image();
            img.onload = function() {
                itemPreview.src = iconUrl;
                previewStatus.textContent = 'Icon: ' + iconId;
                previewStatus.className = 'admin-status-indicator success';
            };
            img.onerror = function() {
                itemPreview.src = '/assets/images/icons/placeholder.png';
                previewStatus.textContent = 'Icon not found';
                previewStatus.className = 'admin-status-indicator error';
            };
            img.src = iconUrl;
        } else {
            itemPreview.src = '/assets/images/icons/placeholder.png';
            previewStatus.textContent = 'No Icon';
            previewStatus.className = 'admin-status-indicator';
        }
    });
});
</script>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>