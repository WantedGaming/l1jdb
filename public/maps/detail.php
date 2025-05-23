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

// Determine map type based on existing fields
if ($map['dungeon'] == 1) {
    $mapType = 'DUNGEON';
} elseif ($map['underwater'] == 1) {
    $mapType = 'UNDERWATER';
} elseif ($map['beginZone'] || $map['redKnightZone'] || $map['ruunCastleZone']) {
    $mapType = 'SPECIAL';
} else {
    $mapType = 'FIELD';
}

// Set page title
$pageTitle = ($map['locationname'] ?? "Map #$mapId") . ' - Map Details';

// Include header
$heroTitle = $map['locationname'] ?? "Map #$mapId";
$heroSubtitle = formatMapType($mapType) . ' • Map ID: ' . $map['mapid'];
include '../../includes/header.php';
include '../../includes/hero.php';
?>

<!-- Main Content -->
<main>
    <section class="detail-section">
        <div class="container">
            <div class="detail-container">
                
                <!-- Breadcrumb Navigation -->
                <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../../index.php"><i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="index.php"><i class="fas fa-map"></i> Maps</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo htmlspecialchars($map['locationname'] ?? "Map #$mapId"); ?>
                        </li>
                    </ol>
                </nav>
                
                <!-- Title Card -->
                <div class="detail-title-card">
                    <div class="detail-title-content">
                        <h1 class="detail-title">
                            <?php echo htmlspecialchars($map['locationname'] ?? "Map #$mapId"); ?>
                        </h1>
                        <div class="detail-badges">
                            <span class="detail-category"><?php echo formatMapType($mapType); ?></span>
                            <span class="detail-badge <?php echo $map['dungeon'] ? 'badge-dungeon' : 'badge-field'; ?>">
                                <i class="fas <?php echo $map['dungeon'] ? 'fa-dungeon' : 'fa-map'; ?>"></i>
                                <?php echo $map['dungeon'] ? 'Dungeon' : 'Field'; ?>
                            </span>
                            <?php if ($map['underwater']): ?>
                            <span class="detail-badge badge-underwater">
                                <i class="fas fa-water"></i> Underwater
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="detail-id">
                            <i class="fas fa-hashtag"></i> Map ID: <?php echo $map['mapid']; ?>
                            <?php if (!empty($map['desc_kr'])): ?>
                            <span class="detail-korean">• <?php echo htmlspecialchars($map['desc_kr']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- First Row: Image and Basic Info -->
                <div class="detail-layout">
                    <!-- Image Card -->
                    <div class="detail-image-card">
                        <h3 class="detail-stat-title">
                            <i class="fas fa-image"></i> Map Preview
                        </h3>
                        <div class="detail-image-container">
                            <img src="<?php echo getMapIconUrl($map['pngId']); ?>" 
                                 alt="<?php echo htmlspecialchars($map['locationname'] ?? "Map #$mapId"); ?>" 
                                 class="detail-img">
                        </div>
                        <div class="image-info">
                            <small class="image-id">PNG ID: <?php echo $map['pngId']; ?></small>
                        </div>
                    </div>
                    
                    <!-- Basic Stats Card -->
                    <div class="detail-stats-card">
                        <h3 class="detail-stat-title">
                            <i class="fas fa-info-circle"></i> Basic Information
                        </h3>
                        <div class="detail-stats single-column">
                            <div class="detail-stat">
                                <span class="detail-stat-label">
                                    <i class="fas fa-hashtag"></i> Map ID
                                </span>
                                <span class="detail-stat-value"><?php echo $map['mapid']; ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">
                                    <i class="fas fa-map-marker-alt"></i> Location Name
                                </span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($map['locationname'] ?? 'N/A'); ?></span>
                            </div>
                            
                            <?php if (!empty($map['desc_kr'])): ?>
                            <div class="detail-stat">
                                <span class="detail-stat-label">
                                    <i class="fas fa-language"></i> Korean Name
                                </span>
                                <span class="detail-stat-value"><?php echo htmlspecialchars($map['desc_kr']); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">
                                    <i class="fas fa-layer-group"></i> Map Type
                                </span>
                                <span class="detail-stat-value"><?php echo formatMapType($mapType); ?></span>
                            </div>
                            
                            <div class="detail-stat">
                                <span class="detail-stat-label">
                                    <i class="fas <?php echo $map['dungeon'] ? 'fa-dungeon' : 'fa-map'; ?>"></i> Environment
                                </span>
                                <span class="detail-stat-value">
                                    <?php echo $map['dungeon'] ? 'Dungeon' : 'Field'; ?>
                                    <?php if ($map['underwater']): ?>
                                    <span class="detail-sub-value">
                                        <i class="fas fa-water"></i> Underwater
                                    </span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Map Properties Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">
                        <i class="fas fa-cog"></i> Map Properties
                    </h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-arrows-alt-h"></i> X Range
                            </span>
                            <span class="detail-stat-value"><?php echo number_format($map['startX']) . ' → ' . number_format($map['endX']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-arrows-alt-v"></i> Y Range
                            </span>
                            <span class="detail-stat-value"><?php echo number_format($map['startY']) . ' → ' . number_format($map['endY']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-dragon"></i> Monster Amount
                            </span>
                            <span class="detail-stat-value"><?php echo number_format($map['monster_amount'], 2); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-gift"></i> Drop Rate
                            </span>
                            <span class="detail-stat-value"><?php echo number_format($map['drop_rate'], 2); ?>%</span>
                        </div>
                    </div>
                </div>
                
                <!-- Map Features Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">
                        <i class="fas fa-tools"></i> Map Features & Abilities
                    </h3>
                    <div class="detail-properties">
                        <div class="detail-property-grid">
                            <div class="detail-property <?php echo $map['markable'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['markable'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Bookmarkable</div>
                                    <div class="property-desc">Can save location bookmarks</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['teleportable'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['teleportable'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Teleportable</div>
                                    <div class="property-desc">Can use teleport magic</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['escapable'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['escapable'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Escapable</div>
                                    <div class="property-desc">Can use escape scrolls</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['resurrection'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['resurrection'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Resurrection</div>
                                    <div class="property-desc">Can resurrect fallen players</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['painwand'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['painwand'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Pain Wand</div>
                                    <div class="property-desc">Pain wand effects active</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['penalty'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['penalty'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Death Penalty</div>
                                    <div class="property-desc">Death penalties apply</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['take_pets'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['take_pets'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Take Pets</div>
                                    <div class="property-desc">Can bring pets along</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['recall_pets'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['recall_pets'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Recall Pets</div>
                                    <div class="property-desc">Can recall pets</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['usable_item'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['usable_item'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Usable Items</div>
                                    <div class="property-desc">Can use consumable items</div>
                                </div>
                            </div>
                            
                            <div class="detail-property <?php echo $map['usable_skill'] ? 'property-active' : ''; ?>">
                                <div class="property-checkbox">
                                    <i class="fas <?php echo $map['usable_skill'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                </div>
                                <div class="property-info">
                                    <div class="property-name">Usable Skills</div>
                                    <div class="property-desc">Can use character skills</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Combat Stats Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">
                        <i class="fas fa-sword"></i> Combat Properties
                    </h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-user-plus"></i> Player → NPC Damage
                            </span>
                            <span class="detail-stat-value damage-modifier <?php echo $map['dmgModiPc2Npc'] > 100 ? 'positive' : ($map['dmgModiPc2Npc'] < 100 ? 'negative' : ''); ?>">
                                <?php echo $map['dmgModiPc2Npc']; ?>%
                                <?php if ($map['dmgModiPc2Npc'] != 100): ?>
                                <span class="modifier-change">
                                    (<?php echo $map['dmgModiPc2Npc'] > 100 ? '+' : ''; ?><?php echo $map['dmgModiPc2Npc'] - 100; ?>%)
                                </span>
                                <?php endif; ?>
                            </span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-dragon"></i> NPC → Player Damage
                            </span>
                            <span class="detail-stat-value damage-modifier <?php echo $map['dmgModiNpc2Pc'] > 100 ? 'negative' : ($map['dmgModiNpc2Pc'] < 100 ? 'positive' : ''); ?>">
                                <?php echo $map['dmgModiNpc2Pc']; ?>%
                                <?php if ($map['dmgModiNpc2Pc'] != 100): ?>
                                <span class="modifier-change">
                                    (<?php echo $map['dmgModiNpc2Pc'] > 100 ? '+' : ''; ?><?php echo $map['dmgModiNpc2Pc'] - 100; ?>%)
                                </span>
                                <?php endif; ?>
                            </span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-heart-broken"></i> HP Decrease Effect
                            </span>
                            <span class="detail-stat-value">
                                <?php echo formatYesNo($map['decreaseHp']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Special Zones Card -->
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">
                        <i class="fas fa-star"></i> Special Zone Properties
                    </h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-baby"></i> Beginner Zone
                            </span>
                            <span class="detail-stat-value zone-status <?php echo $map['beginZone'] ? 'active' : ''; ?>">
                                <?php echo formatYesNo($map['beginZone']); ?>
                            </span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-chess-knight"></i> Red Knight Zone
                            </span>
                            <span class="detail-stat-value zone-status <?php echo $map['redKnightZone'] ? 'active' : ''; ?>">
                                <?php echo formatYesNo($map['redKnightZone']); ?>
                            </span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-castle"></i> Ruun Castle Zone
                            </span>
                            <span class="detail-stat-value zone-status <?php echo $map['ruunCastleZone'] ? 'active' : ''; ?>">
                                <?php echo formatYesNo($map['ruunCastleZone']); ?>
                            </span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-flag"></i> Inter War Zone
                            </span>
                            <span class="detail-stat-value zone-status <?php echo $map['interWarZone'] ? 'active' : ''; ?>">
                                <?php echo formatYesNo($map['interWarZone']); ?>
                            </span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-shield-alt"></i> Gerad Buff Zone
                            </span>
                            <span class="detail-stat-value zone-status <?php echo $map['geradBuffZone'] ? 'active' : ''; ?>">
                                <?php echo formatYesNo($map['geradBuffZone']); ?>
                            </span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-seedling"></i> Grow Buff Zone
                            </span>
                            <span class="detail-stat-value zone-status <?php echo $map['growBuffZone'] ? 'active' : ''; ?>">
                                <?php echo formatYesNo($map['growBuffZone']); ?>
                            </span>
                        </div>
                        
                        <?php if (!empty($map['script'])): ?>
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-code"></i> Special Script
                            </span>
                            <span class="detail-stat-value script-value">
                                <code><?php echo htmlspecialchars($map['script']); ?></code>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Clone Information (if applicable) -->
                <?php if ($map['cloneStart'] > 0 || $map['cloneEnd'] > 0): ?>
                <div class="detail-stats-card">
                    <h3 class="detail-stat-title">
                        <i class="fas fa-copy"></i> Instance Information
                    </h3>
                    <div class="detail-stats">
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-play"></i> Clone Start ID
                            </span>
                            <span class="detail-stat-value"><?php echo number_format($map['cloneStart']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-stop"></i> Clone End ID
                            </span>
                            <span class="detail-stat-value"><?php echo number_format($map['cloneEnd']); ?></span>
                        </div>
                        
                        <div class="detail-stat">
                            <span class="detail-stat-label">
                                <i class="fas fa-calculator"></i> Total Instances
                            </span>
                            <span class="detail-stat-value">
                                <?php echo number_format($map['cloneEnd'] - $map['cloneStart'] + 1); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Navigation Actions -->
                <div class="detail-actions">
                    <div class="action-group">
                        <a href="index.php" class="detail-button detail-button-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Maps List
                        </a>
                        
                        <?php
                        // Get previous and next map IDs for navigation - FIXED TABLE NAME
                        $prevMapQuery = "SELECT mapid, locationname FROM mapids WHERE mapid < ? ORDER BY mapid DESC LIMIT 1";
                        $nextMapQuery = "SELECT mapid, locationname FROM mapids WHERE mapid > ? ORDER BY mapid ASC LIMIT 1";
                        
                        $prevMap = $db->fetchAll($prevMapQuery, [$mapId]);
                        $nextMap = $db->fetchAll($nextMapQuery, [$mapId]);
                        ?>
                        
                        <?php if (!empty($prevMap)): ?>
                        <a href="detail.php?id=<?php echo $prevMap[0]['mapid']; ?>" 
                           class="detail-button detail-button-nav" 
                           title="<?php echo htmlspecialchars($prevMap[0]['locationname'] ?? 'Map #' . $prevMap[0]['mapid']); ?>">
                            <i class="fas fa-chevron-left"></i> Previous Map
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($nextMap)): ?>
                        <a href="detail.php?id=<?php echo $nextMap[0]['mapid']; ?>" 
                           class="detail-button detail-button-nav"
                           title="<?php echo htmlspecialchars($nextMap[0]['locationname'] ?? 'Map #' . $nextMap[0]['mapid']); ?>">
                            Next Map <i class="fas fa-chevron-right"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="action-group">
                        <button onclick="window.print()" class="detail-button detail-button-utility">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button onclick="copyToClipboard('<?php echo $map['mapid']; ?>')" class="detail-button detail-button-utility">
                            <i class="fas fa-link"></i> Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function copyToClipboard(mapId) {
    const url = window.location.origin + window.location.pathname + '?id=' + mapId;
    navigator.clipboard.writeText(url).then(() => {
        // You could add a toast notification here
        alert('Map link copied to clipboard!');
    }).catch(() => {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Map link copied to clipboard!');
    });
}
</script>

<?php
// Include footer
include '../../includes/footer.php';
?>