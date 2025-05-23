<?php
// Include configuration
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../classes/User.php';
require_once '../classes/Weapon.php';
require_once '../classes/Armor.php';
require_once '../classes/Item.php';
require_once '../classes/Map.php';
require_once '../classes/Monster.php';
require_once '../classes/Doll.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: login.php');
    exit;
}

// Update user's last active time
$currentUser = $user->getCurrentUser();
if ($currentUser) {
    $user->updateLastActive($currentUser['login']);
}

// Get database statistics
$db = Database::getInstance();

// Total counts for each category
$totalWeapons = $db->count('weapon');
$totalArmor = $db->count('armor');
$totalItems = $db->count('etcitem');
$totalMaps = $db->count('mapids');
$totalMonsters = $db->count('npc', 'impl = "L1Monster"');
$totalDolls = $db->count('etcitem', 'item_type = "MAGICDOLL"');

// Recent admin activity
$recentActivity = $user->getActivityLogs(1, 5);

// Get recent database modifications
$recentModifications = $db->fetchAll(
    "SELECT * FROM admin_activity 
     WHERE activity_type IN ('create', 'update', 'delete') 
     ORDER BY timestamp DESC 
     LIMIT 5"
);

// Include admin header
include '../includes/admin-header.php';
?>

<!-- Main Content -->
<main class="admin-dashboard">
    <div class="container">
        <div class="admin-dashboard-header">
            <h1 class="admin-dashboard-title">Admin Dashboard</h1>
            <div class="admin-dashboard-actions">
                <a href="../index.php" class="admin-button admin-button-secondary">View Website</a>
            </div>
        </div>
        
        <!-- Dashboard Stats -->
        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Weapons</h3>
                    <i class="fas fa-sword admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($totalWeapons); ?></div>
                <a href="weapons/index.php" class="admin-stat-link">Manage Weapons</a>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Armor</h3>
                    <i class="fas fa-shield-alt admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($totalArmor); ?></div>
                <a href="armor/index.php" class="admin-stat-link">Manage Armor</a>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Items</h3>
                    <i class="fas fa-box admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($totalItems); ?></div>
                <a href="items/index.php" class="admin-stat-link">Manage Items</a>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Maps</h3>
                    <i class="fas fa-map admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($totalMaps); ?></div>
                <a href="maps/index.php" class="admin-stat-link">Manage Maps</a>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Monsters</h3>
                    <i class="fas fa-dragon admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($totalMonsters); ?></div>
                <a href="monsters/index.php" class="admin-stat-link">Manage Monsters</a>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Dolls</h3>
                    <i class="fas fa-baby admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($totalDolls); ?></div>
                <a href="dolls/index.php" class="admin-stat-link">Manage Dolls</a>
            </div>
			
			<div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">DB Explore</h3>
                    <i class="fas fa fa-database admin-stat-icon"></i>
                </div>
                <a href="tools/database-explorer.php" class="admin-stat-link">DB Stats</a>
            </div>
			
			<div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Functions</h3>
                    <i class="fas fa fa-cog admin-stat-icon"></i>
                </div>
                <a href="tools/functions.php" class="admin-stat-link">DB Stats</a>
            </div>
        </div>
        
        <div class="admin-content-area">
            <div class="admin-main-content">
                <h2 class="admin-content-title">Recent Activity</h2>
                
                <div class="activity-log">
                    <?php if (empty($recentActivity['data'])): ?>
                    <p>No recent activity.</p>
                    <?php else: ?>
                        <?php foreach ($recentActivity['data'] as $activity): ?>
                        <div class="activity-log-item">
                            <div class="activity-log-icon">
                                <?php
                                $iconClass = '';
                                switch ($activity['activity_type']) {
                                    case 'login':
                                        $iconClass = 'fas fa-sign-in-alt';
                                        break;
                                    case 'logout':
                                        $iconClass = 'fas fa-sign-out-alt';
                                        break;
                                    case 'create':
                                        $iconClass = 'fas fa-plus-circle';
                                        break;
                                    case 'update':
                                        $iconClass = 'fas fa-edit';
                                        break;
                                    case 'delete':
                                        $iconClass = 'fas fa-trash-alt';
                                        break;
                                    case 'view':
                                        $iconClass = 'fas fa-eye';
                                        break;
                                    default:
                                        $iconClass = 'fas fa-cog';
                                }
                                ?>
                                <i class="<?php echo $iconClass; ?>"></i>
                            </div>
                            <div class="activity-log-content">
                                <div class="activity-log-title">
                                    <?php echo htmlspecialchars($activity['admin_username']); ?> - 
                                    <?php echo isset(ACTIVITY_TYPES[$activity['activity_type']]) ? ACTIVITY_TYPES[$activity['activity_type']] : ucfirst($activity['activity_type']); ?>
                                </div>
                                <div class="activity-log-details">
                                    <?php echo htmlspecialchars($activity['description']); ?>
                                    <?php if ($activity['entity_type'] && $activity['entity_id']): ?>
                                    <span class="activity-log-entity">
                                        (<?php echo htmlspecialchars($activity['entity_type']); ?> #<?php echo $activity['entity_id']; ?>)
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="activity-log-time">
                                    <?php echo date('F j, Y, g:i a', strtotime($activity['timestamp'])); ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="admin-content-footer">
                    <a href="activity/index.php" class="admin-button admin-button-primary">View All Activity</a>
                </div>
            </div>
            
            <div class="admin-sidebar">
                <div class="admin-sidebar-card">
                    <h3 class="admin-sidebar-title">Quick Actions</h3>
                    <ul class="admin-quick-links">
                        <li class="admin-quick-link">
                            <a href="weapons/create.php">
                                <i class="fas fa-plus-circle"></i> Add New Weapon
                            </a>
                        </li>
                        <li class="admin-quick-link">
                            <a href="armor/create.php">
                                <i class="fas fa-plus-circle"></i> Add New Armor
                            </a>
                        </li>
                        <li class="admin-quick-link">
                            <a href="items/create.php">
                                <i class="fas fa-plus-circle"></i> Add New Item
                            </a>
                        </li>
                        <li class="admin-quick-link">
                            <a href="maps/create.php">
                                <i class="fas fa-plus-circle"></i> Add New Map
                            </a>
                        </li>
                        <li class="admin-quick-link">
                            <a href="monsters/create.php">
                                <i class="fas fa-plus-circle"></i> Add New Monster
                            </a>
                        </li>
                        <li class="admin-quick-link">
                            <a href="dolls/create.php">
                                <i class="fas fa-plus-circle"></i> Add New Doll
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="admin-sidebar-card">
                    <h3 class="admin-sidebar-title">Admin Users</h3>
                    <?php
                    $admins = $user->getAllAdmins();
                    ?>
                    <ul class="admin-users-list">
                        <?php foreach ($admins as $admin): ?>
                        <li class="admin-user-item">
                            <div class="admin-user-info">
                                <span class="admin-user-name"><?php echo htmlspecialchars($admin['login']); ?></span>
                                <span class="admin-user-status <?php echo strtotime($admin['lastactive']) > time() - 600 ? 'active' : 'inactive'; ?>">
                                    <?php echo strtotime($admin['lastactive']) > time() - 600 ? 'Online' : 'Offline'; ?>
                                </span>
                            </div>
                            <div class="admin-user-last-active">
                                Last active: <?php echo date('M j, Y, g:i a', strtotime($admin['lastactive'])); ?>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Include admin footer
include '../includes/admin-footer.php';
?>
