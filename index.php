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

// Include header
include 'includes/header.php';

// Include hero section
include 'includes/hero.php';
?>

<!-- Main Content -->
<main>
    <!-- Categories Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Database Categories</h2>
            
            <div class="card-grid">
                <!-- Weapons Card -->
                <div class="card">
                    <img src="assets/img/placeholders/weapons.png" alt="Weapons" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title">Weapons</h3>
                        <p class="card-text">Explore a vast collection of weapons, from simple daggers to legendary swords.</p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo count($weapons->getWeaponTypes()); ?> Types</span>
                            <a href="public/weapons/index.php" class="card-link">Browse All &rarr;</a>
                        </div>
                    </div>
                </div>
                
                <!-- Armor Card -->
                <div class="card">
                    <img src="assets/img/placeholders/armor.png" alt="Armor" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title">Armor</h3>
                        <p class="card-text">Discover protective gear from light cloth to heavy plate armor sets.</p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo count($armor->getArmorTypes()); ?> Types</span>
                            <a href="public/armor/index.php" class="card-link">Browse All &rarr;</a>
                        </div>
                    </div>
                </div>
                
                <!-- Items Card -->
                <div class="card">
                    <img src="assets/img/placeholders/items.png" alt="Items" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title">Items</h3>
                        <p class="card-text">Find consumables, quest items, and special treasures from around the world.</p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo count($items->getItemTypes()); ?> Types</span>
                            <a href="public/items/index.php" class="card-link">Browse All &rarr;</a>
                        </div>
                    </div>
                </div>
                
                <!-- Maps Card -->
                <div class="card">
                    <img src="assets/img/placeholders/maps.png" alt="Maps" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title">Maps</h3>
                        <p class="card-text">Explore the world's regions, dungeons, and special areas with detailed maps.</p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo count($maps->getMapTypes()); ?> Regions</span>
                            <a href="public/maps/index.php" class="card-link">Browse All &rarr;</a>
                        </div>
                    </div>
                </div>
                
                <!-- Monsters Card -->
                <div class="card">
                    <img src="assets/img/placeholders/monsters.png" alt="Monsters" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title">Monsters</h3>
                        <p class="card-text">Learn about creatures, bosses, and enemies that inhabit the game world.</p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo count($monster->getMonsterTypes()); ?> Types</span>
                            <a href="public/monsters/index.php" class="card-link">Browse All &rarr;</a>
                        </div>
                    </div>
                </div>
                
                <!-- Dolls Card -->
                <div class="card">
                    <img src="assets/img/placeholders/dolls.png" alt="Dolls" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title">Dolls</h3>
                        <p class="card-text">Discover magical dolls that provide special buffs and abilities.</p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo count($dolls->getDollGrades()); ?> Grades</span>
                            <a href="public/dolls/index.php" class="card-link">Browse All &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Recent Additions Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Recent Additions</h2>
            
            <!-- Recent Weapons -->
            <h3 class="category-title">Weapons</h3>
            <div class="card-grid">
                <?php foreach ($recentWeapons as $weapon): ?>
                <div class="card">
                    <img src="<?php echo $weapons->getWeaponIconUrl($weapon['iconId']); ?>" alt="<?php echo htmlspecialchars($weapon['desc_en']); ?>" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($weapon['desc_en']); ?></h3>
                        <p class="card-text"><?php echo htmlspecialchars($weapon['desc_kr']); ?></p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo $weapon['type']; ?></span>
                            <a href="public/weapons/detail.php?id=<?php echo $weapon['item_id']; ?>" class="card-link">View Details &rarr;</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Recent Armor -->
            <h3 class="category-title">Armor</h3>
            <div class="card-grid">
                <?php foreach ($recentArmor as $armorItem): ?>
                <div class="card">
                    <img src="<?php echo $armor->getArmorIconUrl($armorItem['iconId']); ?>" alt="<?php echo htmlspecialchars($armorItem['desc_en']); ?>" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($armorItem['desc_en']); ?></h3>
                        <p class="card-text"><?php echo htmlspecialchars($armorItem['desc_kr']); ?></p>
                        <div class="card-footer">
                            <span class="card-category"><?php echo $armorItem['type']; ?></span>
                            <a href="public/armor/detail.php?id=<?php echo $armorItem['item_id']; ?>" class="card-link">View Details &rarr;</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Continue for other categories -->
            
        </div>
    </section>
</main>

<?php
// Include footer
include 'includes/footer.php';
?>
