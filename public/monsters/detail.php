<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Monster.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize monsters model
$monstersModel = new Monster();

// Get monster ID from URL
$monsterId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($monsterId <= 0) {
    header('Location: index.php');
    exit;
}

// Get monster data
$monster = $monstersModel->getMonsterById($monsterId);
if (!$monster) {
    header('Location: index.php');
    exit;
}

// Get related monsters (same family)
$relatedMonsters = [];
if (!empty($monster['family'])) {
    $relatedFilters = ['family' => $monster['family']];
    $relatedResult = $monstersModel->filterMonsters($relatedFilters, 1, 6);
    $relatedMonsters = array_filter($relatedResult['data'], function($m) use ($monsterId) {
        return $m['npcid'] != $monsterId;
    });
    $relatedMonsters = array_slice($relatedMonsters, 0, 5);
}

// Include header
$heroTitle = htmlspecialchars($monster['desc_en']);
$heroSubtitle = !empty($monster['desc_kr']) ? htmlspecialchars($monster['desc_kr']) : "Monster Details";
include '../../includes/header.php';
include '../../includes/hero.php';
echo '<link rel="stylesheet" href="../../assets/css/monsters.css">';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="../../index.php">Home</a>
                <span class="breadcrumb-separator">/</span>
                <a href="index.php">Monsters</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current"><?php echo htmlspecialchars($monster['desc_en']); ?></span>
            </nav>
            
            <!-- Monster Header - Split into two cards -->
            <div class="monster-header-cards">
                <!-- Image Card -->
                <div class="monster-image-card">
                    <img src="<?php echo getMonsterSpriteUrl($monster['spriteId']); ?>" 
                         alt="<?php echo htmlspecialchars($monster['desc_en']); ?>" 
                         class="monster-image-large">
                </div>
                
                <!-- Basic Info Card -->
                <div class="monster-basic-info-card">
                    <div class="monster-title-section">
                        <h1 class="monster-title"><?php echo htmlspecialchars($monster['desc_en']); ?></h1>
                        <?php if (!empty($monster['desc_kr'])): ?>
                        <p class="monster-kr-title"><?php echo htmlspecialchars($monster['desc_kr']); ?></p>
                        <?php endif; ?>
                        
                        <div class="monster-badges">
                            <span class="monster-level-badge level-<?php echo min(floor($monster['lvl'] / 10), 9); ?>">
                                Level <?php echo $monster['lvl']; ?>
                            </span>
                            
                            <?php if ($monster['impl'] === 'L1BlackKnight'): ?>
                            <span class="monster-type-badge blackknight">Black Knight</span>
                            <?php elseif ($monster['impl'] === 'L1Doppelganger'): ?>
                            <span class="monster-type-badge doppelganger">Doppelganger</span>
                            <?php endif; ?>
                            
                            <?php if (isset($monster['is_bossmonster']) && $monster['is_bossmonster'] === 'true'): ?>
                            <span class="monster-type-badge boss">Boss Monster</span>
                            <?php endif; ?>
                            
                            <?php if ($monster['is_agro'] === 'true'): ?>
                            <span class="monster-type-badge aggressive">Aggressive</span>
                            <?php else: ?>
                            <span class="monster-type-badge peaceful">Peaceful</span>
                            <?php endif; ?>
                            
                            <?php if ($monster['undead'] !== 'NONE'): ?>
                            <span class="monster-type-badge undead"><?php echo htmlspecialchars($monster['undead']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="monster-quick-stats">
                        <div class="quick-stat">
                            <span class="quick-stat-label">HP</span>
                            <span class="quick-stat-value"><?php echo number_format($monster['hp']); ?></span>
                        </div>
                        <div class="quick-stat">
                            <span class="quick-stat-label">MP</span>
                            <span class="quick-stat-value"><?php echo number_format($monster['mp']); ?></span>
                        </div>
                        <div class="quick-stat">
                            <span class="quick-stat-label">EXP</span>
                            <span class="quick-stat-value"><?php echo number_format($monster['exp']); ?></span>
                        </div>
                        <div class="quick-stat">
                            <span class="quick-stat-label">AC</span>
                            <span class="quick-stat-value"><?php echo $monster['ac']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Monster Details -->
            <div class="monster-details">
                <div class="details-grid">
                    <!-- Basic Information -->
                    <div class="detail-section">
                        <h3 class="detail-section-title">Basic Information</h3>
                        <div class="detail-stats">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Monster ID:</span>
                                <span class="detail-stat-value"><?php echo $monster['npcid']; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Class ID:</span>
                                <span class="detail-stat-value"><?php echo $monster['classId']; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Sprite ID:</span>
                                <span class="detail-stat-value"><?php echo $monster['spriteId']; ?></span>
                            </div>
                            <?php if (!empty($monster['family'])): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Family:</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($monster['family']); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Implementation:</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($monster['impl']); ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Size:</span>
                                <span class="detail-stat-value"><?php echo $monster['big'] === 'true' ? 'Large' : 'Normal'; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Combat Stats -->
                    <div class="detail-section">
                        <h3 class="detail-section-title">Combat Stats</h3>
                        <div class="detail-stats">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Health Points:</span>
                                <span class="detail-stat-value"><?php echo number_format($monster['hp']); ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Magic Points:</span>
                                <span class="detail-stat-value"><?php echo number_format($monster['mp']); ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Armor Class:</span>
                                <span class="detail-stat-value"><?php echo $monster['ac']; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Magic Resistance:</span>
                                <span class="detail-stat-value"><?php echo $monster['mr']; ?>%</span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Experience Points:</span>
                                <span class="detail-stat-value"><?php echo number_format($monster['exp']); ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Alignment:</span>
                                <span class="detail-stat-value"><?php echo number_format($monster['alignment']); ?></span>
                            </div>
                            <?php if ($monster['damage_reduction'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Damage Reduction:</span>
                                <span class="detail-stat-value"><?php echo $monster['damage_reduction']; ?>%</span>
                            </div>
                            <?php endif; ?>
                            <?php if ($monster['ranged'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Range:</span>
                                <span class="detail-stat-value"><?php echo $monster['ranged']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Attributes -->
                    <div class="detail-section">
                        <h3 class="detail-section-title">Attributes</h3>
                        <div class="detail-stats">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Strength:</span>
                                <span class="detail-stat-value"><?php echo $monster['str']; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Constitution:</span>
                                <span class="detail-stat-value"><?php echo $monster['con']; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Dexterity:</span>
                                <span class="detail-stat-value"><?php echo $monster['dex']; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Wisdom:</span>
                                <span class="detail-stat-value"><?php echo $monster['wis']; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Intelligence:</span>
                                <span class="detail-stat-value"><?php echo $monster['intel']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Special Properties -->
                    <div class="detail-section">
                        <h3 class="detail-section-title">Special Properties</h3>
                        <div class="detail-stats">
                            <?php if ($monster['weakAttr'] !== 'NONE'): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Weak to:</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($monster['weakAttr']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($monster['poison_atk'] !== 'NONE'): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Poison Attack:</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($monster['poison_atk']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Tameable:</span>
                                <span class="detail-stat-value"><?php echo $monster['is_taming'] === 'true' ? 'Yes' : 'No'; ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Can Teleport:</span>
                                <span class="detail-stat-value"><?php echo $monster['is_teleport'] === 'true' ? 'Yes' : 'No'; ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Turn Undead:</span>
                                <span class="detail-stat-value"><?php echo $monster['can_turnundead'] === 'true' ? 'Affected' : 'Not Affected'; ?></span>
                            </div>
                            
                            <?php if ($monster['hpr'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">HP Regeneration:</span>
                                <span class="detail-stat-value"><?php echo $monster['hpr']; ?> every <?php echo number_format($monster['hprinterval'] / 1000); ?>s</span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($monster['mpr'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">MP Regeneration:</span>
                                <span class="detail-stat-value"><?php echo $monster['mpr']; ?> every <?php echo number_format($monster['mprinterval'] / 1000); ?>s</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Speed & Movement -->
                    <div class="detail-section">
                        <h3 class="detail-section-title">Speed & Movement</h3>
                        <div class="detail-stats">
                            <?php if ($monster['passispeed'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Movement Speed:</span>
                                <span class="detail-stat-value"><?php echo $monster['passispeed']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($monster['atkspeed'] > 0): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Attack Speed:</span>
                                <span class="detail-stat-value"><?php echo $monster['atkspeed']; ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Brave Speed:</span>
                                <span class="detail-stat-value"><?php echo $monster['is_bravespeed'] === 'true' ? 'Yes' : 'No'; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Aggression -->
                    <div class="detail-section">
                        <h3 class="detail-section-title">Aggression Behavior</h3>
                        <div class="detail-stats">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Aggressive:</span>
                                <span class="detail-stat-value"><?php echo $monster['is_agro'] === 'true' ? 'Yes' : 'No'; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Attacks Poly:</span>
                                <span class="detail-stat-value"><?php echo $monster['is_agro_poly'] === 'true' ? 'Yes' : 'No'; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Attacks Invisible:</span>
                                <span class="detail-stat-value"><?php echo $monster['is_agro_invis'] === 'true' ? 'Yes' : 'No'; ?></span>
                            </div>
                            <div class="detail-stat">
                                <span class="detail-stat-label">Picks Up Items:</span>
                                <span class="detail-stat-value"><?php echo $monster['is_picupitem'] === 'true' ? 'Yes' : 'No'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Monsters -->
            <?php if (!empty($relatedMonsters)): ?>
            <div class="related-section">
                <h3 class="related-title">Related Monsters</h3>
                <div class="related-grid">
                    <?php foreach ($relatedMonsters as $related): ?>
                    <div class="related-card">
                        <a href="detail.php?id=<?php echo $related['npcid']; ?>" class="related-link">
                            <div class="related-image">
                                <img src="<?php echo getMonsterSpriteUrl($related['spriteId']); ?>" 
                                     alt="<?php echo htmlspecialchars($related['desc_en']); ?>">
                            </div>
                            <div class="related-info">
                                <h4 class="related-name"><?php echo htmlspecialchars($related['desc_en']); ?></h4>
                                <p class="related-level">Level <?php echo $related['lvl']; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>