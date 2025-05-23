<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Map.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize map model
$mapModel = new Map();

// Initialize database for global functions
$db = Database::getInstance();

// Get map ID from URL
$mapId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get map details
$map = $mapModel->getMapById($mapId);

// If map not found, redirect to list page
if (!$map) {
    header('Location: index.php');
    exit;
}

// Get map type from the map_type table
$mapTypeQuery = "SELECT type FROM map_type WHERE mapId = ?";
$mapTypeResult = $db->fetchAll($mapTypeQuery, [$mapId]);
$mapType = $mapTypeResult[0]['type'] ?? 'NORMAL';

// Set page title
$pageTitle = ($map['locationname'] ?? "Map #$mapId") . ' - Map Details';

// Include header
$heroTitle = $map['locationname'] ?? "Map #$mapId";
$heroSubtitle = formatMapType($mapType);
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
                    <h1 class="detail-title"><?php echo htmlspecialchars($map['locationname'] ?? "Map #$mapId"); ?></h1>
                    <p class="detail-category"><?php echo formatMapType($mapType); ?></p>
                    <div class="detail-id">
                        <span>Map ID: <?php echo $map['mapid']; ?></span>
                    </div>
                </div>
                
                <!-- First Row: Image and Basic Info -->
                <div class="detail-layout">
                    <!-- Image Card -->
                    <div class="detail-image-card">
                        <h3 class="detail-stat-title">Map Preview</h3>
                        <div class="detail-image-container">
                            <img src="<?php echo getMapIconUrl($map['pngId']); ?>" alt="<?php echo htmlspecialchars($map['locationname'] ?? "Map #$mapId"); ?>" class="detail-img">
                        </div>
                    </div>
                    
                    <!-- Basic Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">Basic Information</h3>
                        <div class="detail-stats single-column">
                            <div class="detail-stat">
                                <span class="detail-stat-label">Map ID</span>
                                <span class="detail-stat-value"><?php echo $map['mapid']; ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Name</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($map['locationname'] ?? 'N/A'); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Korean</span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($map['desc_kr'] ?? 'N/A'); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Map Type</span>
                                <span class="detail-stat-value"><?php echo formatMapType($mapType); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Dungeon</span>
                                <span class="detail-stat-value"><?php echo formatYesNo($map['dungeon']); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">Underwater</span>
                                <span class="detail-stat-value"><?php echo formatYesNo($map['underwater']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Map Properties Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Map Properties</h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">X Range</span>
                            <span class="detail-stat-value"><?php echo $map['startX'] . ' - ' . $map['endX']; ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Y Range</span>
                            <span class="detail-stat-value"><?php echo $map['startY'] . ' - ' . $map['endY']; ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Monster Amount</span>
                            <span class="detail-stat-value"><?php echo number_format($map['monster_amount'], 2); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Drop Rate</span>
                            <span class="detail-stat-value"><?php echo number_format($map['drop_rate'], 2); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Map Features Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Map Features</h3>
                    <div class="detail-properties">
                        <div class="detail-property-grid">
                            <div class="detail-property <?php echo $map['markable'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['markable'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Markable</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['teleportable'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['teleportable'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Teleportable</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['escapable'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['escapable'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Escapable</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['resurrection'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['resurrection'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Resurrection</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['painwand'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['painwand'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Pain Wand</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['penalty'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['penalty'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Penalty</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['take_pets'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['take_pets'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Take Pets</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['recall_pets'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['recall_pets'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Recall Pets</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['usable_item'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['usable_item'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Usable Items</div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['usable_skill'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['usable_skill'] ? 'fa-check-square' : 'fa-square'; ?>"></i>
                                </div>
                                <div class="property-name">Usable Skills</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Combat Stats Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Combat Properties</h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">Player to NPC Damage Modifier</span>
                            <span class="detail-stat-value"><?php echo $map['dmgModiPc2Npc']; ?>%</span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">NPC to Player Damage Modifier</span>
                            <span class="detail-stat-value"><?php echo $map['dmgModiNpc2Pc']; ?>%</span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Decrease HP</span>
                            <span class="detail-stat-value"><?php echo formatYesNo($map['decreaseHp']); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Special Zones Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Special Zone Properties</h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">Beginner Zone</span>
                            <span class="detail-stat-value"><?php echo formatYesNo($map['beginZone']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Red Knight Zone</span>
                            <span class="detail-stat-value"><?php echo formatYesNo($map['redKnightZone']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Ruun Castle Zone</span>
                            <span class="detail-stat-value"><?php echo formatYesNo($map['ruunCastleZone']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Inter War Zone</span>
                            <span class="detail-stat-value"><?php echo formatYesNo($map['interWarZone']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Gerad Buff Zone</span>
                            <span class="detail-stat-value"><?php echo formatYesNo($map['geradBuffZone']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Grow Buff Zone</span>
                            <span class="detail-stat-value"><?php echo formatYesNo($map['growBuffZone']); ?></span>
                        </div>
                        
                        <?php if (!empty($map['script'])): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">Script</span>
                            <span class="detail-stat-value"><?php echo htmlspecialchars($map['script']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Clone Information (if applicable) -->
                <?php if ($map['cloneStart'] > 0 || $map['cloneEnd'] > 0): ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">Instance Information</h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">Clone Start ID</span>
                            <span class="detail-stat-value"><?php echo $map['cloneStart']; ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">Clone End ID</span>
                            <span class="detail-stat-value"><?php echo $map['cloneEnd']; ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Back to list button -->
                <div class="detail-actions">
                    <a href="index.php" class="detail-button detail-button-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Maps List
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Include footer
include '../../includes/footer.php';
?> 