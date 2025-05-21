<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Weapon.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize weapons model
$weaponsModel = new Weapon();

// Initialize database for global functions
$db = Database::getInstance();

// Get weapon ID from URL
$weaponId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get weapon details
$weapon = $weaponsModel->getWeaponById($weaponId);

// If weapon not found, redirect to list page
if (!$weapon) {
    header('Location: index.php');
    exit;
}

// Get full weapon stats
$weaponAllStats = $weaponsModel->getWeaponAllStats($weaponId);

// Get weapon skills
$weaponSkills = $weaponsModel->getWeaponSkills($weaponId);

// Get additional damage info
$weaponDamage = $weaponsModel->getWeaponDamage($weaponId);

// Set page title
$pageTitle = cleanItemName($weapon['desc_en']) . ' - Weapon Details';

// Include header
$heroTitle = cleanItemName($weapon['desc_en']);
$heroSubtitle = $weapon['type'];
include '../../includes/header.php';
include '../../includes/hero.php';
?>

<!-- Main Content -->
<main>
    <section class="detail-section">
        <div class="container">
				<?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
				<div class="admin-alert admin-alert-success">
					Weapon has been updated successfully.
				</div>
				<?php endif; ?>

				<?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
				<div class="admin-alert admin-alert-success">
					New weapon has been created successfully.
				</div>
				<?php endif; ?>
            <div class="detail-container">
                <!-- Title Card -->
                <div class="detail-title-card">
                    <h1 class="detail-title"><?php echo htmlspecialchars(cleanItemName($weapon['desc_en'])); ?></h1>
                    <p class="detail-category"><?php echo formatWeaponType($weapon['type']); ?> - <?php echo formatArmorGrade($weapon['itemGrade']); ?> Grade</p>
                    <div class="detail-id">
                        <span>Item ID: <?php echo $weapon['item_id']; ?></span>
                    </div>
                </div>
                
                <!-- First Row: Image and Basic Info -->
                <div class="detail-layout">
                    <!-- Image Card -->
                    <div class="detail-image-card">
                        <h3 class="detail-stat-title">Image Preview</h3>
                        <div class="detail-image-container">
                            <img src="<?php echo getItemIconUrl($weapon['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($weapon['desc_en'])); ?>" class="detail-img">
                        </div>
                    </div>
                    
                    <!-- Basic Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Basic</h3>
                        <div class="detail-stats single-column">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Name</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars(cleanItemName($weapon['desc_en'])); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Korean</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars(cleanItemName($weapon['desc_kr'])); ?></span>
                            </div>
                            
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
                                <span class="detail-stat-value"><?php echo formatArmorGrade($weapon['itemGrade']); ?></span>
                            </div>
                            
                            <?php if (isset($weapon['safenchant']) && $weapon['safenchant'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Safe Enchant</span>
                                <span class="detail-stat-value">+<?php echo $weapon['safenchant']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($weapon['min_lvl']) && $weapon['min_lvl'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Min Level</span>
                                <span class="detail-stat-value"><?php echo $weapon['min_lvl']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($weapon['max_lvl']) && $weapon['max_lvl'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Max Level</span>
                                <span class="detail-stat-value"><?php echo $weapon['max_lvl']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($weapon['bless']) && $weapon['bless'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Blessed</span>
                                <span class="detail-stat-value"><?php echo $weapon['bless'] == 1 ? 'Yes' : 'No'; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Second Row: Three Stat Cards -->
                <div class="detail-three-column-layout">
                    <!-- Combat Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Combat Stats</h3>
                        <div class="detail-stats single-column">
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
                                <span class="detail-stat-value"><?php echo formatStatBonus($weapon['hitmodifier']); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Damage Modifier</span>
                                <span class="detail-stat-value"><?php echo formatStatBonus($weapon['dmgmodifier']); ?></span>
                            </div>
                            
                            <?php if (isset($weaponDamage['addDamege']) && $weaponDamage['addDamege'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Additional Damage</span>
                                <span class="detail-stat-value">+<?php echo $weaponDamage['addDamege']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($weapon['double_dmg_chance']) && $weapon['double_dmg_chance'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Double Damage Chance</span>
                                <span class="detail-stat-value"><?php echo formatPercentage($weapon['double_dmg_chance'], 0); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($weapon['magicdmgmodifier']) && $weapon['magicdmgmodifier'] != 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Magic Damage Modifier</span>
                                <span class="detail-stat-value"><?php echo formatStatBonus($weapon['magicdmgmodifier']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($weapon['canbedmg']) && $weapon['canbedmg'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Can Be Damaged</span>
                                <span class="detail-stat-value"><?php echo $weapon['canbedmg'] == 1 ? 'Yes' : 'No'; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Stats Bonus Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Stats Bonus</h3>
                        <div class="detail-stats single-column">
                            <?php if (hasStatBonuses($weapon)): ?>
                                <?php 
                                $statBonuses = ['add_str' => 'STR', 'add_con' => 'CON', 'add_dex' => 'DEX', 'add_int' => 'INT', 'add_wis' => 'WIS', 'add_cha' => 'CHA'];
                                foreach ($statBonuses as $statField => $statName): 
                                    if (isset($weapon[$statField]) && $weapon[$statField] != 0):
                                ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label"><?php echo $statName; ?></span>
                                    <span class="detail-stat-value"><?php echo formatStatBonus($weapon[$statField]); ?></span>
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
                            $additionalStats = ['add_hp' => 'HP', 'add_mp' => 'MP', 'add_hpr' => 'HP Regen', 'add_mpr' => 'MP Regen', 'add_sp' => 'Spell Power', 'm_def' => 'Magic Defense'];
                            foreach ($additionalStats as $statField => $statLabel) {
                                if (isset($weapon[$statField]) && $weapon[$statField] != 0) {
                                    $hasAdditionalStats = true;
                                    ?>
                                    <div class="detail-stat">
                                        <span class="detail-stat-label"><?php echo $statLabel; ?></span>
                                        <span class="detail-stat-value"><?php echo formatStatBonus($weapon[$statField]); ?></span>
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
                
                <!-- Third Row: Criticals and Resistances -->
                <div class="detail-layout">
                    <!-- Critical Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Critical & Combat Bonuses</h3>
                        <div class="detail-stats single-column">
                            <?php
                            $hasCriticals = false;
                            $criticalFields = [
                                'shortCritical' => 'Melee Critical',
                                'longCritical' => 'Ranged Critical',
                                'magicCritical' => 'Magic Critical',
                                'haste_item' => 'Haste',
                                'damage_reduction' => 'Damage Reduction',
                                'MagicDamageReduction' => 'Magic Damage Reduction',
                                'attackSpeedDelayRate' => 'Attack Speed',
                                'moveSpeedDelayRate' => 'Move Speed'
                            ];
                            
                            foreach ($criticalFields as $field => $label) {
                                if (isset($weapon[$field]) && $weapon[$field] != 0) {
                                    $hasCriticals = true;
                                    $value = $weapon[$field];
                                    
                                    // Special formatting for some fields
                                    if ($field == 'attackSpeedDelayRate' || $field == 'moveSpeedDelayRate') {
                                        $value = formatPercentage($value, 0);
                                    } elseif ($field == 'haste_item') {
                                        $value = $value == 1 ? 'Yes' : 'No';
                                    } else {
                                        $value = formatPercentage($value, 0);
                                    }
                                    ?>
                                    <div class="detail-stat">
                                        <span class="detail-stat-label"><?php echo $label; ?></span>
                                        <span class="detail-stat-value"><?php echo $value; ?></span>
                                    </div>
                                    <?php
                                }
                            }
                            
                            if (!$hasCriticals): 
                            ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">No Critical Bonuses</span>
                                <span class="detail-stat-value">—</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Resistances Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Resistances & Special</h3>
                        <div class="detail-stats single-column">
                            <?php if (hasResistances($weapon)): ?>
                                <?php
                                $resistanceFields = ['regist_skill', 'regist_spirit', 'regist_dragon', 'regist_fear', 'regist_all', 'hitup_skill', 'hitup_spirit', 'hitup_dragon', 'hitup_fear', 'hitup_all', 'hitup_magic'];
                                
                                foreach ($resistanceFields as $field) {
                                    if (isset($weapon[$field]) && $weapon[$field] != 0) {
                                        ?>
                                        <div class="detail-stat">
                                            <span class="detail-stat-label"><?php echo formatResistanceName($field); ?></span>
                                            <span class="detail-stat-value"><?php echo formatPercentage($weapon[$field], 0); ?></span>
                                        </div>
                                        <?php
                                    }
                                }
                                
                                // Special field for poison resistance
                                if (isset($weapon['poisonRegist']) && $weapon['poisonRegist'] == 'true') {
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
                </div>
                
                <!-- Item Properties -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Item Properties</h3>
                    <div class="detail-properties">
                        <div class="detail-property-grid">
                            <div class="detail-property <?php echo isset($weapon['haste_item']) && $weapon['haste_item'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['haste_item']) && $weapon['haste_item'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Haste</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($weapon['canbedmg']) && $weapon['canbedmg'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['canbedmg']) && $weapon['canbedmg'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Damageable</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($weapon['bless']) && $weapon['bless'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['bless']) && $weapon['bless'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Blessed</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($weapon['trade']) && $weapon['trade'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['trade']) && $weapon['trade'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Trade</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($weapon['retrieve']) && $weapon['retrieve'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['retrieve']) && $weapon['retrieve'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Store</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($weapon['specialretrieve']) && $weapon['specialretrieve'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['specialretrieve']) && $weapon['specialretrieve'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Store Special</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($weapon['cant_delete']) && $weapon['cant_delete'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['cant_delete']) && $weapon['cant_delete'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Delete</span>
                            </div>
                            
                            <div class="detail-property <?php echo isset($weapon['cant_sell']) && $weapon['cant_sell'] > 0 ? 'property-active' : ''; ?>">
                                <span class="property-checkbox"><i class="fas <?php echo isset($weapon['cant_sell']) && $weapon['cant_sell'] > 0 ? 'fa-check-square' : 'fa-square'; ?>"></i></span>
                                <span class="property-name">Can Not Sell</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if (isset($weapon['PVPDamage']) || isset($weapon['PVPDamageReduction'])): ?>
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
                            if (isset($weapon[$field]) && $weapon[$field] != 0) {
                                ?>
                                <div class="detail-stat">
                                    <span class="detail-stat-label"><?php echo $label; ?></span>
                                    <span class="detail-stat-value"><?php echo $weapon[$field]; ?><?php echo strpos($field, 'Percent') !== false ? '%' : ''; ?></span>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
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
                                    echo !empty($skill['note']) ? htmlspecialchars($skill['note']) : "Weapon Effect";
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
                            
                            <?php if (isset($skill['int_damage']) && $skill['int_damage'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Int-based Damage</span>
                                <span class="detail-stat-value"><?php echo $skill['int_damage']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($skill['spell_damage']) && $skill['spell_damage'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Spell Damage</span>
                                <span class="detail-stat-value"><?php echo $skill['spell_damage']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($skill['hpStill']) && $skill['hpStill'] == 'true'): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">HP Steal</span>
                                <span class="detail-stat-value"><?php echo $skill['hpStill_probabliity']; ?>% (<?php echo $skill['hpStillValue']; ?>)</span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (isset($skill['mpStill']) && $skill['mpStill'] == 'true'): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">MP Steal</span>
                                <span class="detail-stat-value"><?php echo $skill['mpStill_probabliity']; ?>% (<?php echo $skill['mpStillValue']; ?>)</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <!-- Experience Bonus Section -->
                <?php if (isset($weapon['expBonus']) && $weapon['expBonus'] > 0): ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Experience Bonus</h3>
                    <div class="detail-stats single-column">
                        <div class="detail-stat">
                            <span class="detail-stat-label">EXP Bonus</span>
                            <span class="detail-stat-value">+<?php echo $weapon['expBonus']; ?>%</span>
                        </div>
                        <?php if (isset($weapon['rest_exp_reduce_efficiency']) && $weapon['rest_exp_reduce_efficiency'] > 0): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Rest EXP Reduction</span>
                            <span class="detail-stat-value"><?php echo $weapon['rest_exp_reduce_efficiency']; ?>%</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Class Restrictions -->
                <div class="detail-classes-section">
                    <h3 class="detail-stat-title">Used By</h3>
                    <div class="detail-classes">
                        <?php 
                        $classRestrictions = getClassRestrictions($weapon);
                        foreach ($classRestrictions as $classKey => $classData): 
                        ?>
                        <div class="detail-class <?php echo $classData['can_use'] ? 'can-use' : 'cannot-use'; ?>">
                            <span class="detail-class-name"><?php echo $classData['name']; ?></span>
                            <span class="detail-class-status"><?php echo $classData['can_use'] ? 'Can' : 'Can Not'; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Monsters Dropped By -->
                <div class="detail-drops-section">
					<h3 class="detail-stat-title">Dropped By</h3>
					<?php
					$drops = getItemDrops($weaponId, $db);
					
					if (empty($drops)):
					?>
					<div class="detail-drops-content">
						<p class="detail-placeholder-text">This weapon is not dropped by any monsters.</p>
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
                
                <!-- Magic Name Section -->
                <?php if (isset($weapon['Magic_name']) && !empty($weapon['Magic_name'])): ?>
                <div class="detail-description">
                    <h3 class="detail-description-title">Magic Effect</h3>
                    <div class="detail-description-content">
                        <?php echo htmlspecialchars($weapon['Magic_name']); ?>
                    </div>
                </div>
                <?php endif; ?>
                
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