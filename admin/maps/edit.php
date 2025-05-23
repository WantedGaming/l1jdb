<?php
// Admin map edit page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Map.php';
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

// Initialize database directly for some operations
$db = Database::getInstance();

// Initialize map model
$mapModel = new Map();

// Get map ID from URL
$mapId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get map data
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get map data from form
    $mapData = [
        'locationname' => $_POST['locationname'] ?? null,
        'desc_kr' => $_POST['desc_kr'] ?? '',
        'startX' => (int)($_POST['startX'] ?? 0),
        'endX' => (int)($_POST['endX'] ?? 0),
        'startY' => (int)($_POST['startY'] ?? 0),
        'endY' => (int)($_POST['endY'] ?? 0),
        'monster_amount' => (float)($_POST['monster_amount'] ?? 0),
        'drop_rate' => (float)($_POST['drop_rate'] ?? 0),
        'underwater' => isset($_POST['underwater']) ? 1 : 0,
        'markable' => isset($_POST['markable']) ? 1 : 0,
        'teleportable' => isset($_POST['teleportable']) ? 1 : 0,
        'escapable' => isset($_POST['escapable']) ? 1 : 0,
        'resurrection' => isset($_POST['resurrection']) ? 1 : 0,
        'painwand' => isset($_POST['painwand']) ? 1 : 0,
        'penalty' => isset($_POST['penalty']) ? 1 : 0,
        'take_pets' => isset($_POST['take_pets']) ? 1 : 0,
        'recall_pets' => isset($_POST['recall_pets']) ? 1 : 0,
        'usable_item' => isset($_POST['usable_item']) ? 1 : 0,
        'usable_skill' => isset($_POST['usable_skill']) ? 1 : 0,
        'dungeon' => isset($_POST['dungeon']) ? 1 : 0,
        'dmgModiPc2Npc' => (int)($_POST['dmgModiPc2Npc'] ?? 0),
        'dmgModiNpc2Pc' => (int)($_POST['dmgModiNpc2Pc'] ?? 0),
        'decreaseHp' => isset($_POST['decreaseHp']) ? 1 : 0,
        'dominationTeleport' => isset($_POST['dominationTeleport']) ? 1 : 0,
        'beginZone' => isset($_POST['beginZone']) ? 1 : 0,
        'redKnightZone' => isset($_POST['redKnightZone']) ? 1 : 0,
        'ruunCastleZone' => isset($_POST['ruunCastleZone']) ? 1 : 0,
        'interWarZone' => isset($_POST['interWarZone']) ? 1 : 0,
        'geradBuffZone' => isset($_POST['geradBuffZone']) ? 1 : 0,
        'growBuffZone' => isset($_POST['growBuffZone']) ? 1 : 0,
        'interKind' => (int)($_POST['interKind'] ?? 0),
        'script' => $_POST['script'] ?? null,
        'cloneStart' => (int)($_POST['cloneStart'] ?? 0),
        'cloneEnd' => (int)($_POST['cloneEnd'] ?? 0),
        'pngId' => (int)($_POST['pngId'] ?? 0)
    ];
    
    // Update map type
    $newMapType = $_POST['map_type'] ?? 'NORMAL';
    $mapTypeUpdateQuery = "UPDATE map_type SET type = ? WHERE mapId = ?";
    $db->update($mapTypeUpdateQuery, [$newMapType, $mapId]);
    
    // Insert map type if it doesn't exist
    if ($db->getAffectedRows() === 0) {
        $mapTypeInsertQuery = "INSERT INTO map_type (mapId, type) VALUES (?, ?)";
        $db->insert($mapTypeInsertQuery, [$mapId, $newMapType]);
    }

    // Update map data
    if ($mapModel->updateMap($mapId, $mapData)) {
        // Get current user data
        $currentUser = $user->getCurrentUser();
        
        // Log activity with null-safe username
        $user->logActivity(
            $currentUser ? $currentUser['login'] : null,
            'update',
            "Updated map: {$mapData['locationname']} (ID: $mapId)",
            'map',
            $mapId
        );
        
        // Redirect to map detail page with success message
        header('Location: ../../public/maps/detail.php?id=' . $mapId . '&updated=1');
        exit;
    } else {
        $errorMessage = "Failed to update map. Please try again.";
    }
}

// Set page title
$pageTitle = "Edit Map: " . ($map['locationname'] ?? "Map #$mapId");

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
                        <i class="fas fa-arrow-left"></i> Back to Maps
                    </a>
                    <a href="../../public/maps/detail.php?id=<?php echo $mapId; ?>" class="admin-button admin-button-info">
                        <i class="fas fa-eye"></i> View Map
                    </a>
                </div>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <!-- Edit Map Form -->
            <div class="admin-form-container">
                <form action="edit.php?id=<?php echo $mapId; ?>" method="post" class="admin-form">
                <!-- Basic Information Section -->
                <div class="admin-form-section">
                    <h2 class="admin-form-section-title">Basic Information</h2>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="locationname" class="admin-form-label">Map Name</label>
                            <input type="text" id="locationname" name="locationname" class="admin-form-input" value="<?php echo htmlspecialchars($map['locationname'] ?? ''); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="desc_kr" class="admin-form-label">Korean Name</label>
                            <input type="text" id="desc_kr" name="desc_kr" class="admin-form-input" value="<?php echo htmlspecialchars($map['desc_kr'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="map_type" class="admin-form-label">Map Type</label>
                            <select id="map_type" name="map_type" class="admin-form-select">
                                <option value="NORMAL" <?php echo $mapType === 'NORMAL' ? 'selected' : ''; ?>>Normal Zone</option>
                                <option value="COMBAT" <?php echo $mapType === 'COMBAT' ? 'selected' : ''; ?>>Combat Zone</option>
                                <option value="SAFETY" <?php echo $mapType === 'SAFETY' ? 'selected' : ''; ?>>Safety Zone</option>
                            </select>
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="pngId" class="admin-form-label">PNG ID (Map Icon)</label>
                            <input type="number" id="pngId" name="pngId" class="admin-form-input" value="<?php echo (int)($map['pngId'] ?? 0); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Coordinates Section -->
                <div class="admin-form-section">
                    <h2 class="admin-form-section-title">Map Coordinates</h2>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="startX" class="admin-form-label">Start X</label>
                            <input type="number" id="startX" name="startX" class="admin-form-input" value="<?php echo (int)($map['startX'] ?? 0); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="endX" class="admin-form-label">End X</label>
                            <input type="number" id="endX" name="endX" class="admin-form-input" value="<?php echo (int)($map['endX'] ?? 0); ?>">
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="startY" class="admin-form-label">Start Y</label>
                            <input type="number" id="startY" name="startY" class="admin-form-input" value="<?php echo (int)($map['startY'] ?? 0); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="endY" class="admin-form-label">End Y</label>
                            <input type="number" id="endY" name="endY" class="admin-form-input" value="<?php echo (int)($map['endY'] ?? 0); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Creature and Loot Section -->
                <div class="admin-form-section">
                    <h2 class="admin-form-section-title">Creature and Loot Settings</h2>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="monster_amount" class="admin-form-label">Monster Amount</label>
                            <input type="number" id="monster_amount" name="monster_amount" class="admin-form-input" step="0.01" value="<?php echo number_format((float)($map['monster_amount'] ?? 0), 2, '.', ''); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="drop_rate" class="admin-form-label">Drop Rate</label>
                            <input type="number" id="drop_rate" name="drop_rate" class="admin-form-input" step="0.01" value="<?php echo number_format((float)($map['drop_rate'] ?? 0), 2, '.', ''); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Combat Section -->
                <div class="admin-form-section">
                    <h2 class="admin-form-section-title">Combat Settings</h2>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="dmgModiPc2Npc" class="admin-form-label">Player to NPC Damage Modifier (%)</label>
                            <input type="number" id="dmgModiPc2Npc" name="dmgModiPc2Npc" class="admin-form-input" value="<?php echo (int)($map['dmgModiPc2Npc'] ?? 0); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="dmgModiNpc2Pc" class="admin-form-label">NPC to Player Damage Modifier (%)</label>
                            <input type="number" id="dmgModiNpc2Pc" name="dmgModiNpc2Pc" class="admin-form-input" value="<?php echo (int)($map['dmgModiNpc2Pc'] ?? 0); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Map Flags (Boolean) Section -->
                <div class="admin-form-section">
                    <h2 class="admin-form-section-title">Map Flags</h2>
                    
                    <div class="admin-form-checkboxes">
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="underwater" name="underwater" <?php echo ($map['underwater'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="underwater" class="admin-form-checkbox-label">Underwater</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="markable" name="markable" <?php echo ($map['markable'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="markable" class="admin-form-checkbox-label">Markable</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="teleportable" name="teleportable" <?php echo ($map['teleportable'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="teleportable" class="admin-form-checkbox-label">Teleportable</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="escapable" name="escapable" <?php echo ($map['escapable'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="escapable" class="admin-form-checkbox-label">Escapable</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="resurrection" name="resurrection" <?php echo ($map['resurrection'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="resurrection" class="admin-form-checkbox-label">Resurrection</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="painwand" name="painwand" <?php echo ($map['painwand'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="painwand" class="admin-form-checkbox-label">Pain Wand</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="penalty" name="penalty" <?php echo ($map['penalty'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="penalty" class="admin-form-checkbox-label">Penalty</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="take_pets" name="take_pets" <?php echo ($map['take_pets'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="take_pets" class="admin-form-checkbox-label">Take Pets</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="recall_pets" name="recall_pets" <?php echo ($map['recall_pets'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="recall_pets" class="admin-form-checkbox-label">Recall Pets</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="usable_item" name="usable_item" <?php echo ($map['usable_item'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="usable_item" class="admin-form-checkbox-label">Usable Items</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="usable_skill" name="usable_skill" <?php echo ($map['usable_skill'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="usable_skill" class="admin-form-checkbox-label">Usable Skills</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="dungeon" name="dungeon" <?php echo ($map['dungeon'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="dungeon" class="admin-form-checkbox-label">Dungeon</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="decreaseHp" name="decreaseHp" <?php echo ($map['decreaseHp'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="decreaseHp" class="admin-form-checkbox-label">Decrease HP</label>
                        </div>
                    </div>
                </div>
                
                <!-- Special Zone Flags -->
                <div class="admin-form-section">
                    <h2 class="admin-form-section-title">Special Zone Flags</h2>
                    
                    <div class="admin-form-checkboxes">
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="beginZone" name="beginZone" <?php echo ($map['beginZone'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="beginZone" class="admin-form-checkbox-label">Beginner Zone</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="redKnightZone" name="redKnightZone" <?php echo ($map['redKnightZone'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="redKnightZone" class="admin-form-checkbox-label">Red Knight Zone</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="ruunCastleZone" name="ruunCastleZone" <?php echo ($map['ruunCastleZone'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="ruunCastleZone" class="admin-form-checkbox-label">Ruun Castle Zone</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="interWarZone" name="interWarZone" <?php echo ($map['interWarZone'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="interWarZone" class="admin-form-checkbox-label">Inter War Zone</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="geradBuffZone" name="geradBuffZone" <?php echo ($map['geradBuffZone'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="geradBuffZone" class="admin-form-checkbox-label">Gerad Buff Zone</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="growBuffZone" name="growBuffZone" <?php echo ($map['growBuffZone'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="growBuffZone" class="admin-form-checkbox-label">Grow Buff Zone</label>
                        </div>
                        
                        <div class="admin-form-checkbox-group">
                            <input type="checkbox" id="dominationTeleport" name="dominationTeleport" <?php echo ($map['dominationTeleport'] ?? 0) == 1 ? 'checked' : ''; ?>>
                            <label for="dominationTeleport" class="admin-form-checkbox-label">Domination Teleport</label>
                        </div>
                    </div>
                </div>
                
                <!-- Advanced Section -->
                <div class="admin-form-section">
                    <h2 class="admin-form-section-title">Advanced Settings</h2>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="interKind" class="admin-form-label">Inter Kind</label>
                            <input type="number" id="interKind" name="interKind" class="admin-form-input" value="<?php echo (int)($map['interKind'] ?? 0); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="script" class="admin-form-label">Script</label>
                            <input type="text" id="script" name="script" class="admin-form-input" value="<?php echo htmlspecialchars($map['script'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label for="cloneStart" class="admin-form-label">Clone Start ID</label>
                            <input type="number" id="cloneStart" name="cloneStart" class="admin-form-input" value="<?php echo (int)($map['cloneStart'] ?? 0); ?>">
                        </div>
                        
                        <div class="admin-form-group">
                            <label for="cloneEnd" class="admin-form-label">Clone End ID</label>
                            <input type="number" id="cloneEnd" name="cloneEnd" class="admin-form-input" value="<?php echo (int)($map['cloneEnd'] ?? 0); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="admin-form-actions">
                    <button type="submit" class="admin-button admin-button-primary">Update Map</button>
                    <a href="index.php" class="admin-button admin-button-secondary">Cancel</a>
                </div>
            </form>
            </div>
        </div>
    </section>
</main>

<?php
// Include footer
include '../../includes/admin-footer.php';
?> 