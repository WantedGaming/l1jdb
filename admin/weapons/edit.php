<?php
// Admin weapon edit page
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $weaponData = [
        'desc_en' => $_POST['desc_en'] ?? $weapon['desc_en'],
        'desc_kr' => $_POST['desc_kr'] ?? $weapon['desc_kr'],
        'type' => $_POST['type'] ?? $weapon['type'],
        'material' => $_POST['material'] ?? $weapon['material'],
        'weight' => (int)($_POST['weight'] ?? $weapon['weight']),
        'dmg_small' => (int)($_POST['dmg_small'] ?? $weapon['dmg_small']),
        'dmg_large' => (int)($_POST['dmg_large'] ?? $weapon['dmg_large']),
        'hitmodifier' => (int)($_POST['hitmodifier'] ?? $weapon['hitmodifier']),
        'dmgmodifier' => (int)($_POST['dmgmodifier'] ?? $weapon['dmgmodifier']),
        'itemGrade' => $_POST['itemGrade'] ?? $weapon['itemGrade'],
        'add_str' => (int)($_POST['add_str'] ?? $weapon['add_str']),
        'add_con' => (int)($_POST['add_con'] ?? $weapon['add_con']),
        'add_dex' => (int)($_POST['add_dex'] ?? $weapon['add_dex']),
        'add_int' => (int)($_POST['add_int'] ?? $weapon['add_int']),
        'add_wis' => (int)($_POST['add_wis'] ?? $weapon['add_wis']),
        'add_cha' => (int)($_POST['add_cha'] ?? $weapon['add_cha']),
        'add_hp' => (int)($_POST['add_hp'] ?? $weapon['add_hp']),
        'add_mp' => (int)($_POST['add_mp'] ?? $weapon['add_mp']),
        'add_hpr' => (int)($_POST['add_hpr'] ?? $weapon['add_hpr']),
        'add_mpr' => (int)($_POST['add_mpr'] ?? $weapon['add_mpr']),
        'add_sp' => (int)($_POST['add_sp'] ?? $weapon['add_sp']),
        'min_lvl' => (int)($_POST['min_lvl'] ?? $weapon['min_lvl']),
        'max_lvl' => (int)($_POST['max_lvl'] ?? $weapon['max_lvl']),
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
        'note' => $_POST['note'] ?? $weapon['note'],
    ];
    
    // Update weapon
    if ($weaponsModel->updateWeapon($weaponId, $weaponData)) {
        // Log activity
        $user->logActivity(
            $currentUser['login'],
            'update',
            "Updated weapon: {$weaponData['desc_en']} (ID: $weaponId)",
            'weapon',
            $weaponId
        );
        
        // Redirect to the weapon detail page with success message
        header('Location: ../../public/weapons/detail.php?id=' . $weaponId . '&updated=1');
        exit;
    } else {
        $errorMessage = "Failed to update weapon. Please try again.";
    }
}

// Set page title
$pageTitle = "Edit Weapon: " . $weapon['desc_en'];

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
                    <a href="../../public/weapons/detail.php?id=<?php echo $weaponId; ?>" class="admin-button admin-button-info">
                        <i class="fas fa-eye"></i> View Weapon
                    </a>
                </div>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <!-- Edit Weapon Form -->
            <div class="admin-form-container">
                <form action="edit.php?id=<?php echo $weaponId; ?>" method="post" class="admin-form">
                    <!-- Basic Information -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Basic Information</h3>
                        
                        <div class="admin-form-group">
                            <label for="desc_en" class="admin-form-label">Name (English)</label>
                            <input type="text" id="desc_en" name="desc_en" class="admin-form-input" value="<?php echo htmlspecialchars($weapon['desc_en']); ?>" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="desc_kr" class="admin-form-label">Name (Korean)</label>
                            <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" value="<?php echo htmlspecialchars($weapon['desc_kr']); ?>" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="type" class="admin-form-label">Weapon Type</label>
                            <select id="type" name="type" class="admin-form-select" required>
                                <?php foreach ($weaponTypes as $type): ?>
                                <option value="<?php echo $type; ?>" <?php echo $weapon['type'] === $type ? 'selected' : ''; ?>>
                                    <?php echo $type; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="material" class="admin-form-label">Material</label>
                            <select id="material" name="material" class="admin-form-select" required>
                                <?php foreach ($weaponMaterials as $material): ?>
                                <option value="<?php echo $material; ?>" <?php echo $weapon['material'] === $material ? 'selected' : ''; ?>>
                                    <?php echo $material; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="weight" class="admin-form-label">Weight</label>
                            <input type="number" id="weight" name="weight" class="admin-form-input" value="<?php echo $weapon['weight']; ?>" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="itemGrade" class="admin-form-label">Grade</label>
                            <select id="itemGrade" name="itemGrade" class="admin-form-select" required>
                                <?php foreach ($weaponGrades as $grade): ?>
                                <option value="<?php echo $grade; ?>" <?php echo $weapon['itemGrade'] === $grade ? 'selected' : ''; ?>>
                                    <?php echo $grade; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Combat Stats -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Combat Stats</h3>
                        
                        <div class="admin-form-group">
                            <label for="dmg_small" class="admin-form-label">Small Damage</label>
                            <input type="number" id="dmg_small" name="dmg_small" class="admin-form-input" value="<?php echo $weapon['dmg_small']; ?>" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="dmg_large" class="admin-form-label">Large Damage</label>
                            <input type="number" id="dmg_large" name="dmg_large" class="admin-form-input" value="<?php echo $weapon['dmg_large']; ?>" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="hitmodifier" class="admin-form-label">Hit Modifier</label>
                            <input type="number" id="hitmodifier" name="hitmodifier" class="admin-form-input" value="<?php echo $weapon['hitmodifier']; ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="dmgmodifier" class="admin-form-label">Damage Modifier</label>
                            <input type="number" id="dmgmodifier" name="dmgmodifier" class="admin-form-input" value="<?php echo $weapon['dmgmodifier']; ?>">
                        </div>
                    </div>
                    
                    <!-- Stats Bonus -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Stats Bonus</h3>
                        
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label for="add_str" class="admin-form-label">STR</label>
                                <input type="number" id="add_str" name="add_str" class="admin-form-input" value="<?php echo $weapon['add_str']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="add_con" class="admin-form-label">CON</label>
                                <input type="number" id="add_con" name="add_con" class="admin-form-input" value="<?php echo $weapon['add_con']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="add_dex" class="admin-form-label">DEX</label>
                                <input type="number" id="add_dex" name="add_dex" class="admin-form-input" value="<?php echo $weapon['add_dex']; ?>">
                            </div>
                        </div>
                        
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label for="add_int" class="admin-form-label">INT</label>
                                <input type="number" id="add_int" name="add_int" class="admin-form-input" value="<?php echo $weapon['add_int']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="add_wis" class="admin-form-label">WIS</label>
                                <input type="number" id="add_wis" name="add_wis" class="admin-form-input" value="<?php echo $weapon['add_wis']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="add_cha" class="admin-form-label">CHA</label>
                                <input type="number" id="add_cha" name="add_cha" class="admin-form-input" value="<?php echo $weapon['add_cha']; ?>">
                            </div>
                        </div>
                        
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label for="add_hp" class="admin-form-label">HP</label>
                                <input type="number" id="add_hp" name="add_hp" class="admin-form-input" value="<?php echo $weapon['add_hp']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="add_mp" class="admin-form-label">MP</label>
                                <input type="number" id="add_mp" name="add_mp" class="admin-form-input" value="<?php echo $weapon['add_mp']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="add_sp" class="admin-form-label">SP</label>
                                <input type="number" id="add_sp" name="add_sp" class="admin-form-input" value="<?php echo $weapon['add_sp']; ?>">
                            </div>
                        </div>
                        
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label for="add_hpr" class="admin-form-label">HP Regen</label>
                                <input type="number" id="add_hpr" name="add_hpr" class="admin-form-input" value="<?php echo $weapon['add_hpr']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="add_mpr" class="admin-form-label">MP Regen</label>
                                <input type="number" id="add_mpr" name="add_mpr" class="admin-form-input" value="<?php echo $weapon['add_mpr']; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Level Requirements -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Level Requirements</h3>
                        
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label for="min_lvl" class="admin-form-label">Minimum Level</label>
                                <input type="number" id="min_lvl" name="min_lvl" class="admin-form-input" value="<?php echo $weapon['min_lvl']; ?>">
                            </div>
                            
                            <div class="admin-form-group">
                                <label for="max_lvl" class="admin-form-label">Maximum Level</label>
                                <input type="number" id="max_lvl" name="max_lvl" class="admin-form-input" value="<?php echo $weapon['max_lvl']; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Class Restrictions -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Class Restrictions</h3>
                        
                        <div class="admin-form-checkboxes">
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_royal" name="use_royal" <?php echo $weapon['use_royal'] ? 'checked' : ''; ?>>
                                <label for="use_royal" class="admin-form-checkbox-label">Royal</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_knight" name="use_knight" <?php echo $weapon['use_knight'] ? 'checked' : ''; ?>>
                                <label for="use_knight" class="admin-form-checkbox-label">Knight</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_mage" name="use_mage" <?php echo $weapon['use_mage'] ? 'checked' : ''; ?>>
                                <label for="use_mage" class="admin-form-checkbox-label">Mage</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_elf" name="use_elf" <?php echo $weapon['use_elf'] ? 'checked' : ''; ?>>
                                <label for="use_elf" class="admin-form-checkbox-label">Elf</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_darkelf" name="use_darkelf" <?php echo $weapon['use_darkelf'] ? 'checked' : ''; ?>>
                                <label for="use_darkelf" class="admin-form-checkbox-label">Dark Elf</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_dragonknight" name="use_dragonknight" <?php echo $weapon['use_dragonknight'] ? 'checked' : ''; ?>>
                                <label for="use_dragonknight" class="admin-form-checkbox-label">Dragon Knight</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_illusionist" name="use_illusionist" <?php echo $weapon['use_illusionist'] ? 'checked' : ''; ?>>
                                <label for="use_illusionist" class="admin-form-checkbox-label">Illusionist</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_warrior" name="use_warrior" <?php echo $weapon['use_warrior'] ? 'checked' : ''; ?>>
                                <label for="use_warrior" class="admin-form-checkbox-label">Warrior</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_fencer" name="use_fencer" <?php echo $weapon['use_fencer'] ? 'checked' : ''; ?>>
                                <label for="use_fencer" class="admin-form-checkbox-label">Fencer</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_lancer" name="use_lancer" <?php echo $weapon['use_lancer'] ? 'checked' : ''; ?>>
                                <label for="use_lancer" class="admin-form-checkbox-label">Lancer</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Description</h3>
                        
                        <div class="admin-form-group">
                            <label for="note" class="admin-form-label">Description/Notes</label>
                            <textarea id="note" name="note" class="admin-form-textarea" rows="5"><?php echo htmlspecialchars($weapon['note']); ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="admin-form-buttons">
                        <button type="submit" class="admin-button admin-button-primary">Update Weapon</button>
                        <a href="index.php" class="admin-button admin-button-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>
