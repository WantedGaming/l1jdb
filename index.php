<?php
// Main index.php - Entry point of the website
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Weapon.php';
require_once __DIR__ . '/classes/Armor.php';
require_once __DIR__ . '/classes/Item.php';
require_once __DIR__ . '/classes/Map.php';
require_once __DIR__ . '/classes/Monster.php';
require_once __DIR__ . '/classes/Doll.php';

// Initialize session
init_session();

// Initialize database
$db = Database::getInstance();

// Initialize user
$user = new User();

// Get recent items from each category for the homepage
$weapons = new Weapon();
$recentWeapons = $weapons->getRecentWeapons(4);

$armor = new Armor();
$recentArmor = $armor->getRecentArmor(4);

$items = new Item();
$recentItems = $items->getRecentItems(4);

$maps = new Map();
$recentMaps = $maps->getRecentMaps(4);

$monster = new Monster();
$recentMonsters = $monster->getRecentMonsters(4);

$dolls = new Doll();
$recentDolls = $dolls->getRecentDolls(4);

// Create a combined array of all recent activities
$recentActivities = [];

// Simulate database activities - in a real application, this would come from an activity log table
// For now, let's create some sample activities using our real data
$activityTypes = ['added', 'updated', 'removed'];

// Add weapons to the activity feed
foreach (array_slice($recentWeapons, 0, 1) as $item) {
    $recentActivities[] = [
        'type' => $activityTypes[0], // Added
        'item_type' => 'weapon',
        'item_name' => $item['desc_en'],
        'image' => $weapons->getWeaponIconUrl($item['iconId']),
        'timestamp' => date('Y-m-d H:i:s', strtotime('-1 hour')),
    ];
}

// Add armor to the activity feed
foreach (array_slice($recentArmor, 0, 1) as $item) {
    $recentActivities[] = [
        'type' => $activityTypes[1], // Updated
        'item_type' => 'armor',
        'item_name' => $item['desc_en'],
        'image' => $armor->getArmorIconUrl($item['iconId']),
        'timestamp' => date('Y-m-d H:i:s', strtotime('-3 hours')),
    ];
}

// Add items to the activity feed
foreach (array_slice($recentItems, 0, 1) as $item) {
    $recentActivities[] = [
        'type' => $activityTypes[0], // Added
        'item_type' => 'item',
        'item_name' => $item['desc_en'],
        'image' => $items->getItemIconUrl($item['iconId']),
        'timestamp' => date('Y-m-d H:i:s', strtotime('-5 hours')),
    ];
}

// Add maps to the activity feed
foreach (array_slice($recentMaps, 0, 1) as $item) {
    $recentActivities[] = [
        'type' => $activityTypes[2], // Removed
        'item_type' => 'map',
        'item_name' => $item['locationname'],
        'image' => $maps->getMapImageUrl($item['pngId']),
        'timestamp' => date('Y-m-d H:i:s', strtotime('-8 hours')),
    ];
}

// Add monsters to the activity feed
foreach (array_slice($recentMonsters, 0, 1) as $item) {
    $recentActivities[] = [
        'type' => $activityTypes[1], // Updated
        'item_type' => 'monster',
        'item_name' => $item['desc_en'],
        'image' => $monster->getMonsterSpriteUrl($item['spriteId']),
        'timestamp' => date('Y-m-d H:i:s', strtotime('-10 hours')),
    ];
}

// Sort the activities by timestamp (most recent first)
usort($recentActivities, function($a, $b) {
    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
});

// Limit to only 5 most recent activities
$recentActivities = array_slice($recentActivities, 0, 5);

// Include header
include 'includes/header.php';

// Include hero section
include 'includes/hero.php';
?>

<!-- Main Content -->
<main>
    <!-- Recent Activity Section - Now positioned above categories -->
    <section class="section activity-section">
        <div class="container">
            <h2 class="section-title">Recent Database Activity</h2>
            
            <div class="activity-feed">
                <?php foreach ($recentActivities as $activity): ?>
                <div class="activity-item activity-<?php echo $activity['type']; ?>">
                    <div class="activity-icon">
                        <img src="<?php echo $activity['image']; ?>" alt="<?php echo htmlspecialchars($activity['item_name']); ?>">
                    </div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-type"><?php echo ucfirst($activity['type']); ?></span>
                            <span class="activity-time"><?php echo timeAgo($activity['timestamp']); ?></span>
                        </div>
                        <div class="activity-message">
                            <?php 
                            switch($activity['type']) {
                                case 'added':
                                    echo 'New ' . ucfirst($activity['item_type']) . ' added: <strong>' . htmlspecialchars($activity['item_name']) . '</strong>';
                                    break;
                                case 'updated':
                                    echo ucfirst($activity['item_type']) . ' updated: <strong>' . htmlspecialchars($activity['item_name']) . '</strong>';
                                    break;
                                case 'removed':
                                    echo ucfirst($activity['item_type']) . ' removed: <strong>' . htmlspecialchars($activity['item_name']) . '</strong>';
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Database Categories</h2>
            
            <div class="card-grid">
                <!-- Weapons Card -->
                <div class="card category-card">
                    <a href="public/weapons/index.php" class="card-link-overlay"></a>
                    <div class="card-header">
                        <h3 class="card-header-title">Weapons</h3>
                        <span class="card-badge"><?php echo count($weapons->getWeaponTypes()); ?> Types</span>
                    </div>
                    <div class="card-img-container">
                        <img src="assets/img/placeholders/weapons.png" alt="Weapons" class="card-img">
                    </div>
                    <div class="card-content">
                        <p class="card-text">Explore a vast collection of weapons, from simple daggers to legendary swords.</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-category">View Collection</span>
                        <div class="card-indicator">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Armor Card -->
                <div class="card category-card">
                    <a href="public/armor/index.php" class="card-link-overlay"></a>
                    <div class="card-header">
                        <h3 class="card-header-title">Armor</h3>
                        <span class="card-badge"><?php echo count($armor->getArmorTypes()); ?> Types</span>
                    </div>
                    <div class="card-img-container">
                        <img src="assets/img/placeholders/armor.png" alt="Armor" class="card-img">
                    </div>
                    <div class="card-content">
                        <p class="card-text">Discover protective gear from light cloth to heavy plate armor sets.</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-category">View Collection</span>
                        <div class="card-indicator">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Items Card -->
                <div class="card category-card">
                    <a href="public/items/index.php" class="card-link-overlay"></a>
                    <div class="card-header">
                        <h3 class="card-header-title">Items</h3>
                        <span class="card-badge"><?php echo count($items->getItemTypes()); ?> Types</span>
                    </div>
                    <div class="card-img-container">
                        <img src="assets/img/placeholders/items.png" alt="Items" class="card-img">
                    </div>
                    <div class="card-content">
                        <p class="card-text">Find consumables, quest items, and special treasures from around the world.</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-category">View Collection</span>
                        <div class="card-indicator">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Maps Card -->
                <div class="card category-card">
                    <a href="public/maps/index.php" class="card-link-overlay"></a>
                    <div class="card-header">
                        <h3 class="card-header-title">Maps</h3>
                        <span class="card-badge"><?php echo count($maps->getMapTypes()); ?> Regions</span>
                    </div>
                    <div class="card-img-container">
                        <img src="assets/img/placeholders/maps.png" alt="Maps" class="card-img">
                    </div>
                    <div class="card-content">
                        <p class="card-text">Explore the world's regions, dungeons, and special areas with detailed maps.</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-category">View Collection</span>
                        <div class="card-indicator">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Monsters Card -->
                <div class="card category-card">
                    <a href="public/monsters/index.php" class="card-link-overlay"></a>
                    <div class="card-header">
                        <h3 class="card-header-title">Monsters</h3>
                        <span class="card-badge"><?php echo count($monster->getMonsterTypes()); ?> Types</span>
                    </div>
                    <div class="card-img-container">
                        <img src="assets/img/placeholders/monsters.png" alt="Monsters" class="card-img">
                    </div>
                    <div class="card-content">
                        <p class="card-text">Learn about creatures, bosses, and enemies that inhabit the game world.</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-category">View Collection</span>
                        <div class="card-indicator">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Dolls Card -->
                <div class="card category-card">
                    <a href="public/dolls/index.php" class="card-link-overlay"></a>
                    <div class="card-header">
                        <h3 class="card-header-title">Dolls</h3>
                        <span class="card-badge"><?php echo count($dolls->getDollGrades()); ?> Grades</span>
                    </div>
                    <div class="card-img-container">
                        <img src="assets/img/placeholders/dolls.png" alt="Dolls" class="card-img">
                    </div>
                    <div class="card-content">
                        <p class="card-text">Discover magical dolls that provide special buffs and abilities.</p>
                    </div>
                    <div class="card-footer">
                        <span class="card-category">View Collection</span>
                        <div class="card-indicator">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Helper function to show time ago format
function timeAgo($timestamp) {
    $time = strtotime($timestamp);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return "Just now";
    } elseif ($diff < 3600) {
        $mins = round($diff / 60);
        return $mins . " minute" . ($mins > 1 ? "s" : "") . " ago";
    } elseif ($diff < 86400) {
        $hours = round($diff / 3600);
        return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
    } elseif ($diff < 604800) {
        $days = round($diff / 86400);
        return $days . " day" . ($days > 1 ? "s" : "") . " ago";
    } else {
        return date("M j, Y", $time);
    }
}

// Include footer
include 'includes/footer.php';
?>