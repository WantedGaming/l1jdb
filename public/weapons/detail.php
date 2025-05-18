<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Weapon.php';
require_once __DIR__ . '/../../includes/functions.php'; // Add this line to include our helper functions

// Initialize session
init_session();

// Initialize user
$user = new User();

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

// Get weapon skills
$weaponSkills = $weaponsModel->getWeaponSkills($weaponId);

// Set page title
$pageTitle = cleanItemName($weapon['desc_en']) . ' - Weapon Details';

// Include header
$heroTitle = cleanItemName($weapon['desc_en']);
$heroSubtitle = $weapon['desc_kr'];
include '../../includes/header.php';
include '../../includes/hero.php';
?>

<!-- Main Content -->
<main>
    <section class="detail-section">
        <div class="container">
            <div class="detail-container">
                <!-- Title Card -->
                <div class="detail-title-card">
                    <h1 class="detail-title"><?php echo htmlspecialchars(cleanItemName($weapon['desc_en'])); ?></h1>
                    <p class="detail-category"><?php echo formatWeaponType($weapon['type']); ?> - <?php echo $weapon['itemGrade']; ?> Grade</p>
                    <div class="detail-id">
                        <span>Item ID: <?php echo $weapon['item_id']; ?></span>
                    </div>
                </div>
                
                <div class="detail-layout">
                    <!-- Image Card -->
                    <div class="detail-image-card">
                        <h3 class="detail-stat-title">Image Preview</h3>
                        <div class="detail-image-container">
                            <img src="<?php echo $weaponsModel->getWeaponIconUrl($weapon['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($weapon['desc_en'])); ?>" class="detail-img">
                        </div>
                    </div>
                    
                    <!-- Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Stats</h3>
                        <div class="detail-stats">
                            <div class="detail-stat-group">
                                <h3 class="detail-stat-title">Basic Information</h3>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Type</span>
                                    <span class="detail-stat-value"><?php echo formatWeaponType($weapon['type']); ?></span>
                                </div>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Material</span>
                                    <span class="detail-stat-value"><?php echo formatMaterial($weapon['material']); ?></span>
                                </div>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Weight</span>
                                    <span class="detail-stat-value"><?php echo $weapon['weight']; ?></span>
                                </div>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Grade</span>
                                    <span class="detail-stat-value"><?php echo $weapon['itemGrade']; ?></span>
                                </div>
                            </div>
                            
                            <div class="detail-stat-group">
                                <h3 class="detail-stat-title">Combat Stats</h3>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Small Damage</span>
                                    <span class="detail-stat-value"><?php echo $weapon['dmg_small']; ?></span>
                                </div>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Large Damage</span>
                                    <span class="detail-stat-value"><?php echo $weapon['dmg_large']; ?></span>
                                </div>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Hit Modifier</span>
                                    <span class="detail-stat-value"><?php echo $weapon['hitmodifier']; ?></span>
                                </div>
                                
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Damage Modifier</span>
                                    <span class="detail-stat-value"><?php echo $weapon['dmgmodifier']; ?></span>
                                </div>
                                
                                <?php if (isset($weapon['double_dmg_chance']) && $weapon['double_dmg_chance'] > 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Double Damage Chance</span>
                                    <span class="detail-stat-value"><?php echo $weapon['double_dmg_chance']; ?>%</span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (isset($weapon['magicdmgmodifier']) && $weapon['magicdmgmodifier'] > 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Magic Damage Modifier</span>
                                    <span class="detail-stat-value"><?php echo $weapon['magicdmgmodifier']; ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="detail-stat-group">
                                <h3 class="detail-stat-title">Stats Bonus</h3>
                                
                                <?php if ($weapon['add_str'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">STR</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_str'] > 0 ? '+' . $weapon['add_str'] : $weapon['add_str']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_con'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">CON</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_con'] > 0 ? '+' . $weapon['add_con'] : $weapon['add_con']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_dex'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">DEX</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_dex'] > 0 ? '+' . $weapon['add_dex'] : $weapon['add_dex']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_int'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">INT</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_int'] > 0 ? '+' . $weapon['add_int'] : $weapon['add_int']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_wis'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">WIS</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_wis'] > 0 ? '+' . $weapon['add_wis'] : $weapon['add_wis']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_cha'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">CHA</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_cha'] > 0 ? '+' . $weapon['add_cha'] : $weapon['add_cha']; ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="detail-stat-group">
                                <h3 class="detail-stat-title">Additional Stats</h3>
                                
                                <?php if ($weapon['add_hp'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">HP</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_hp'] > 0 ? '+' . $weapon['add_hp'] : $weapon['add_hp']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_mp'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">MP</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_mp'] > 0 ? '+' . $weapon['add_mp'] : $weapon['add_mp']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_hpr'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">HP Regen</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_hpr'] > 0 ? '+' . $weapon['add_hpr'] : $weapon['add_hpr']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_mpr'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">MP Regen</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_mpr'] > 0 ? '+' . $weapon['add_mpr'] : $weapon['add_mpr']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($weapon['add_sp'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Spell Power</span>
                                    <span class="detail-stat-value"><?php echo $weapon['add_sp'] > 0 ? '+' . $weapon['add_sp'] : $weapon['add_sp']; ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (isset($weapon['m_def']) && $weapon['m_def'] != 0): ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label">Magic Defense</span>
                                    <span class="detail-stat-value"><?php echo $weapon['m_def']; ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Weapon Skills Section (if any) -->
                <?php if (!empty($weaponSkills)): ?>
                <div class="detail-skills">
                    <h3 class="detail-stat-title">Weapon Skills</h3>
                    
                    <?php foreach ($weaponSkills as $skill): ?>
                    <div class="detail-skill">
                        <div class="detail-skill-header">
                            <h4 class="detail-skill-name">
                                <?php 
                                if ($skill['skill_id'] > 0) {
                                    echo "Skill: " . $skill['skill_id'];
                                } else {
                                    echo "Weapon Effect";
                                }
                                ?>
                            </h4>
                            <span class="detail-skill-type"><?php echo $skill['attackType']; ?></span>
                        </div>
                        
                        <div class="detail-skill-stats">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Probability</span>
                                <span class="detail-stat-value"><?php echo $skill['probability']; ?>%</span>
                            </div>
                            
                            <?php if ($skill['fix_damage'] > 0 || $skill['random_damage'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Damage</span>
                                <span class="detail-stat-value">
                                    <?php 
                                    echo $skill['fix_damage'];
                                    if ($skill['random_damage'] > 0) {
                                        echo " + d" . $skill['random_damage'];
                                    }
                                    ?>
                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($skill['area'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Area</span>
                                <span class="detail-stat-value"><?php echo $skill['area']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($skill['skill_time'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Duration</span>
                                <span class="detail-stat-value"><?php echo $skill['skill_time']; ?> sec</span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($skill['attr']) && $skill['attr'] != 'NONE'): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Attribute</span>
                                <span class="detail-stat-value"><?php echo $skill['attr']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <!-- Class Restrictions - renamed to Can Use -->
                <div class="detail-classes-section">
                    <h3 class="detail-stat-title">Used By</h3>
                    
                    <div class="detail-classes">
                        <div class="detail-class <?php echo $weapon['use_royal'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Royal</span>
                            <span class="detail-class-status"><?php echo $weapon['use_royal'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_knight'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Knight</span>
                            <span class="detail-class-status"><?php echo $weapon['use_knight'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_mage'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Mage</span>
                            <span class="detail-class-status"><?php echo $weapon['use_mage'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_elf'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Elf</span>
                            <span class="detail-class-status"><?php echo $weapon['use_elf'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_darkelf'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Dark Elf</span>
                            <span class="detail-class-status"><?php echo $weapon['use_darkelf'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_dragonknight'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Dragon Knight</span>
                            <span class="detail-class-status"><?php echo $weapon['use_dragonknight'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_illusionist'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Illusionist</span>
                            <span class="detail-class-status"><?php echo $weapon['use_illusionist'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_warrior'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Warrior</span>
                            <span class="detail-class-status"><?php echo $weapon['use_warrior'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_fencer'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Fencer</span>
                            <span class="detail-class-status"><?php echo $weapon['use_fencer'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        
                        <div class="detail-class <?php echo $weapon['use_lancer'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name">Lancer</span>
                            <span class="detail-class-status"><?php echo $weapon['use_lancer'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Monsters Dropped By (placeholder) -->
                <div class="detail-drops-section">
                    <h3 class="detail-stat-title">Dropped By</h3>
                    <div class="detail-drops-content">
                        <p class="detail-placeholder-text">This information will be updated soon.</p>
                    </div>
                </div>
				
				<!-- Can be Crafted, only show if it can be crafted -->
				<div class="detail-drops-section">
                    <h3 class="detail-stat-title">Crafting</h3>
                    <div class="detail-drops-content">
                        <p class="detail-placeholder-text">This information will be updated soon. This section should only be shown if the item can be crafted.</p>
                    </div>
                </div>
                
                <!-- Description Section -->
                <?php if (!empty($weapon['note'])): ?>
                <div class="detail-description">
                    <h3 class="detail-description-title">Description</h3>
                    <div class="detail-description-content">
                        <?php echo nl2br(htmlspecialchars($weapon['note'])); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Back to list button -->
                <div class="detail-footer">
                    <a href="index.php" class="detail-back-button">&larr; Back to Weapons List</a>
                    
                    <?php if ($user->isAdmin()): ?>
                    <a href="../../admin/weapons/edit.php?id=<?php echo $weapon['item_id']; ?>" class="detail-edit-button">Edit Weapon</a>
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