<?php
// Admin armor edit page
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $armorData = [
        // Basic Information
        'desc_en' => $_POST['desc_en'] ?? '',
        'desc_kr' => $_POST['desc_kr'] ?? '',
        'desc_powerbook' => $_POST['desc_powerbook'] ?? '',
        'desc_id' => $_POST['desc_id'] ?? '',
        'type' => $_POST['type'] ?? 'NONE',
        'material' => $_POST['material'] ?? 'NONE(-)',
        'weight' => (int)($_POST['weight'] ?? 0),
        'itemGrade' => $_POST['itemGrade'] ?? 'NORMAL',
        'item_name_id' => (int)($_POST['item_name_id'] ?? 0),
        
        // Visual properties
        'iconId' => (int)($_POST['iconId'] ?? 0),
        'spriteId' => (int)($_POST['spriteId'] ?? 0),
        
        // Armor Stats
        'ac' => (int)($_POST['ac'] ?? 0),
        'ac_sub' => (int)($_POST['ac_sub'] ?? 0),
        'm_def' => (int)($_POST['m_def'] ?? 0),
        'damage_reduction' => (int)($_POST['damage_reduction'] ?? 0),
        'MagicDamageReduction' => (int)($_POST['MagicDamageReduction'] ?? 0),
        
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
        
        // Resistances
        'defense_water' => (int)($_POST['defense_water'] ?? 0),
        'defense_wind' => (int)($_POST['defense_wind'] ?? 0),
        'defense_fire' => (int)($_POST['defense_fire'] ?? 0),
        'defense_earth' => (int)($_POST['defense_earth'] ?? 0),
        'attr_all' => (int)($_POST['attr_all'] ?? 0),
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
        
        // Item Properties
        'safenchant' => (int)($_POST['safenchant'] ?? 0),
        'bless' => isset($_POST['bless']) ? 1 : 0,
        'trade' => isset($_POST['trade']) ? 1 : 0,
        'retrieve' => isset($_POST['retrieve']) ? 1 : 0,
        'specialretrieve' => isset($_POST['specialretrieve']) ? 1 : 0,
        'cant_delete' => isset($_POST['cant_delete']) ? 1 : 0,
        'cant_sell' => isset($_POST['cant_sell']) ? 1 : 0,
        'max_use_time' => (int)($_POST['max_use_time'] ?? 0),
        
        // Magic Properties
        'Magic_name' => $_POST['Magic_name'] ?? null,
        
        // Set Properties
        'Set_Id' => (int)($_POST['Set_Id'] ?? 0),
        
        // Notes
        'note' => $_POST['note'] ?? '',
    ];
    
    // Update armor
    if ($armorModel->updateArmor($armorId, $armorData)) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Log activity with null-safe username
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'update',
            "Updated armor: {$armorData['desc_en']} (ID: $armorId)",
            'armor',
            $armorId
        );
        
        // Redirect to detail page with success message
        header('Location: ../../public/armor/detail.php?id=' . $armorId . '&updated=1');
        exit;
    } else {
        $errorMessage = "Failed to update armor. Please try again.";
    }
}

// Set page title
$pageTitle = "Edit Armor: " . $armor['desc_en'];

// Get armor types and grades for dropdowns
$armorTypes = $armorModel->getArmorTypes();
$armorMaterials = $armorModel->getArmorMaterials();
$armorGrades = $armorModel->getArmorGrades();

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
                    <a href="../../public/armor/detail.php?id=<?php echo $armorId; ?>" class="admin-button admin-button-info">
                        <i class="fas fa-eye"></i> View Armor
                    </a>
                </div>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <!-- Edit Armor Form -->
            <div class="admin-form-container">
                <form action="edit.php?id=<?php echo $armorId; ?>" method="post" class="admin-form">
                    
                    <!-- First Row: Image Preview and Basic Info -->
                    <div class="admin-detail-layout">
                        <!-- Image Preview Card -->
                        <div class="admin-image-card">
                            <h3 class="admin-form-header">Armor Preview</h3>
                            <div class="admin-image-container">
                                <img id="armorPreview" src="<?php echo $armorModel->getArmorIconUrl($armor['iconId']); ?>" alt="Armor Preview" class="admin-image-large">
                                <div id="previewStatus" class="admin-status-indicator success">Icon: <?php echo $armor['iconId']; ?></div>
                            </div>
                            
                            <div class="admin-form-group" style="margin-top: 20px;">
                                <label for="iconId" class="admin-form-label">Icon ID</label>
                                <input type="number" id="iconId" name="iconId" class="admin-form-input" value="<?php echo $armor['iconId']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="spriteId" class="admin-form-label">Sprite ID</label>
                                <input type="number" id="spriteId" name="spriteId" class="admin-form-input" value="<?php echo $armor['spriteId']; ?>">
                            </div>
                        </div>
                        
                        <!-- Basic Info Card -->
                        <div class="admin-form-section" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none; background-color: var(--admin-dark);">
                            <h3 class="admin-form-header">Basic Information</h3>
                            
                            <div class="admin-basic-form">
                                <div class="admin-form-group">
                                    <label for="desc_en" class="admin-form-label">Name (English)</label>
                                    <input type="text" id="desc_en" name="desc_en" class="admin-form-input" value="<?php echo htmlspecialchars($armor['desc_en']); ?>" required>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="desc_kr" class="admin-form-label">Name (Korean)</label>
                                    <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" value="<?php echo htmlspecialchars($armor['desc_kr'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="type" class="admin-form-label">Armor Type</label>
                                        <select id="type" name="type" class="admin-form-select" required>
                                            <?php foreach ($armorTypes as $type): ?>
                                            <option value="<?php echo $type; ?>" <?php echo ($armor['type'] === $type) ? 'selected' : ''; ?>>
                                                <?php echo $type; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="itemGrade" class="admin-form-label">Grade</label>
                                        <select id="itemGrade" name="itemGrade" class="admin-form-select" required>
                                            <?php foreach ($armorGrades as $grade): ?>
                                            <option value="<?php echo $grade; ?>" <?php echo ($armor['itemGrade'] === $grade) ? 'selected' : ''; ?>>
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
                                            <?php foreach ($armorMaterials as $material): ?>
                                            <option value="<?php echo $material; ?>" <?php echo ($armor['material'] === $material) ? 'selected' : ''; ?>>
                                                <?php echo $material; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="weight" class="admin-form-label">Weight</label>
                                        <input type="number" id="weight" name="weight" class="admin-form-input" value="<?php echo $armor['weight']; ?>" required>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="item_name_id" class="admin-form-label">Item Name ID</label>
                                        <input type="number" id="item_name_id" name="item_name_id" class="admin-form-input" value="<?php echo $armor['item_name_id']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="safenchant" class="admin-form-label">Safe Enchant Level</label>
                                        <input type="number" id="safenchant" name="safenchant" class="admin-form-input" value="<?php echo $armor['safenchant']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="Set_Id" class="admin-form-label">Set ID</label>
                                        <input type="number" id="Set_Id" name="Set_Id" class="admin-form-input" value="<?php echo $armor['Set_Id']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab Navigation -->
                    <div class="admin-tabs">
                        <ul class="admin-tabs-nav">
                            <li class="admin-tab-item active" data-tab="defense">Defense Stats</li>
                            <li class="admin-tab-item" data-tab="stats">Stat Bonuses</li>
                            <li class="admin-tab-item" data-tab="resistance">Resistances</li>
                            <li class="admin-tab-item" data-tab="pvp">PVP</li>
                            <li class="admin-tab-item" data-tab="class">Classes</li>
                            <li class="admin-tab-item" data-tab="properties">Properties</li>
                            <li class="admin-tab-item" data-tab="description">Description</li>
                        </ul>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="admin-tabs-content">
                        
                        <!-- Defense Stats Tab -->
                        <div class="admin-tab-pane active" id="defense-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Defense Stats</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="ac" class="admin-form-label">AC</label>
                                        <input type="number" id="ac" name="ac" class="admin-form-input" value="<?php echo $armor['ac']; ?>" required>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="ac_sub" class="admin-form-label">AC Sub</label>
                                        <input type="number" id="ac_sub" name="ac_sub" class="admin-form-input" value="<?php echo $armor['ac_sub']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="m_def" class="admin-form-label">Magic Defense</label>
                                        <input type="number" id="m_def" name="m_def" class="admin-form-input" value="<?php echo $armor['m_def']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="damage_reduction" class="admin-form-label">Damage Reduction (%)</label>
                                        <input type="number" id="damage_reduction" name="damage_reduction" class="admin-form-input" value="<?php echo $armor['damage_reduction']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="MagicDamageReduction" class="admin-form-label">Magic Damage Reduction (%)</label>
                                        <input type="number" id="MagicDamageReduction" name="MagicDamageReduction" class="admin-form-input" value="<?php echo $armor['MagicDamageReduction']; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Elemental Defenses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="defense_water" class="admin-form-label">Water Defense</label>
                                        <input type="number" id="defense_water" name="defense_water" class="admin-form-input" value="<?php echo $armor['defense_water']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="defense_wind" class="admin-form-label">Wind Defense</label>
                                        <input type="number" id="defense_wind" name="defense_wind" class="admin-form-input" value="<?php echo $armor['defense_wind']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="defense_fire" class="admin-form-label">Fire Defense</label>
                                        <input type="number" id="defense_fire" name="defense_fire" class="admin-form-input" value="<?php echo $armor['defense_fire']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="defense_earth" class="admin-form-label">Earth Defense</label>
                                        <input type="number" id="defense_earth" name="defense_earth" class="admin-form-input" value="<?php echo $armor['defense_earth']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="attr_all" class="admin-form-label">All Elements Defense</label>
                                        <input type="number" id="attr_all" name="attr_all" class="admin-form-input" value="<?php echo $armor['attr_all']; ?>">
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
                                        <input type="number" id="add_str" name="add_str" class="admin-form-input" value="<?php echo $armor['add_str']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_con" class="admin-form-label">CON</label>
                                        <input type="number" id="add_con" name="add_con" class="admin-form-input" value="<?php echo $armor['add_con']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_dex" class="admin-form-label">DEX</label>
                                        <input type="number" id="add_dex" name="add_dex" class="admin-form-input" value="<?php echo $armor['add_dex']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_int" class="admin-form-label">INT</label>
                                        <input type="number" id="add_int" name="add_int" class="admin-form-input" value="<?php echo $armor['add_int']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_wis" class="admin-form-label">WIS</label>
                                        <input type="number" id="add_wis" name="add_wis" class="admin-form-input" value="<?php echo $armor['add_wis']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_cha" class="admin-form-label">CHA</label>
                                        <input type="number" id="add_cha" name="add_cha" class="admin-form-input" value="<?php echo $armor['add_cha']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="addDg" class="admin-form-label">DG</label>
                                        <input type="number" id="addDg" name="addDg" class="admin-form-input" value="<?php echo $armor['addDg']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="addEr" class="admin-form-label">ER</label>
                                        <input type="number" id="addEr" name="addEr" class="admin-form-input" value="<?php echo $armor['addEr']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="addMe" class="admin-form-label">ME</label>
                                        <input type="number" id="addMe" name="addMe" class="admin-form-input" value="<?php echo $armor['addMe']; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Resource Bonuses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hp" class="admin-form-label">HP</label>
                                        <input type="number" id="add_hp" name="add_hp" class="admin-form-input" value="<?php echo $armor['add_hp']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mp" class="admin-form-label">MP</label>
                                        <input type="number" id="add_mp" name="add_mp" class="admin-form-input" value="<?php echo $armor['add_mp']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_sp" class="admin-form-label">SP</label>
                                        <input type="number" id="add_sp" name="add_sp" class="admin-form-input" value="<?php echo $armor['add_sp']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hpr" class="admin-form-label">HP Regen</label>
                                        <input type="number" id="add_hpr" name="add_hpr" class="admin-form-input" value="<?php echo $armor['add_hpr']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mpr" class="admin-form-label">MP Regen</label>
                                        <input type="number" id="add_mpr" name="add_mpr" class="admin-form-input" value="<?php echo $armor['add_mpr']; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Level Requirements</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="min_lvl" class="admin-form-label">Minimum Level</label>
                                        <input type="number" id="min_lvl" name="min_lvl" class="admin-form-input" value="<?php echo $armor['min_lvl']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="max_lvl" class="admin-form-label">Maximum Level</label>
                                        <input type="number" id="max_lvl" name="max_lvl" class="admin-form-input" value="<?php echo $armor['max_lvl']; ?>">
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
                                        <label for="regist_stone" class="admin-form-label">Stone Resistance (%)</label>
                                        <input type="number" id="regist_stone" name="regist_stone" class="admin-form-input" value="<?php echo $armor['regist_stone']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_sleep" class="admin-form-label">Sleep Resistance (%)</label>
                                        <input type="number" id="regist_sleep" name="regist_sleep" class="admin-form-input" value="<?php echo $armor['regist_sleep']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_freeze" class="admin-form-label">Freeze Resistance (%)</label>
                                        <input type="number" id="regist_freeze" name="regist_freeze" class="admin-form-input" value="<?php echo $armor['regist_freeze']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_blind" class="admin-form-label">Blind Resistance (%)</label>
                                        <input type="number" id="regist_blind" name="regist_blind" class="admin-form-input" value="<?php echo $armor['regist_blind']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_skill" class="admin-form-label">Skill Resistance (%)</label>
                                        <input type="number" id="regist_skill" name="regist_skill" class="admin-form-input" value="<?php echo $armor['regist_skill']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_spirit" class="admin-form-label">Spirit Resistance (%)</label>
                                        <input type="number" id="regist_spirit" name="regist_spirit" class="admin-form-input" value="<?php echo $armor['regist_spirit']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_dragon" class="admin-form-label">Dragon Resistance (%)</label>
                                        <input type="number" id="regist_dragon" name="regist_dragon" class="admin-form-input" value="<?php echo $armor['regist_dragon']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_fear" class="admin-form-label">Fear Resistance (%)</label>
                                        <input type="number" id="regist_fear" name="regist_fear" class="admin-form-input" value="<?php echo $armor['regist_fear']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_all" class="admin-form-label">All Resistance (%)</label>
                                        <input type="number" id="regist_all" name="regist_all" class="admin-form-input" value="<?php echo $armor['regist_all']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="poisonRegist" class="admin-form-label">Poison Resistance</label>
                                        <select id="poisonRegist" name="poisonRegist" class="admin-form-select">
                                            <option value="false" <?php echo ($armor['poisonRegist'] === 'false') ? 'selected' : ''; ?>>No</option>
                                            <option value="true" <?php echo ($armor['poisonRegist'] === 'true') ? 'selected' : ''; ?>>Yes</option>
                                        </select>
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
                                        <input type="number" id="PVPDamage" name="PVPDamage" class="admin-form-input" value="<?php echo $armor['PVPDamage']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="PVPDamagePercent" class="admin-form-label">PVP Damage Percent (%)</label>
                                        <input type="number" id="PVPDamagePercent" name="PVPDamagePercent" class="admin-form-input" value="<?php echo $armor['PVPDamagePercent']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="PVPDamageReduction" class="admin-form-label">PVP Damage Reduction</label>
                                        <input type="number" id="PVPDamageReduction" name="PVPDamageReduction" class="admin-form-input" value="<?php echo $armor['PVPDamageReduction']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="PVPDamageReductionPercent" class="admin-form-label">PVP Damage Reduction Percent (%)</label>
                                        <input type="number" id="PVPDamageReductionPercent" name="PVPDamageReductionPercent" class="admin-form-input" value="<?php echo $armor['PVPDamageReductionPercent']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="PVPMagicDamageReduction" class="admin-form-label">PVP Magic Damage Reduction</label>
                                        <input type="number" id="PVPMagicDamageReduction" name="PVPMagicDamageReduction" class="admin-form-input" value="<?php echo $armor['PVPMagicDamageReduction']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="PVPReductionEgnor" class="admin-form-label">PVP Reduction Ignore</label>
                                        <input type="number" id="PVPReductionEgnor" name="PVPReductionEgnor" class="admin-form-input" value="<?php echo $armor['PVPReductionEgnor']; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="PVPMagicDamageReductionEgnor" class="admin-form-label">PVP Magic Damage Reduction Ignore</label>
                                        <input type="number" id="PVPMagicDamageReductionEgnor" name="PVPMagicDamageReductionEgnor" class="admin-form-input" value="<?php echo $armor['PVPMagicDamageReductionEgnor']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="abnormalStatusPVPDamageReduction" class="admin-form-label">Abnormal Status PVP Damage Reduction</label>
                                        <input type="number" id="abnormalStatusPVPDamageReduction" name="abnormalStatusPVPDamageReduction" class="admin-form-input" value="<?php echo $armor['abnormalStatusPVPDamageReduction']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Class Restrictions Tab -->
                        <div class="admin-tab-pane" id="class-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Class Restrictions</h3>
                                
                                <div class="admin-property-toggles">
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_royal" name="use_royal" <?php echo $armor['use_royal'] ? 'checked' : ''; ?>>
                                        <label for="use_royal">Royal</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_knight" name="use_knight" <?php echo $armor['use_knight'] ? 'checked' : ''; ?>>
                                        <label for="use_knight">Knight</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_mage" name="use_mage" <?php echo $armor['use_mage'] ? 'checked' : ''; ?>>
                                        <label for="use_mage">Mage</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_elf" name="use_elf" <?php echo $armor['use_elf'] ? 'checked' : ''; ?>>
                                        <label for="use_elf">Elf</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_darkelf" name="use_darkelf" <?php echo $armor['use_darkelf'] ? 'checked' : ''; ?>>
                                        <label for="use_darkelf">Dark Elf</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_dragonknight" name="use_dragonknight" <?php echo $armor['use_dragonknight'] ? 'checked' : ''; ?>>
                                        <label for="use_dragonknight">Dragon Knight</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_illusionist" name="use_illusionist" <?php echo $armor['use_illusionist'] ? 'checked' : ''; ?>>
                                        <label for="use_illusionist">Illusionist</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_warrior" name="use_warrior" <?php echo $armor['use_warrior'] ? 'checked' : ''; ?>>
                                        <label for="use_warrior">Warrior</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_fencer" name="use_fencer" <?php echo $armor['use_fencer'] ? 'checked' : ''; ?>>
                                        <label for="use_fencer">Fencer</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="use_lancer" name="use_lancer" <?php echo $armor['use_lancer'] ? 'checked' : ''; ?>>
                                        <label for="use_lancer">Lancer</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Properties Tab -->
                        <div class="admin-tab-pane" id="properties-tab">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Item Properties</h3>
                                
                                <div class="admin-property-toggles">
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="bless" name="bless" <?php echo $armor['bless'] ? 'checked' : ''; ?>>
                                        <label for="bless">Blessed</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="trade" name="trade" <?php echo $armor['trade'] ? 'checked' : ''; ?>>
                                        <label for="trade">Can Not Trade</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="retrieve" name="retrieve" <?php echo $armor['retrieve'] ? 'checked' : ''; ?>>
                                        <label for="retrieve">Can Not Store</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="specialretrieve" name="specialretrieve" <?php echo $armor['specialretrieve'] ? 'checked' : ''; ?>>
                                        <label for="specialretrieve">Can Not Store Special</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="cant_delete" name="cant_delete" <?php echo $armor['cant_delete'] ? 'checked' : ''; ?>>
                                        <label for="cant_delete">Can Not Delete</label>
                                    </div>
                                    
                                    <div class="admin-property-toggle">
                                        <input type="checkbox" id="cant_sell" name="cant_sell" <?php echo $armor['cant_sell'] ? 'checked' : ''; ?>>
                                        <label for="cant_sell">Can Not Sell</label>
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="max_use_time" class="admin-form-label">Max Use Time</label>
                                        <input type="number" id="max_use_time" name="max_use_time" class="admin-form-input" value="<?php echo $armor['max_use_time']; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="Magic_name" class="admin-form-label">Magic Effect Name</label>
                                        <input type="text" id="Magic_name" name="Magic_name" class="admin-form-input" value="<?php echo htmlspecialchars($armor['Magic_name'] ?? ''); ?>">
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
                                    <textarea id="note" name="note" class="admin-form-textarea" rows="8"><?php echo htmlspecialchars($armor['note'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="desc_powerbook" class="admin-form-label">Powerbook Description</label>
                                    <input type="text" id="desc_powerbook" name="desc_powerbook" class="admin-form-input" value="<?php echo htmlspecialchars($armor['desc_powerbook'] ?? ''); ?>">
                                </div>
                                
                                <div class="admin-form-group">
                                    <label for="desc_id" class="admin-form-label">Description ID</label>
                                    <input type="text" id="desc_id" name="desc_id" class="admin-form-input" value="<?php echo htmlspecialchars($armor['desc_id'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="admin-form-buttons">
                        <a href="index.php" class="admin-button admin-button-secondary">Cancel</a>
                        <button type="submit" class="admin-button admin-button-primary">Update Armor</button>
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
    const armorPreview = document.getElementById('armorPreview');
    const previewStatus = document.getElementById('previewStatus');
    
    iconIdInput.addEventListener('change', function() {
        const iconId = this.value;
        if (iconId > 0) {
            const iconUrl = `/assets/images/icons/items/${iconId}.png`;
            
            // Test if image exists
            const img = new Image();
            img.onload = function() {
                armorPreview.src = iconUrl;
                previewStatus.textContent = 'Icon: ' + iconId;
                previewStatus.className = 'admin-status-indicator success';
            };
            img.onerror = function() {
                armorPreview.src = '/assets/images/icons/placeholder.png';
                previewStatus.textContent = 'Icon not found';
                previewStatus.className = 'admin-status-indicator error';
            };
            img.src = iconUrl;
        } else {
            armorPreview.src = '/assets/images/icons/placeholder.png';
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