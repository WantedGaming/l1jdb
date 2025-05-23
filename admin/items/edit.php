<?php
// Admin item edit page
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $itemData = [
        // Basic Information
        'desc_en' => $_POST['desc_en'] ?? $item['desc_en'],
        'desc_kr' => $_POST['desc_kr'] ?? $item['desc_kr'],
        'item_type' => $_POST['item_type'] ?? $item['item_type'],
        'use_type' => $_POST['use_type'] ?? $item['use_type'],
        'material' => $_POST['material'] ?? $item['material'],
        'weight' => (int)($_POST['weight'] ?? $item['weight']),
        'itemGrade' => $_POST['itemGrade'] ?? $item['itemGrade'],
        
        // Visual properties
        'iconId' => (int)($_POST['iconId'] ?? $item['iconId']),
        'spriteId' => (int)($_POST['spriteId'] ?? $item['spriteId']),
        
        // Item specific properties
        'max_charge_count' => (int)($_POST['max_charge_count'] ?? $item['max_charge_count']),
        'food_volume' => (int)($_POST['food_volume'] ?? $item['food_volume']),
        'min_lvl' => (int)($_POST['min_lvl'] ?? $item['min_lvl']),
        'max_lvl' => (int)($_POST['max_lvl'] ?? $item['max_lvl']),
        
        // Combat Stats
        'dmg_small' => (int)($_POST['dmg_small'] ?? $item['dmg_small']),
        'dmg_large' => (int)($_POST['dmg_large'] ?? $item['dmg_large']),
        'shortHit' => (int)($_POST['shortHit'] ?? $item['shortHit']),
        'longHit' => (int)($_POST['longHit'] ?? $item['longHit']),
        'shortDmg' => (int)($_POST['shortDmg'] ?? $item['shortDmg']),
        'longDmg' => (int)($_POST['longDmg'] ?? $item['longDmg']),
        
        // Stat Bonuses
        'add_str' => (int)($_POST['add_str'] ?? $item['add_str']),
        'add_con' => (int)($_POST['add_con'] ?? $item['add_con']),
        'add_dex' => (int)($_POST['add_dex'] ?? $item['add_dex']),
        'add_int' => (int)($_POST['add_int'] ?? $item['add_int']),
        'add_wis' => (int)($_POST['add_wis'] ?? $item['add_wis']),
        'add_cha' => (int)($_POST['add_cha'] ?? $item['add_cha']),
        'add_hp' => (int)($_POST['add_hp'] ?? $item['add_hp']),
        'add_mp' => (int)($_POST['add_mp'] ?? $item['add_mp']),
        'add_hpr' => (int)($_POST['add_hpr'] ?? $item['add_hpr']),
        'add_mpr' => (int)($_POST['add_mpr'] ?? $item['add_mpr']),
        'add_sp' => (int)($_POST['add_sp'] ?? $item['add_sp']),
        
        // Resistances
        'regist_stone' => (int)($_POST['regist_stone'] ?? $item['regist_stone']),
        'regist_sleep' => (int)($_POST['regist_sleep'] ?? $item['regist_sleep']),
        'regist_freeze' => (int)($_POST['regist_freeze'] ?? $item['regist_freeze']),
        'regist_blind' => (int)($_POST['regist_blind'] ?? $item['regist_blind']),
        'regist_skill' => (int)($_POST['regist_skill'] ?? $item['regist_skill']),
        'regist_spirit' => (int)($_POST['regist_spirit'] ?? $item['regist_spirit']),
        'regist_dragon' => (int)($_POST['regist_dragon'] ?? $item['regist_dragon']),
        'regist_fear' => (int)($_POST['regist_fear'] ?? $item['regist_fear']),
        'regist_all' => (int)($_POST['regist_all'] ?? $item['regist_all']),
        'poisonRegist' => $_POST['poisonRegist'] ?? $item['poisonRegist'],
        
        // Item Properties
        'bless' => isset($_POST['bless']) ? 1 : 0,
        'trade' => isset($_POST['trade']) ? 1 : 0,
        'retrieve' => isset($_POST['retrieve']) ? 1 : 0,
        'specialretrieve' => isset($_POST['specialretrieve']) ? 1 : 0,
        'cant_delete' => isset($_POST['cant_delete']) ? 1 : 0,
        'cant_sell' => isset($_POST['cant_sell']) ? 1 : 0,
        'merge' => $_POST['merge'] ?? $item['merge'],
        
        // Magic Properties
        'Magic_name' => $_POST['Magic_name'] ?? $item['Magic_name'],
        
        // Notes
        'note' => $_POST['note'] ?? $item['note'],
    ];
    
    // Update item
    if ($itemModel->updateItem($itemId, $itemData)) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Log activity with null-safe username
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'update',
            "Updated item: {$itemData['desc_en']} (ID: $itemId)",
            'item',
            $itemId
        );
        
        // Redirect to detail page with success message
        header('Location: ../../public/items/detail.php?id=' . $itemId . '&updated=1');
        exit;
    } else {
        $errorMessage = "Failed to update item. Please try again.";
    }
}

// Set page title
$pageTitle = "Edit Item: " . cleanItemName($item['desc_en']);

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
            
            <!-- Edit Item Form -->
            <div class="admin-form-container">
                <form action="edit.php?id=<?php echo $itemId; ?>" method="post" class="admin-form">
                    
                    <!-- First Row: Image Preview and Basic Info -->
                    <div class="admin-detail-layout">
                        <!-- Image Preview Card -->
                        <div class="admin-image-card">
                            <h3 class="admin-form-header">Item Preview</h3>
                            <div class="admin-image-container">
                                <img id="itemPreview" src="<?php echo getItemIconUrl($item['iconId']); ?>" alt="Item Preview" class="admin-image-large">
                                <div id="previewStatus" class="admin-status-indicator success">Icon: <?php echo $item['iconId']; ?></div>
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
                                    <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" value="<?php echo htmlspecialchars($item['desc_kr'] ?? ''); ?>" required>
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
                                                <?php echo formatGrade($grade); ?>
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
                                        <input type="number" id="max_charge_count" name="max_charge_count" class="admin-form-input" value="<?php echo $item['max_charge_count'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="food_volume" class="admin-form-label">Food Volume</label>
                                        <input type="number" id="food_volume" name="food_volume" class="admin-form-input" value="<?php echo $item['food_volume'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="min_lvl" class="admin-form-label">Minimum Level</label>
                                        <input type="number" id="min_lvl" name="min_lvl" class="admin-form-input" value="<?php echo $item['min_lvl'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="max_lvl" class="admin-form-label">Maximum Level</label>
                                        <input type="number" id="max_lvl" name="max_lvl" class="admin-form-input" value="<?php echo $item['max_lvl'] ?? 0; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Combat Stats</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="dmg_small" class="admin-form-label">Small Damage</label>
                                        <input type="number" id="dmg_small" name="dmg_small" class="admin-form-input" value="<?php echo $item['dmg_small'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="dmg_large" class="admin-form-label">Large Damage</label>
                                        <input type="number" id="dmg_large" name="dmg_large" class="admin-form-input" value="<?php echo $item['dmg_large'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="shortHit" class="admin-form-label">Short Range Hit</label>
                                        <input type="number" id="shortHit" name="shortHit" class="admin-form-input" value="<?php echo $item['shortHit'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="longHit" class="admin-form-label">Long Range Hit</label>
                                        <input type="number" id="longHit" name="longHit" class="admin-form-input" value="<?php echo $item['longHit'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="shortDmg" class="admin-form-label">Short Range Damage</label>
                                        <input type="number" id="shortDmg" name="shortDmg" class="admin-form-input" value="<?php echo $item['shortDmg'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="longDmg" class="admin-form-label">Long Range Damage</label>
                                        <input type="number" id="longDmg" name="longDmg" class="admin-form-input" value="<?php echo $item['longDmg'] ?? 0; ?>">
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
                                        <input type="number" id="add_str" name="add_str" class="admin-form-input" value="<?php echo $item['add_str'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_con" class="admin-form-label">CON</label>
                                        <input type="number" id="add_con" name="add_con" class="admin-form-input" value="<?php echo $item['add_con'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_dex" class="admin-form-label">DEX</label>
                                        <input type="number" id="add_dex" name="add_dex" class="admin-form-input" value="<?php echo $item['add_dex'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_int" class="admin-form-label">INT</label>
                                        <input type="number" id="add_int" name="add_int" class="admin-form-input" value="<?php echo $item['add_int'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_wis" class="admin-form-label">WIS</label>
                                        <input type="number" id="add_wis" name="add_wis" class="admin-form-input" value="<?php echo $item['add_wis'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_cha" class="admin-form-label">CHA</label>
                                        <input type="number" id="add_cha" name="add_cha" class="admin-form-input" value="<?php echo $item['add_cha'] ?? 0; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Resource Bonuses</h3>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hp" class="admin-form-label">HP</label>
                                        <input type="number" id="add_hp" name="add_hp" class="admin-form-input" value="<?php echo $item['add_hp'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mp" class="admin-form-label">MP</label>
                                        <input type="number" id="add_mp" name="add_mp" class="admin-form-input" value="<?php echo $item['add_mp'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_sp" class="admin-form-label">SP</label>
                                        <input type="number" id="add_sp" name="add_sp" class="admin-form-input" value="<?php echo $item['add_sp'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="add_hpr" class="admin-form-label">HP Regen</label>
                                        <input type="number" id="add_hpr" name="add_hpr" class="admin-form-input" value="<?php echo $item['add_hpr'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="add_mpr" class="admin-form-label">MP Regen</label>
                                        <input type="number" id="add_mpr" name="add_mpr" class="admin-form-input" value="<?php echo $item['add_mpr'] ?? 0; ?>">
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
                                        <input type="number" id="regist_stone" name="regist_stone" class="admin-form-input" value="<?php echo $item['regist_stone'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_sleep" class="admin-form-label">Sleep Resistance (%)</label>
                                        <input type="number" id="regist_sleep" name="regist_sleep" class="admin-form-input" value="<?php echo $item['regist_sleep'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_freeze" class="admin-form-label">Freeze Resistance (%)</label>
                                        <input type="number" id="regist_freeze" name="regist_freeze" class="admin-form-input" value="<?php echo $item['regist_freeze'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_blind" class="admin-form-label">Blind Resistance (%)</label>
                                        <input type="number" id="regist_blind" name="regist_blind" class="admin-form-input" value="<?php echo $item['regist_blind'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_skill" class="admin-form-label">Skill Resistance (%)</label>
                                        <input type="number" id="regist_skill" name="regist_skill" class="admin-form-input" value="<?php echo $item['regist_skill'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_spirit" class="admin-form-label">Spirit Resistance (%)</label>
                                        <input type="number" id="regist_spirit" name="regist_spirit" class="admin-form-input" value="<?php echo $item['regist_spirit'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_dragon" class="admin-form-label">Dragon Resistance (%)</label>
                                        <input type="number" id="regist_dragon" name="regist_dragon" class="admin-form-input" value="<?php echo $item['regist_dragon'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="regist_fear" class="admin-form-label">Fear Resistance (%)</label>
                                        <input type="number" id="regist_fear" name="regist_fear" class="admin-form-input" value="<?php echo $item['regist_fear'] ?? 0; ?>">
                                    </div>
                                </div>
                                
                                <div class="admin-form-row">
                                    <div class="admin-form-group">
                                        <label for="regist_all" class="admin-form-label">All Resistance (%)</label>
                                        <input type="number" id="regist_all" name="regist_all" class="admin-form-input" value="<?php echo $item['regist_all'] ?? 0; ?>">
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="poisonRegist" class="admin-form-label">Poison Resistance</label>
                                        <select id="poisonRegist" name="poisonRegist" class="admin-form-select">
                                            <option value="false" <?php echo ($item['poisonRegist'] === 'false' || !isset($item['poisonRegist'])) ? 'selected' : ''; ?>>No</option>
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
                                            <option value="false" <?php echo ($item['merge'] === 'false' || !isset($item['merge'])) ? 'selected' : ''; ?>>No</option>
                                            <option value="true" <?php echo ($item['merge'] === 'true') ? 'selected' : ''; ?>>Yes</option>
                                        </select>
                                    </div>
                                    
                                    <div class="admin-form-group">
                                        <label for="Magic_name" class="admin-form-label">Magic Effect Name</label>
                                        <input type="text" id="Magic_name" name="Magic_name" class="admin-form-input" value="<?php echo htmlspecialchars($item['Magic_name'] ?? ''); ?>">
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
                                    <textarea id="note" name="note" class="admin-form-textarea" rows="8"><?php echo htmlspecialchars($item['note'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="admin-form-buttons">
                        <a href="index.php" class="admin-button admin-button-secondary">Cancel</a>
                        <button type="submit" class="admin-button admin-button-primary">Update Item</button>
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