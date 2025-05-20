<?php
// Admin weapon create page
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $weaponData = [
        // Basic Information
        'desc_en' => $_POST['desc_en'] ?? '',
        'desc_kr' => $_POST['desc_kr'] ?? '',
        'desc_powerbook' => $_POST['desc_powerbook'] ?? '',
        'desc_id' => $_POST['desc_id'] ?? '',
        'type' => $_POST['type'] ?? 'SWORD',
        'material' => $_POST['material'] ?? 'IRON(철)',
        'weight' => (int)($_POST['weight'] ?? 0),
        'itemGrade' => $_POST['itemGrade'] ?? 'NORMAL',
        'item_name_id' => (int)($_POST['item_name_id'] ?? 0),
        
        // Visual properties
        'iconId' => (int)($_POST['iconId'] ?? 0),
        'spriteId' => (int)($_POST['spriteId'] ?? 0),
        
        // Combat Stats
        'dmg_small' => (int)($_POST['dmg_small'] ?? 0),
        'dmg_large' => (int)($_POST['dmg_large'] ?? 0),
        'hitmodifier' => (int)($_POST['hitmodifier'] ?? 0),
        'dmgmodifier' => (int)($_POST['dmgmodifier'] ?? 0),
        'm_def' => (int)($_POST['m_def'] ?? 0),
        'magicdmgmodifier' => (int)($_POST['magicdmgmodifier'] ?? 0),
        'double_dmg_chance' => (int)($_POST['double_dmg_chance'] ?? 0),
        'haste_item' => (int)($_POST['haste_item'] ?? 0),
        
        // Critical Stats
        'shortCritical' => (int)($_POST['shortCritical'] ?? 0),
        'longCritical' => (int)($_POST['longCritical'] ?? 0),
        'magicCritical' => (int)($_POST['magicCritical'] ?? 0),
        
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
        'addDg' => (int)($_POST['addDg'] ?? 0),
        'addEr' => (int)($_POST['addEr'] ?? 0),
        'addMe' => (int)($_POST['addMe'] ?? 0),
        
        // Regeneration
        'hprAbsol32Second' => (int)($_POST['hprAbsol32Second'] ?? 0),
        'mprAbsol64Second' => (int)($_POST['mprAbsol64Second'] ?? 0),
        'mprAbsol16Second' => (int)($_POST['mprAbsol16Second'] ?? 0),
        
        // Level Requirements
        'min_lvl' => (int)($_POST['min_lvl'] ?? 0),
        'max_lvl' => (int)($_POST['max_lvl'] ?? 0),
        
        // Class Restrictions
        'use_royal' => isset($_POST['use_royal']) ? 1 : 0,
        'use_knight' => isset($_POST['use_knight']) ? 1 : 0,
        'use_mage' => isset($_POST['use_mage']) ? 1 : 0,
        'use_elf' => isset($_POST['use_elf']) ? 1 : 0,
        'use_darkelf' => isset($_POST['use_darkelf']) ? 1 : 0,
        'use_dragonknight' => isset($_POST['use_dragonknight']) ? 1 : 0,
        'use_illusionist' => isset($_POST['use_illusionist']) ? 1 : 0,
        'use_warrior' => isset($_POST['use_warrior']) ? 1 : 0,
        'use_fencer' => isset($_POST['use_fencer']) ? 1 : 0,
        'use_lancer' => isset($_POST['use_lancer']) ? 1 : 0,
        
        // Resistances
        'poisonRegist' => $_POST['poisonRegist'] ?? 'false',
        'regist_skill' => (int)($_POST['regist_skill'] ?? 0),
        'regist_spirit' => (int)($_POST['regist_spirit'] ?? 0),
        'regist_dragon' => (int)($_POST['regist_dragon'] ?? 0),
        'regist_fear' => (int)($_POST['regist_fear'] ?? 0),
        'regist_all' => (int)($_POST['regist_all'] ?? 0),
        'potionRegist' => (int)($_POST['potionRegist'] ?? 0),
        'potionPercent' => (int)($_POST['potionPercent'] ?? 0),
        'potionValue' => (int)($_POST['potionValue'] ?? 0),
        
        // Hit-up stats
        'hitup_skill' => (int)($_POST['hitup_skill'] ?? 0),
        'hitup_spirit' => (int)($_POST['hitup_spirit'] ?? 0),
        'hitup_dragon' => (int)($_POST['hitup_dragon'] ?? 0),
        'hitup_fear' => (int)($_POST['hitup_fear'] ?? 0),
        'hitup_all' => (int)($_POST['hitup_all'] ?? 0),
        'hitup_magic' => (int)($_POST['hitup_magic'] ?? 0),
        
        // Damage Reduction
        'damage_reduction' => (int)($_POST['damage_reduction'] ?? 0),
        'MagicDamageReduction' => (int)($_POST['MagicDamageReduction'] ?? 0),
        'reductionEgnor' => (int)($_POST['reductionEgnor'] ?? 0),
        'reductionPercent' => (int)($_POST['reductionPercent'] ?? 0),
        'imunEgnor' => (int)($_POST['imunEgnor'] ?? 0),
        
        // PVP Stats
        'PVPDamage' => (int)($_POST['PVPDamage'] ?? 0),
        'PVPDamageReduction' => (int)($_POST['PVPDamageReduction'] ?? 0),
        'PVPDamageReductionPercent' => (int)($_POST['PVPDamageReductionPercent'] ?? 0),
        'PVPMagicDamageReduction' => (int)($_POST['PVPMagicDamageReduction'] ?? 0),
        'PVPReductionEgnor' => (int)($_POST['PVPReductionEgnor'] ?? 0),
        'PVPMagicDamageReductionEgnor' => (int)($_POST['PVPMagicDamageReductionEgnor'] ?? 0),
        'abnormalStatusDamageReduction' => (int)($_POST['abnormalStatusDamageReduction'] ?? 0),
        'abnormalStatusPVPDamageReduction' => (int)($_POST['abnormalStatusPVPDamageReduction'] ?? 0),
        'PVPDamagePercent' => (int)($_POST['PVPDamagePercent'] ?? 0),
        
        // Special Properties
        'expBonus' => (int)($_POST['expBonus'] ?? 0),
        'rest_exp_reduce_efficiency' => (int)($_POST['rest_exp_reduce_efficiency'] ?? 0),
        'stunDuration' => (int)($_POST['stunDuration'] ?? 0),
        'tripleArrowStun' => (int)($_POST['tripleArrowStun'] ?? 0),
        'strangeTimeIncrease' => (int)($_POST['strangeTimeIncrease'] ?? 0),
        'strangeTimeDecrease' => (int)($_POST['strangeTimeDecrease'] ?? 0),
        'hpPotionDelayDecrease' => (int)($_POST['hpPotionDelayDecrease'] ?? 0),
        'hpPotionCriticalProb' => (int)($_POST['hpPotionCriticalProb'] ?? 0),
        'increaseArmorSkillProb' => (int)($_POST['increaseArmorSkillProb'] ?? 0),
        'attackSpeedDelayRate' => (int)($_POST['attackSpeedDelayRate'] ?? 0),
        'moveSpeedDelayRate' => (int)($_POST['moveSpeedDelayRate'] ?? 0),
        
        // Item Properties
        'safenchant' => (int)($_POST['safenchant'] ?? 0),
        'canbedmg' => isset($_POST['canbedmg']) ? 1 : 0,
        'bless' => isset($_POST['bless']) ? 1 : 0,
        'trade' => isset($_POST['trade']) ? 1 : 0,
        'retrieve' => isset($_POST['retrieve']) ? 1 : 0,
        'specialretrieve' => isset($_POST['specialretrieve']) ? 1 : 0,
        'cant_delete' => isset($_POST['cant_delete']) ? 1 : 0,
        'cant_sell' => isset($_POST['cant_sell']) ? 1 : 0,
        'max_use_time' => (int)($_POST['max_use_time'] ?? 0),
        
        // Magic Properties
        'Magic_name' => $_POST['Magic_name'] ?? null,
        
        // Notes
        'note' => $_POST['note'] ?? '',
    ];
    
    // Create weapon
    $newWeaponId = $weaponsModel->createWeapon($weaponData);
    if ($newWeaponId) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Log activity with null-safe username
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'create',
            "Added new weapon: {$weaponData['desc_en']} (ID: $newWeaponId)",
            'weapon',
            $newWeaponId
        );
        
        // Redirect to detail page with success message
        header('Location: ../../public/weapons/detail.php?id=' . $newWeaponId . '&created=1');
        exit;
    } else {
        $errorMessage = "Failed to create weapon. Please try again.";
    }
}

// Set page title
$pageTitle = "Add New Weapon";

// Get weapon types and grades for dropdowns
$weaponTypes = $weaponsModel->getWeaponTypes();
$weaponMaterials = $weaponsModel->getWeaponMaterials();
$weaponGrades = $weaponsModel->getWeaponGrades();

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
            
            <!-- Create Weapon Form -->
            <div class="admin-form-container">
                <form action="create.php" method="post" class="admin-form">
                    
                    <!-- First Row: Image Preview and Basic Info -->
                    <div class="admin-detail-layout">
                        <!-- Image Preview Card -->
                        <div class="admin-image-card">
                            <h3 class="admin-form-header">Weapon Preview</h3>
                            <div class="admin-image-container">
                                <img id="weaponPreview" src="/assets/images/icons/placeholder.png" alt="Weapon Preview" class="admin-image-large">
                                <div id="previewStatus" class="admin-status-indicator">No Image</div>
                            </div>
                            
                            <div class="admin-form-group" style="margin-top: 20px;">
                                <label for="iconId" class="admin-form-label">Icon ID</label>
                                <input type="number" id="iconId" name="iconId" class="admin-form-input" value="0">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="spriteId" class="admin-form-label">Sprite ID</label>
                                <input type="number" id="spriteId" name="spriteId" class="admin-form-input" value="0">
                            </div>
                        </div>
                        
                        <!-- Basic Info Card -->
                        <div class="admin-form-section" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none; background-color: var(--admin-dark);">
                            <h3 class="admin-form-header">Basic Information</h3>
                            
                            <div class="admin-basic-form">
                                <div class="admin-form-group">
                                    <label for="desc_en" class="admin-form-label">Name (English)</label>
                                    <input type="text" id="desc_en" name="desc_en" class="admin-form-input" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="desc_kr" class="admin-form-label">Name (Korean)</label>
                                    <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" required>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="type" class="admin-form-label">Weapon Type</label>
                                        <select id="type" name="type" class="admin-form-select" required>
                                            <?php foreach ($weaponTypes as $type): ?>
                                            <option value="<?php echo $type; ?>">
                                                <?php echo $type; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="itemGrade" class="admin-form-label">Grade</label>
                                        <select id="itemGrade" name="itemGrade" class="admin-form-select" required>
                                            <?php foreach ($weaponGrades as $grade): ?>
                                            <option value="<?php echo $grade; ?>">
                                                <?php echo $grade; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="material" class="admin-form-label">Material</label>
                                        <select id="material" name="material" class="admin-form-select" required>
                                            <?php foreach ($weaponMaterials as $material): ?>
                                            <option value="<?php echo $material; ?>">
                                                <?php echo $material; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="weight" class="admin-form-label">Weight</label>
                                        <input type="number" id="weight" name="weight" class="admin-form-input" value="0" required>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="item_name_id" class="admin-form-label">Item Name ID</label>
                                        <input type="number" id="item_name_id" name="item_name_id" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="safenchant" class="admin-form-label">Safe Enchant Level</label>
                                        <input type="number" id="safenchant" name="safenchant" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab Navigation -->
                    <div class="admin-tabs">
                        <ul class="admin-tabs-nav">
                            <li class="admin-tab-item active" data-tab="combat">Combat Stats</li>
                            <li class="admin-tab-item" data-tab="stats">Stat Bonuses</li>
                            <li class="admin-tab-item" data-tab="resistance">Resistances</li>
                            <li class="admin-tab-item" data-tab="pvp">PVP</li>
                            <li class="admin-tab-item" data-tab="special">Special</li>
                            <li class="admin-tab-item" data-tab="class">Classes</li>
                            <li class="admin-tab-item" data-tab="properties">Properties</li>
                            <li class="admin-tab-item" data-tab="description">Description</li>
                        </ul>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="admin-tabs-content">
                        
                        <!-- Combat Stats Tab -->
                        <div class="admin-tab-pane active" id="combat-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Combat Stats</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="dmg_small" class="admin-form-label">Small Damage</label>
                                        <input type="number" id="dmg_small" name="dmg_small" class="admin-form-input" value="0" required>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="dmg_large" class="admin-form-label">Large Damage</label>
                                        <input type="number" id="dmg_large" name="dmg_large" class="admin-form-input" value="0" required>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="hitmodifier" class="admin-form-label">Hit Modifier</label>
                                        <input type="number" id="hitmodifier" name="hitmodifier" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="dmgmodifier" class="admin-form-label">Damage Modifier</label>
                                        <input type="number" id="dmgmodifier" name="dmgmodifier" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="magicdmgmodifier" class="admin-form-label">Magic Damage Modifier</label>
                                        <input type="number" id="magicdmgmodifier" name="magicdmgmodifier" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="m_def" class="admin-form-label">Magic Defense</label>
                                        <input type="number" id="m_def" name="m_def" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="double_dmg_chance" class="admin-form-label">Double Damage Chance (%)</label>
                                        <input type="number" id="double_dmg_chance" name="double_dmg_chance" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="haste_item" class="admin-form-label">Haste Effect</label>
                                        <select id="haste_item" name="haste_item" class="admin-form-select">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Critical Stats</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="shortCritical" class="admin-form-label">Short Critical (%)</label>
                                        <input type="number" id="shortCritical" name="shortCritical" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="longCritical" class="admin-form-label">Long Critical (%)</label>
                                        <input type="number" id="longCritical" name="longCritical" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="magicCritical" class="admin-form-label">Magic Critical (%)</label>
                                        <input type="number" id="magicCritical" name="magicCritical" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Speed Stats</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="attackSpeedDelayRate" class="admin-form-label">Attack Speed Delay Rate (%)</label>
                                        <input type="number" id="attackSpeedDelayRate" name="attackSpeedDelayRate" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="moveSpeedDelayRate" class="admin-form-label">Move Speed Delay Rate (%)</label>
                                        <input type="number" id="moveSpeedDelayRate" name="moveSpeedDelayRate" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats Bonus Tab -->
                        <div class="admin-tab-pane" id="stats-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Base Stat Bonuses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_str" class="admin-form-label">STR</label>
                                        <input type="number" id="add_str" name="add_str" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_con" class="admin-form-label">CON</label>
                                        <input type="number" id="add_con" name="add_con" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_dex" class="admin-form-label">DEX</label>
                                        <input type="number" id="add_dex" name="add_dex" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_int" class="admin-form-label">INT</label>
                                        <input type="number" id="add_int" name="add_int" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_wis" class="admin-form-label">WIS</label>
                                        <input type="number" id="add_wis" name="add_wis" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_cha" class="admin-form-label">CHA</label>
                                        <input type="number" id="add_cha" name="add_cha" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="addDg" class="admin-form-label">DG</label>
                                        <input type="number" id="addDg" name="addDg" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="addEr" class="admin-form-label">ER</label>
                                        <input type="number" id="addEr" name="addEr" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="addMe" class="admin-form-label">ME</label>
                                        <input type="number" id="addMe" name="addMe" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Resource Bonuses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hp" class="admin-form-label">HP</label>
                                        <input type="number" id="add_hp" name="add_hp" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mp" class="admin-form-label">MP</label>
                                        <input type="number" id="add_mp" name="add_mp" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_sp" class="admin-form-label">SP</label>
                                        <input type="number" id="add_sp" name="add_sp" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hpr" class="admin-form-label">HP Regen</label>
                                        <input type="number" id="add_hpr" name="add_hpr" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mpr" class="admin-form-label">MP Regen</label>
                                        <input type="number" id="add_mpr" name="add_mpr" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Absolute Regeneration</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="hprAbsol32Second" class="admin-form-label">HP Regen (32s)</label>
                                        <input type="number" id="hprAbsol32Second" name="hprAbsol32Second" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="mprAbsol64Second" class="admin-form-label">MP Regen (64s)</label>
                                        <input type="number" id="mprAbsol64Second" name="mprAbsol64Second" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="mprAbsol16Second" class="admin-form-label">MP Regen (16s)</label>
                                        <input type="number" id="mprAbsol16Second" name="mprAbsol16Second" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Level Requirements</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="min_lvl" class="admin-form-label">Minimum Level</label>
                                        <input type="number" id="min_lvl" name="min_lvl" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="max_lvl" class="admin-form-label">Maximum Level</label>
                                        <input type="number" id="max_lvl" name="max_lvl" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Resistance Tab -->
                        <div class="admin-tab-pane" id="resistance-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Resistances</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_skill" class="admin-form-label">Resist Skill (%)</label>
                                        <input type="number" id="regist_skill" name="regist_skill" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_spirit" class="admin-form-label">Resist Spirit (%)</label>
                                        <input type="number" id="regist_spirit" name="regist_spirit" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_dragon" class="admin-form-label">Resist Dragon (%)</label>
                                        <input type="number" id="regist_dragon" name="regist_dragon" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_fear" class="admin-form-label">Resist Fear (%)</label>
                                        <input type="number" id="regist_fear" name="regist_fear" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_all" class="admin-form-label">Resist All (%)</label>
                                        <input type="number" id="regist_all" name="regist_all" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="poisonRegist" class="admin-form-label">Poison Resist</label>
                                        <select id="poisonRegist" name="poisonRegist" class="admin-form-select">
                                            <option value="false">No</option>
                                            <option value="true">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="imunEgnor" class="admin-form-label">Immunity Ignore (%)</label>
                                        <input type="number" id="imunEgnor" name="imunEgnor" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="damage_reduction" class="admin-form-label">Damage Reduction (%)</label>
                                        <input type="number" id="damage_reduction" name="damage_reduction" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="MagicDamageReduction" class="admin-form-label">Magic Damage Reduction (%)</label>
                                        <input type="number" id="MagicDamageReduction" name="MagicDamageReduction" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="reductionEgnor" class="admin-form-label">Reduction Ignore (%)</label>
                                        <input type="number" id="reductionEgnor" name="reductionEgnor" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="reductionPercent" class="admin-form-label">Reduction Percent (%)</label>
                                        <input type="number" id="reductionPercent" name="reductionPercent" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Hit-Up Bonuses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="hitup_skill" class="admin-form-label">Hit-Up Skill (%)</label>
                                        <input type="number" id="hitup_skill" name="hitup_skill" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="hitup_spirit" class="admin-form-label">Hit-Up Spirit (%)</label>
                                        <input type="number" id="hitup_spirit" name="hitup_spirit" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="hitup_dragon" class="admin-form-label">Hit-Up Dragon (%)</label>
                                        <input type="number" id="hitup_dragon" name="hitup_dragon" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="hitup_fear" class="admin-form-label">Hit-Up Fear (%)</label>
                                        <input type="number" id="hitup_fear" name="hitup_fear" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="hitup_all" class="admin-form-label">Hit-Up All (%)</label>
                                        <input type="number" id="hitup_all" name="hitup_all" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="hitup_magic" class="admin-form-label">Hit-Up Magic (%)</label>
                                        <input type="number" id="hitup_magic" name="hitup_magic" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Potion Related</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="potionRegist" class="admin-form-label">Potion Resist</label>
                                        <input type="number" id="potionRegist" name="potionRegist" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="potionPercent" class="admin-form-label">Potion Percent</label>
                                        <input type="number" id="potionPercent" name="potionPercent" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="potionValue" class="admin-form-label">Potion Value</label>
                                        <input type="number" id="potionValue" name="potionValue" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="hpPotionDelayDecrease" class="admin-form-label">HP Potion Delay Decrease</label>
                                        <input type="number" id="hpPotionDelayDecrease" name="hpPotionDelayDecrease" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="hpPotionCriticalProb" class="admin-form-label">HP Potion Critical Probability</label>
                                        <input type="number" id="hpPotionCriticalProb" name="hpPotionCriticalProb" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PVP Stats Tab -->
                        <div class="admin-tab-pane" id="pvp-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">PVP Stats</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="PVPDamage" class="admin-form-label">PVP Damage</label>
                                        <input type="number" id="PVPDamage" name="PVPDamage" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="PVPDamagePercent" class="admin-form-label">PVP Damage Percent (%)</label>
                                        <input type="number" id="PVPDamagePercent" name="PVPDamagePercent" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="PVPDamageReduction" class="admin-form-label">PVP Damage Reduction</label>
                                        <input type="number" id="PVPDamageReduction" name="PVPDamageReduction" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="PVPDamageReductionPercent" class="admin-form-label">PVP Damage Reduction Percent (%)</label>
                                        <input type="number" id="PVPDamageReductionPercent" name="PVPDamageReductionPercent" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="PVPMagicDamageReduction" class="admin-form-label">PVP Magic Damage Reduction</label>
                                        <input type="number" id="PVPMagicDamageReduction" name="PVPMagicDamageReduction" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="PVPReductionEgnor" class="admin-form-label">PVP Reduction Ignore (%)</label>
                                        <input type="number" id="PVPReductionEgnor" name="PVPReductionEgnor" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="PVPMagicDamageReductionEgnor" class="admin-form-label">PVP Magic Damage Reduction Ignore (%)</label>
                                        <input type="number" id="PVPMagicDamageReductionEgnor" name="PVPMagicDamageReductionEgnor" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Abnormal Status</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="abnormalStatusDamageReduction" class="admin-form-label">Abnormal Status Damage Reduction (%)</label>
                                        <input type="number" id="abnormalStatusDamageReduction" name="abnormalStatusDamageReduction" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="abnormalStatusPVPDamageReduction" class="admin-form-label">Abnormal Status PVP Damage Reduction (%)</label>
                                        <input type="number" id="abnormalStatusPVPDamageReduction" name="abnormalStatusPVPDamageReduction" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Special Properties Tab -->
                        <div class="admin-tab-pane" id="special-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Experience & Time</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="expBonus" class="admin-form-label">EXP Bonus (%)</label>
                                        <input type="number" id="expBonus" name="expBonus" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="rest_exp_reduce_efficiency" class="admin-form-label">Rest EXP Reduce Efficiency (%)</label>
                                        <input type="number" id="rest_exp_reduce_efficiency" name="rest_exp_reduce_efficiency" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="strangeTimeIncrease" class="admin-form-label">Strange Time Increase</label>
                                        <input type="number" id="strangeTimeIncrease" name="strangeTimeIncrease" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="strangeTimeDecrease" class="admin-form-label">Strange Time Decrease</label>
                                        <input type="number" id="strangeTimeDecrease" name="strangeTimeDecrease" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Stun Effects</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="stunDuration" class="admin-form-label">Stun Duration</label>
                                        <input type="number" id="stunDuration" name="stunDuration" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="tripleArrowStun" class="admin-form-label">Triple Arrow Stun</label>
                                        <input type="number" id="tripleArrowStun" name="tripleArrowStun" class="admin-form-input" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Other Effects</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="increaseArmorSkillProb" class="admin-form-label">Increase Armor Skill Probability</label>
                                        <input type="number" id="increaseArmorSkillProb" name="increaseArmorSkillProb" class="admin-form-input" value="0">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="Magic_name" class="admin-form-label">Magic Name</label>
                                        <input type="text" id="Magic_name" name="Magic_name" class="admin-form-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Class Restrictions Tab -->
                        <div class="admin-tab-pane" id="class-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Class Usage Permissions</h3>
                                
                                <div class="admin-property-toggles">
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_royal" name="use_royal">
                                        <label for="use_royal">Royal</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_knight" name="use_knight">
                                        <label for="use_knight">Knight</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_mage" name="use_mage">
                                        <label for="use_mage">Mage</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_elf" name="use_elf">
                                        <label for="use_elf">Elf</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_darkelf" name="use_darkelf">
                                        <label for="use_darkelf">Dark Elf</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_dragonknight" name="use_dragonknight">
                                        <label for="use_dragonknight">Dragon Knight</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_illusionist" name="use_illusionist">
                                        <label for="use_illusionist">Illusionist</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_warrior" name="use_warrior">
                                        <label for="use_warrior">Warrior</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_fencer" name="use_fencer">
                                        <label for="use_fencer">Fencer</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_lancer" name="use_lancer">
                                        <label for="use_lancer">Lancer</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Item Properties Tab -->
                        <div class="admin-tab-pane" id="properties-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Item Properties</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="max_use_time" class="admin-form-label">Maximum Use Time</label>
                                        <input type="number" id="max_use_time" name="max_use_time" class="admin-form-input" value="0">
                                    </div>
                                </div>
                                
                                <div class="admin-property-toggles">
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="canbedmg" name="canbedmg">
                                        <label for="canbedmg">Can Be Damaged</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="bless" name="bless" checked>
                                        <label for="bless">Blessed</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="trade" name="trade">
                                        <label for="trade">Cannot Trade</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="retrieve" name="retrieve">
                                        <label for="retrieve">Cannot Store</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="specialretrieve" name="specialretrieve">
                                        <label for="specialretrieve">Cannot Store Special</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="cant_delete" name="cant_delete">
                                        <label for="cant_delete">Cannot Delete</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="cant_sell" name="cant_sell">
                                        <label for="cant_sell">Cannot Sell</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description Tab -->
                        <div class="admin-tab-pane" id="description-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Additional Information</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="desc_powerbook" class="admin-form-label">Powerbook Description</label>
                                        <input type="text" id="desc_powerbook" name="desc_powerbook" class="admin-form-input">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="desc_id" class="admin-form-label">ID Description</label>
                                        <input type="text" id="desc_id" name="desc_id" class="admin-form-input">
                                    </div>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="note" class="admin-form-label">Description/Notes</label>
                                    <textarea id="note" name="note" class="admin-form-textarea" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="admin-form-buttons">
                        <button type="submit" class="admin-button admin-button-primary">Create Weapon</button>
                        <a href="index.php" class="admin-button admin-button-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<!-- JavaScript for Tabs and Image Preview -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab Navigation
    const tabItems = document.querySelectorAll('.admin-tab-item');
    const tabPanes = document.querySelectorAll('.admin-tab-pane');
    
    tabItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all tabs
            tabItems.forEach(tab => tab.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to current tab
            this.classList.add('active');
            
            // Show corresponding tab content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId + '-tab').classList.add('active');
        });
    });
    
    // Image Preview Functionality
    const iconIdInput = document.getElementById('iconId');
    const weaponPreview = document.getElementById('weaponPreview');
    const previewStatus = document.getElementById('previewStatus');
    
    // Base paths for images
    const iconBasePath = '/assets/images/icons/';
    
    // Function to update the weapon preview
    function updateWeaponPreview() {
        const iconId = iconIdInput.value;
        
        if (iconId && iconId > 0) {
            // Set status to loading
            previewStatus.textContent = 'Loading...';
            previewStatus.className = 'admin-status-indicator';
            
            // Create a new image element to test if the image exists
            const testImage = new Image();
            testImage.onload = function() {
                weaponPreview.src = iconBasePath + iconId + '.png';
                previewStatus.textContent = 'Icon #' + iconId;
                previewStatus.className = 'admin-status-indicator success';
            };
            testImage.onerror = function() {
                weaponPreview.src = iconBasePath + 'placeholder.png';
                previewStatus.textContent = 'Icon Not Found';
                previewStatus.className = 'admin-status-indicator error';
            };
            testImage.src = iconBasePath + iconId + '.png';
        } else {
            weaponPreview.src = iconBasePath + 'placeholder.png';
            previewStatus.textContent = 'No Image';
            previewStatus.className = 'admin-status-indicator';
        }
    }
    
    // Set up event listeners for the inputs
    iconIdInput.addEventListener('change', updateWeaponPreview);
    iconIdInput.addEventListener('input', updateWeaponPreview);
    
    // Initial preview update
    updateWeaponPreview();
});
</script>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>