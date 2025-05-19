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
        'desc_en' => $_POST['desc_en'] ?? '',
        'desc_kr' => $_POST['desc_kr'] ?? '',
        'type' => $_POST['type'] ?? 'SWORD',
        'material' => $_POST['material'] ?? 'IRON(철)',
        'weight' => (int)($_POST['weight'] ?? 0),
        'dmg_small' => (int)($_POST['dmg_small'] ?? 0),
        'dmg_large' => (int)($_POST['dmg_large'] ?? 0),
        'hitmodifier' => (int)($_POST['hitmodifier'] ?? 0),
        'dmgmodifier' => (int)($_POST['dmgmodifier'] ?? 0),
        'itemGrade' => $_POST['itemGrade'] ?? 'NORMAL',
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
        'min_lvl' => (int)($_POST['min_lvl'] ?? 0),
        'max_lvl' => (int)($_POST['max_lvl'] ?? 0),
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
        'note' => $_POST['note'] ?? '',
        // Default values for required fields
        'iconId' => 0, // This would normally be set from an upload form
        'spriteId' => 0,
        'safenchant' => 0,
        'bless' => 1,
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
        
        // Redirect to index with success message
        header('Location: index.php?created=1');
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
                    <!-- Basic Information -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Basic Information</h3>
                        
                        <div class="admin-form-group">
                            <label for="desc_en" class="admin-form-label">Name (English)</label>
                            <input type="text" id="desc_en" name="desc_en" class="admin-form-input" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="desc_kr" class="admin-form-label">Name (Korean)</label>
                            <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" required>
                        </div>
                        
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
                    
                    <!-- Combat Stats -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Combat Stats</h3>
                        
                        <div class="admin-form-group">
                            <label for="dmg_small" class="admin-form-label">Small Damage</label>
                            <input type="number" id="dmg_small" name="dmg_small" class="admin-form-input" value="0" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="dmg_large" class="admin-form-label">Large Damage</label>
                            <input type="number" id="dmg_large" name="dmg_large" class="admin-form-input" value="0" required>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="hitmodifier" class="admin-form-label">Hit Modifier</label>
                            <input type="number" id="hitmodifier" name="hitmodifier" class="admin-form-input" value="0">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="dmgmodifier" class="admin-form-label">Damage Modifier</label>
                            <input type="number" id="dmgmodifier" name="dmgmodifier" class="admin-form-input" value="0">
                        </div>
                    </div>
                    
                    <!-- Stats Bonus -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Stats Bonus</h3>
                        
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
                    
                    <!-- Level Requirements -->
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
                    
                    <!-- Class Restrictions -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Class Restrictions</h3>
                        
                        <div class="admin-form-checkboxes">
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_royal" name="use_royal">
                                <label for="use_royal" class="admin-form-checkbox-label">Royal</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_knight" name="use_knight">
                                <label for="use_knight" class="admin-form-checkbox-label">Knight</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_mage" name="use_mage">
                                <label for="use_mage" class="admin-form-checkbox-label">Mage</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_elf" name="use_elf">
                                <label for="use_elf" class="admin-form-checkbox-label">Elf</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_darkelf" name="use_darkelf">
                                <label for="use_darkelf" class="admin-form-checkbox-label">Dark Elf</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_dragonknight" name="use_dragonknight">
                                <label for="use_dragonknight" class="admin-form-checkbox-label">Dragon Knight</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_illusionist" name="use_illusionist">
                                <label for="use_illusionist" class="admin-form-checkbox-label">Illusionist</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_warrior" name="use_warrior">
                                <label for="use_warrior" class="admin-form-checkbox-label">Warrior</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_fencer" name="use_fencer">
                                <label for="use_fencer" class="admin-form-checkbox-label">Fencer</label>
                            </div>
                            
                            <div class="admin-form-checkbox-group">
                                <input type="checkbox" id="use_lancer" name="use_lancer">
                                <label for="use_lancer" class="admin-form-checkbox-label">Lancer</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="admin-form-section">
                        <h3 class="admin-form-section-title">Description</h3>
                        
                        <div class="admin-form-group">
                            <label for="note" class="admin-form-label">Description/Notes</label>
                            <textarea id="note" name="note" class="admin-form-textarea" rows="5"></textarea>
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

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>