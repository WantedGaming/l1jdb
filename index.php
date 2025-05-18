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
    
    <!-- Recent Additions Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Recent Additions</h2>
            
            <!-- Recent Weapons -->
            <div class="recent-list">
                <h3 class="recent-list-title">Weapons</h3>
                
                <?php foreach ($recentWeapons as $weapon): ?>
                <div class="recent-list-item">
                    <img src="<?php echo $weapons->getWeaponIconUrl($weapon['iconId']); ?>" alt="<?php echo htmlspecialchars($weapon['desc_en']); ?>" class="recent-list-img">
                    <div class="recent-list-info">
                        <h4 class="recent-list-name"><?php echo htmlspecialchars($weapon['desc_en']); ?></h4>
                        <div class="recent-list-meta">
                            <span class="recent-list-type"><?php echo $weapon['type']; ?></span>
                            <span class="recent-list-grade"><?php echo $weapon['itemGrade']; ?> Grade</span>
                        </div>
                        <div class="recent-list-subtitle"><?php echo htmlspecialchars($weapon['desc_kr']); ?></div>
                    </div>
                    <div class="recent-list-actions">
                        <a href="public/weapons/detail.php?id=<?php echo $weapon['item_id']; ?>" class="recent-list-link">Details <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="recent-list-footer">
                    <a href="public/weapons/index.php" class="recent-list-more">View All Weapons</a>
                </div>
            </div>
            
            <!-- Recent Armor -->
            <div class="recent-list">
                <h3 class="recent-list-title">Armor</h3>
                
                <?php foreach ($recentArmor as $armorItem): ?>
                <div class="recent-list-item">
                    <img src="<?php echo $armor->getArmorIconUrl($armorItem['iconId']); ?>" alt="<?php echo htmlspecialchars($armorItem['desc_en']); ?>" class="recent-list-img">
                    <div class="recent-list-info">
                        <h4 class="recent-list-name"><?php echo htmlspecialchars($armorItem['desc_en']); ?></h4>
                        <div class="recent-list-meta">
                            <span class="recent-list-type"><?php echo $armorItem['type']; ?></span>
                            <span class="recent-list-grade"><?php echo $armorItem['itemGrade']; ?> Grade</span>
                        </div>
                        <div class="recent-list-subtitle"><?php echo htmlspecialchars($armorItem['desc_kr']); ?></div>
                    </div>
                    <div class="recent-list-actions">
                        <a href="public/armor/detail.php?id=<?php echo $armorItem['item_id']; ?>" class="recent-list-link">Details <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="recent-list-footer">
                    <a href="public/armor/index.php" class="recent-list-more">View All Armor</a>
                </div>
            </div>
            
            <!-- Recent Items -->
            <div class="recent-list">
                <h3 class="recent-list-title">Items</h3>
                
                <?php foreach ($recentItems as $item): ?>
                <div class="recent-list-item">
                    <img src="<?php echo $items->getItemIconUrl($item['iconId']); ?>" alt="<?php echo htmlspecialchars($item['desc_en']); ?>" class="recent-list-img">
                    <div class="recent-list-info">
                        <h4 class="recent-list-name"><?php echo htmlspecialchars($item['desc_en']); ?></h4>
                        <div class="recent-list-meta">
                            <span class="recent-list-type"><?php echo $item['item_type']; ?></span>
                            <span class="recent-list-grade"><?php echo $item['itemGrade']; ?> Grade</span>
                        </div>
                        <div class="recent-list-subtitle"><?php echo htmlspecialchars($item['desc_kr']); ?></div>
                    </div>
                    <div class="recent-list-actions">
                        <a href="public/items/detail.php?id=<?php echo $item['item_id']; ?>" class="recent-list-link">Details <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="recent-list-footer">
                    <a href="public/items/index.php" class="recent-list-more">View All Items</a>
                </div>
            </div>
            
            <!-- Recent Maps -->
            <div class="recent-list">
                <h3 class="recent-list-title">Maps</h3>
                
                <?php foreach ($recentMaps as $map): ?>
                <div class="recent-list-item">
                    <img src="<?php echo $maps->getMapImageUrl($map['pngId']); ?>" alt="<?php echo htmlspecialchars($map['locationname']); ?>" class="recent-list-img">
                    <div class="recent-list-info">
                        <h4 class="recent-list-name"><?php echo htmlspecialchars($map['locationname']); ?></h4>
                        <div class="recent-list-meta">
                            <span class="recent-list-type">Map ID: <?php echo $map['mapid']; ?></span>
                        </div>
                        <div class="recent-list-subtitle"><?php echo htmlspecialchars($map['desc_kr']); ?></div>
                    </div>
                    <div class="recent-list-actions">
                        <a href="public/maps/detail.php?id=<?php echo $map['mapid']; ?>" class="recent-list-link">Details <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="recent-list-footer">
                    <a href="public/maps/index.php" class="recent-list-more">View All Maps</a>
                </div>
            </div>
            
            <!-- Recent Monsters -->
            <div class="recent-list">
                <h3 class="recent-list-title">Monsters</h3>
                
                <?php foreach ($recentMonsters as $monster_item): ?>
                <div class="recent-list-item">
                    <img src="<?php echo $monster->getMonsterSpriteUrl($monster_item['spriteId']); ?>" alt="<?php echo htmlspecialchars($monster_item['desc_en']); ?>" class="recent-list-img">
                    <div class="recent-list-info">
                        <h4 class="recent-list-name"><?php echo htmlspecialchars($monster_item['desc_en']); ?></h4>
                        <div class="recent-list-meta">
                            <span class="recent-list-type">Level: <?php echo $monster_item['lvl']; ?></span>
                            <span class="recent-list-grade">HP: <?php echo $monster_item['hp']; ?></span>
                        </div>
                        <div class="recent-list-subtitle"><?php echo htmlspecialchars($monster_item['desc_kr']); ?></div>
                    </div>
                    <div class="recent-list-actions">
                        <a href="public/monsters/detail.php?id=<?php echo $monster_item['npcid']; ?>" class="recent-list-link">Details <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="recent-list-footer">
                    <a href="public/monsters/index.php" class="recent-list-more">View All Monsters</a>
                </div>
            </div>
            
            <!-- Recent Dolls -->
            <div class="recent-list">
                <h3 class="recent-list-title">Dolls</h3>
                
                <?php foreach ($recentDolls as $doll): ?>
                <div class="recent-list-item">
                    <img src="<?php echo $dolls->getDollIconUrl($doll['iconId']); ?>" alt="<?php echo htmlspecialchars($doll['desc_en']); ?>" class="recent-list-img">
                    <div class="recent-list-info">
                        <h4 class="recent-list-name"><?php echo htmlspecialchars($doll['desc_en']); ?></h4>
                        <div class="recent-list-meta">
                            <span class="recent-list-type">Min Level: <?php echo $doll['min_lvl']; ?></span>
                            <span class="recent-list-grade"><?php echo $doll['itemGrade']; ?> Grade</span>
                        </div>
                        <div class="recent-list-subtitle"><?php echo htmlspecialchars($doll['desc_kr']); ?></div>
                    </div>
                    <div class="recent-list-actions">
                        <a href="public/dolls/detail.php?id=<?php echo $doll['item_id']; ?>" class="recent-list-link">Details <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="recent-list-footer">
                    <a href="public/dolls/index.php" class="recent-list-more">View All Dolls</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Include footer
include 'includes/footer.php';
?>