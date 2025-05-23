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
            
            <!-- Monster Header -->
            <div class="monster-header">
                <div class="monster-image-container">
                    <?php if ($monster['spriteId']): ?>
                    <img src="../../assets/img/icons/ms<?php echo $monster['spriteId']; ?>.png" 
                         alt="<?php echo htmlspecialchars($monster['desc_en']); ?>" 
                         class="monster-image"
                         onerror="this.src='../../assets/img/placeholders/monster.png'">
                    <?php else: ?>
                    <img src="../../assets/img/placeholders/monster.png" alt="No image" class="monster-image">
                    <?php endif; ?>
                </div>
                
                <div class="monster-info">
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
                                <?php if ($related['spriteId']): ?>
                                <img src="../../assets/img/icons/ms<?php echo $related['spriteId']; ?>.png" 
                                     alt="<?php echo htmlspecialchars($related['desc_en']); ?>"
                                     onerror="this.src='../../assets/img/placeholders/monster.png'">
                                <?php else: ?>
                                <img src="../../assets/img/placeholders/monster.png" alt="No image">
                                <?php endif; ?>
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

<style>
/* Monster detail page styles */
.breadcrumb {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.6);
}

.breadcrumb a {
    color: var(--accent);
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.breadcrumb-separator {
    margin: 0 0.5rem;
}

.breadcrumb-current {
    color: white;
    font-weight: 500;
}

.monster-header {
    display: flex;
    gap: 2rem;
    margin-bottom: 3rem;
    padding: 2rem;
    background-color: var(--primary);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.monster-image-container {
    flex-shrink: 0;
}

.monster-image {
    width: 128px;
    height: 128px;
    object-fit: contain;
    image-rendering: pixelated;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
    background: rgba(255,255,255,0.8);
    border-radius: 8px;
    padding: 1rem;
}

.monster-info {
    flex: 1;
}

.monster-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem 0;
}

.monster-kr-title {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.7);
    font-style: italic;
    margin: 0 0 1rem 0;
}

.monster-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.monster-level-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 16px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Level-based color coding */
.level-0, .level-1 { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); }
.level-2, .level-3 { background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); }
.level-4, .level-5 { background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%); }
.level-6, .level-7 { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.level-8, .level-9 { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }

.monster-type-badge {
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.monster-type-badge.blackknight { background: linear-gradient(135deg, #1f2937 0%, #374151 100%); }
.monster-type-badge.doppelganger { background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); }
.monster-type-badge.boss { background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); }
.monster-type-badge.aggressive { background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); }
.monster-type-badge.peaceful { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
.monster-type-badge.undead { background: linear-gradient(135deg, #6b21a8 0%, #581c87 100%); }

.monster-quick-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 1rem;
}

.quick-stat {
    text-align: center;
    padding: 1rem;
    background-color: var(--secondary);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.quick-stat-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.6);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.quick-stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.monster-details {
    margin-bottom: 3rem;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
}

.detail-section {
    background-color: var(--primary);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 1.5rem;
}

.detail-section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--accent);
    margin: 0 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.detail-stats {
    display: grid;
    gap: 0.75rem;
}

.detail-stat {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.detail-stat-label {
    font-weight: 500;
    color: rgba(255, 255, 255, 0.7);
}

.detail-stat-value {
    font-weight: 600;
    color: white;
}

.related-section {
    margin-top: 3rem;
}

.related-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: white;
    margin-bottom: 1.5rem;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.related-card {
    background-color: var(--primary);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.related-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.related-link {
    display: block;
    text-decoration: none;
    color: inherit;
    padding: 1rem;
}

.related-image {
    text-align: center;
    margin-bottom: 0.75rem;
}

.related-image img {
    width: 48px;
    height: 48px;
    object-fit: contain;
    image-rendering: pixelated;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
}

.related-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
    margin: 0 0 0.25rem 0;
}

.related-level {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .monster-header {
        flex-direction: column;
        text-align: center;
    }
    
    .monster-image {
        width: 96px;
        height: 96px;
        margin: 0 auto;
    }
    
    .monster-title {
        font-size: 1.75rem;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .monster-quick-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .related-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .monster-quick-stats {
        grid-template-columns: 1fr;
    }
    
    .related-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include '../../includes/footer.php'; ?> 