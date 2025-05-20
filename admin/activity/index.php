<?php
// Admin activity logs page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Update user's last active time
$currentUser = $user->getCurrentUser();
if ($currentUser) {
    $user->updateLastActive($currentUser['login']);
}

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle filters
$filters = [];
$conditions = '';
$params = [];

// Username filter
if (isset($_GET['username']) && !empty($_GET['username'])) {
    $conditions = 'admin_username LIKE ?';
    $params[] = '%' . $_GET['username'] . '%';
    $filters['username'] = $_GET['username'];
}

// Activity type filter
if (isset($_GET['activity_type']) && !empty($_GET['activity_type'])) {
    if (!empty($conditions)) {
        $conditions .= ' AND ';
    }
    $conditions .= 'activity_type = ?';
    $params[] = $_GET['activity_type'];
    $filters['activity_type'] = $_GET['activity_type'];
}

// Date range filter
if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
    if (!empty($conditions)) {
        $conditions .= ' AND ';
    }
    $conditions .= 'DATE(timestamp) >= ?';
    $params[] = $_GET['date_from'];
    $filters['date_from'] = $_GET['date_from'];
}

if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
    if (!empty($conditions)) {
        $conditions .= ' AND ';
    }
    $conditions .= 'DATE(timestamp) <= ?';
    $params[] = $_GET['date_to'];
    $filters['date_to'] = $_GET['date_to'];
}

// Entity type filter
if (isset($_GET['entity_type']) && !empty($_GET['entity_type'])) {
    if (!empty($conditions)) {
        $conditions .= ' AND ';
    }
    $conditions .= 'entity_type = ?';
    $params[] = $_GET['entity_type'];
    $filters['entity_type'] = $_GET['entity_type'];
}

// IP Address filter
if (isset($_GET['ip_address']) && !empty($_GET['ip_address'])) {
    if (!empty($conditions)) {
        $conditions .= ' AND ';
    }
    $conditions .= 'ip_address LIKE ?';
    $params[] = '%' . $_GET['ip_address'] . '%';
    $filters['ip_address'] = $_GET['ip_address'];
}

// Description search
if (isset($_GET['description']) && !empty($_GET['description'])) {
    if (!empty($conditions)) {
        $conditions .= ' AND ';
    }
    $conditions .= 'description LIKE ?';
    $params[] = '%' . $_GET['description'] . '%';
    $filters['description'] = $_GET['description'];
}

// Get activities with pagination
$activities = $user->getActivityLogs($page, ITEMS_PER_PAGE, $conditions, $params);

// Get distinct usernames for filter
$db = Database::getInstance();
$distinctUsernames = $db->fetchAll("SELECT DISTINCT admin_username FROM admin_activity ORDER BY admin_username");

// Get distinct activity types for filter
$distinctActivityTypes = $db->fetchAll("SELECT DISTINCT activity_type FROM admin_activity ORDER BY activity_type");

// Get distinct entity types for filter
$distinctEntityTypes = $db->fetchAll("SELECT DISTINCT entity_type FROM admin_activity WHERE entity_type IS NOT NULL ORDER BY entity_type");

// Get distinct IP addresses for filter
$distinctIPs = $db->fetchAll("SELECT DISTINCT ip_address FROM admin_activity ORDER BY ip_address LIMIT 100");

// Set page title
$pageTitle = "Admin Activity Logs";

// Hero section content
$heroTitle = "Activity Logs";
$heroSubtitle = "Track all administrative actions across the database";

// Check if filters are active
$filtersActive = !empty($filters);

// Include admin header
include '../../includes/admin-header.php';

?>

<!-- Main Content -->
<main class="admin-activity-page">
    <section class="section">
        <div class="container">
            <div class="admin-header-actions">
                <h1 class="admin-page-title">
                    <i class="fas fa-history"></i> <?php echo $pageTitle; ?>
                </h1>
                <div class="admin-header-buttons">
                    <button id="export-csv" class="admin-button admin-button-info export-activity-button">
                        <i class="fas fa-download"></i> Export to CSV
                    </button>
                </div>
            </div>
            
            <!-- Filters Toggle Button -->
            <div class="activity-filters-toggle <?php echo $filtersActive ? 'active' : ''; ?>" id="filters-toggle">
                <i class="fas fa-filter"></i> 
                <?php echo $filtersActive ? 'Hide Filters' : 'Show Filters'; ?>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            
            <!-- Filters -->
            <div class="admin-filters activity-filters <?php echo $filtersActive ? 'active' : ''; ?>" id="filters-container">
                <form action="index.php" method="get" class="admin-filter-form">
                    <div class="admin-filter-group">
                        <label for="username" class="admin-filter-label">Admin Username</label>
                        <select id="username" name="username" class="admin-filter-select">
                            <option value="">All Admins</option>
                            <?php foreach ($distinctUsernames as $adminUser): ?>
                            <option value="<?php echo $adminUser['admin_username']; ?>" <?php echo (isset($filters['username']) && $filters['username'] === $adminUser['admin_username']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($adminUser['admin_username']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="activity_type" class="admin-filter-label">Activity Type</label>
                        <select id="activity_type" name="activity_type" class="admin-filter-select">
                            <option value="">All Activities</option>
                            <?php foreach ($distinctActivityTypes as $activityType): ?>
                            <option value="<?php echo $activityType['activity_type']; ?>" <?php echo (isset($filters['activity_type']) && $filters['activity_type'] === $activityType['activity_type']) ? 'selected' : ''; ?>>
                                <?php echo isset(ACTIVITY_TYPES[$activityType['activity_type']]) ? ACTIVITY_TYPES[$activityType['activity_type']] : ucfirst($activityType['activity_type']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="entity_type" class="admin-filter-label">Entity Type</label>
                        <select id="entity_type" name="entity_type" class="admin-filter-select">
                            <option value="">All Entities</option>
                            <?php foreach ($distinctEntityTypes as $entityType): ?>
                                <?php if ($entityType['entity_type'] !== null): ?>
                                <option value="<?php echo $entityType['entity_type']; ?>" <?php echo (isset($filters['entity_type']) && $filters['entity_type'] === $entityType['entity_type']) ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($entityType['entity_type']); ?>
                                </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="ip_address" class="admin-filter-label">IP Address</label>
                        <select id="ip_address" name="ip_address" class="admin-filter-select">
                            <option value="">All IP Addresses</option>
                            <?php foreach ($distinctIPs as $ip): ?>
                            <option value="<?php echo $ip['ip_address']; ?>" <?php echo (isset($filters['ip_address']) && $filters['ip_address'] === $ip['ip_address']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ip['ip_address']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="description" class="admin-filter-label">Description Search</label>
                        <input type="text" id="description" name="description" class="admin-filter-input" 
                               placeholder="Search in descriptions..." 
                               value="<?php echo isset($filters['description']) ? htmlspecialchars($filters['description']) : ''; ?>">
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="date_from" class="admin-filter-label">Date From</label>
                        <input type="date" id="date_from" name="date_from" class="admin-filter-input" value="<?php echo isset($filters['date_from']) ? $filters['date_from'] : ''; ?>">
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="date_to" class="admin-filter-label">Date To</label>
                        <input type="date" id="date_to" name="date_to" class="admin-filter-input" value="<?php echo isset($filters['date_to']) ? $filters['date_to'] : ''; ?>">
                    </div>
                    
                    <div class="admin-filter-actions">
                        <button type="submit" class="admin-button admin-button-primary">
                            <i class="fas fa-search"></i> Apply Filters
                        </button>
                        <a href="index.php" class="admin-button admin-button-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Results Count -->
            <p class="admin-results-count">
                <i class="fas fa-list"></i> Showing <?php echo count($activities['data']); ?> of <?php echo $activities['total_records']; ?> activity logs
                <?php if ($filtersActive): ?>
                <span class="filters-active-badge">Filters Active</span>
                <?php endif; ?>
            </p>
            
            <!-- Activity Table -->
            <div class="admin-table-container">
                <table class="admin-table" id="activity-table">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Admin</th>
                            <th width="10%">Activity</th>
                            <th width="30%">Description</th>
                            <th width="15%">Entity</th>
                            <th width="10%">IP Address</th>
                            <th width="15%">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($activities['data'])): ?>
                        <tr>
                            <td colspan="7" class="admin-table-empty">No activity logs found. Please try a different filter.</td>
                        </tr>
                        <?php else: ?>
                            <?php 
                            $twentyFourHoursAgo = time() - (24 * 60 * 60);
                            foreach ($activities['data'] as $activity): 
                                $isRecent = strtotime($activity['timestamp']) > $twentyFourHoursAgo;
                            ?>
                            <tr class="<?php echo $isRecent ? 'activity-row-fresh' : ''; ?>">
                                <td><?php echo $activity['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($activity['admin_username']); ?></strong>
                                </td>
                                <td>
                                    <span class="activity-badge <?php echo $activity['activity_type']; ?>">
                                        <?php echo isset(ACTIVITY_TYPES[$activity['activity_type']]) ? ACTIVITY_TYPES[$activity['activity_type']] : ucfirst($activity['activity_type']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($activity['description']); ?></td>
                                <td>
                                    <?php if ($activity['entity_type'] && $activity['entity_id']): ?>
                                        <span class="entity-badge">
                                            <?php echo ucfirst($activity['entity_type']); ?>
                                        </span>
                                        #<?php echo $activity['entity_id']; ?>
                                        
                                        <?php if ($activity['entity_type'] === 'weapon'): ?>
                                        <a href="../../public/weapons/detail.php?id=<?php echo $activity['entity_id']; ?>" target="_blank" class="entity-link" title="View Weapon">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <?php elseif ($activity['entity_type'] === 'armor'): ?>
                                        <a href="../../public/armor/detail.php?id=<?php echo $activity['entity_id']; ?>" target="_blank" class="entity-link" title="View Armor">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <?php elseif ($activity['entity_type'] === 'item'): ?>
                                        <a href="../../public/items/detail.php?id=<?php echo $activity['entity_id']; ?>" target="_blank" class="entity-link" title="View Item">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <?php elseif ($activity['entity_type'] === 'monster'): ?>
                                        <a href="../../public/monsters/detail.php?id=<?php echo $activity['entity_id']; ?>" target="_blank" class="entity-link" title="View Monster">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <?php elseif ($activity['entity_type'] === 'map'): ?>
                                        <a href="../../public/maps/detail.php?id=<?php echo $activity['entity_id']; ?>" target="_blank" class="entity-link" title="View Map">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <?php elseif ($activity['entity_type'] === 'doll'): ?>
                                        <a href="../../public/dolls/detail.php?id=<?php echo $activity['entity_id']; ?>" target="_blank" class="entity-link" title="View Doll">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($activity['ip_address']); ?></td>
                                <td>
                                    <span title="<?php echo date('Y-m-d H:i:s', strtotime($activity['timestamp'])); ?>">
                                        <?php echo date('M j, Y, g:i a', strtotime($activity['timestamp'])); ?>
                                    </span>
                                    <?php if ($isRecent): ?>
                                    <span class="recent-badge" title="Recent activity">New</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($activities['total_pages'] > 1): ?>
            <div class="admin-pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="admin-pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($activities['total_pages'], $page + 2);
                
                if ($startPage > 1): ?>
                <a href="?page=1<?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="admin-pagination-link">1</a>
                <?php if ($startPage > 2): ?>
                <span class="admin-pagination-ellipsis">...</span>
                <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="admin-pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
                <?php endfor; ?>
                
                <?php if ($endPage < $activities['total_pages']): ?>
                <?php if ($endPage < $activities['total_pages'] - 1): ?>
                <span class="admin-pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $activities['total_pages']; ?><?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="admin-pagination-link">
                    <?php echo $activities['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $activities['total_pages']): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="admin-pagination-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Activity Stats Section -->
            <div class="admin-stats-section">
                <h3 class="admin-section-title">Activity Statistics</h3>
                <div class="admin-stats-grid">
                    <?php
                    // Get activity counts by type
                    $activityCounts = $db->fetchAll("
                        SELECT activity_type, COUNT(*) as count 
                        FROM admin_activity 
                        GROUP BY activity_type 
                        ORDER BY count DESC
                    ");
                    
                    // Get most active users
                    $activeUsers = $db->fetchAll("
                        SELECT admin_username, COUNT(*) as count 
                        FROM admin_activity 
                        GROUP BY admin_username 
                        ORDER BY count DESC 
                        LIMIT 5
                    ");
                    
                    // Get recent days activity count
                    $recentActivity = $db->fetchAll("
                        SELECT DATE(timestamp) as date, COUNT(*) as count 
                        FROM admin_activity 
                        WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                        GROUP BY DATE(timestamp) 
                        ORDER BY date DESC
                    ");
                    ?>
                    
                    <div class="admin-stat-card">
                        <div class="admin-stat-header">
                            <h3 class="admin-stat-title">Activity by Type</h3>
                            <i class="fas fa-chart-pie admin-stat-icon"></i>
                        </div>
                        <div class="activity-type-chart">
                            <?php foreach ($activityCounts as $count): ?>
                                <?php 
                                $type = $count['activity_type'];
                                $typeName = isset(ACTIVITY_TYPES[$type]) ? ACTIVITY_TYPES[$type] : ucfirst($type);
                                $percentage = round(($count['count'] / $activities['total_records']) * 100);
                                ?>
                                <div class="activity-type-bar">
                                    <div class="activity-type-label">
                                        <span class="activity-badge <?php echo $type; ?>"><?php echo $typeName; ?></span>
                                        <span class="activity-count"><?php echo $count['count']; ?></span>
                                    </div>
                                    <div class="activity-type-progress">
                                        <div class="activity-type-fill <?php echo $type; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="admin-stat-card">
                        <div class="admin-stat-header">
                            <h3 class="admin-stat-title">Most Active Users</h3>
                            <i class="fas fa-users admin-stat-icon"></i>
                        </div>
                        <div class="activity-users-list">
                            <?php if (empty($activeUsers)): ?>
                            <p class="activity-empty">No user activity data available.</p>
                            <?php else: ?>
                                <?php foreach ($activeUsers as $activeUser): ?>
                                <div class="activity-user-item">
                                    <div class="activity-user-info">
                                        <span class="activity-user-name"><?php echo htmlspecialchars($activeUser['admin_username']); ?></span>
                                        <span class="activity-user-count"><?php echo $activeUser['count']; ?> activities</span>
                                    </div>
                                    <a href="?username=<?php echo urlencode($activeUser['admin_username']); ?>" class="activity-user-link">
                                        View <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="admin-stat-card">
                        <div class="admin-stat-header">
                            <h3 class="admin-stat-title">Recent Activity Trend</h3>
                            <i class="fas fa-chart-line admin-stat-icon"></i>
                        </div>
                        <div class="activity-trend">
                            <?php if (empty($recentActivity)): ?>
                            <p class="activity-empty">No recent activity data available.</p>
                            <?php else: ?>
                                <?php 
                                $maxCount = 0;
                                foreach ($recentActivity as $dayActivity) {
                                    $maxCount = max($maxCount, $dayActivity['count']);
                                }
                                
                                foreach ($recentActivity as $dayActivity): 
                                    $height = $maxCount > 0 ? round(($dayActivity['count'] / $maxCount) * 100) : 0;
                                ?>
                                <div class="activity-day">
                                    <div class="activity-day-bar-container">
                                        <div class="activity-day-bar" style="height: <?php echo $height; ?>%"></div>
                                    </div>
                                    <div class="activity-day-count"><?php echo $dayActivity['count']; ?></div>
                                    <div class="activity-day-label"><?php echo date('M j', strtotime($dayActivity['date'])); ?></div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<script>
// Filter toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const filtersToggle = document.getElementById('filters-toggle');
    const filtersContainer = document.getElementById('filters-container');
    
    if (filtersToggle && filtersContainer) {
        filtersToggle.addEventListener('click', function() {
            filtersContainer.classList.toggle('active');
            filtersToggle.classList.toggle('active');
            filtersToggle.innerHTML = filtersContainer.classList.contains('active') 
                ? '<i class="fas fa-filter"></i> Hide Filters <i class="fas fa-chevron-up toggle-icon"></i>' 
                : '<i class="fas fa-filter"></i> Show Filters <i class="fas fa-chevron-down toggle-icon"></i>';
        });
    }
    
    // Export to CSV functionality
    const exportBtn = document.getElementById('export-csv');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            exportTableToCSV('activity_logs.csv');
        });
    }
    
    // Function to export table data to CSV
    function exportTableToCSV(filename) {
        const table = document.getElementById('activity-table');
        let csv = [];
        let rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                // Get text content and clean it up
                let text = cols[j].textContent.trim().replace(/\s+/g, ' ');
                
                // Quote the text if it contains commas or quotes
                if (text.includes(',') || text.includes('"')) {
                    text = '"' + text.replace(/"/g, '""') + '"';
                }
                
                row.push(text);
            }
            
            csv.push(row.join(','));
        }
        
        // Create CSV file and download
        let csvContent = csv.join('\n');
        let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        let link = document.createElement('a');
        
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, filename);
        } else {
            let url = URL.createObjectURL(blob);
            link.href = url;
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
});
</script>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>