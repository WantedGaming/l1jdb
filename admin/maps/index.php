<?php
// Admin maps management page
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

// Initialize map model
$mapModel = new Map();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Handle filters
$filters = [];
if (isset($_GET['filter'])) {
    if (!empty($_GET['underwater'])) {
        $filters['underwater'] = $_GET['underwater'];
    }
    
    if (!empty($_GET['markable'])) {
        $filters['markable'] = $_GET['markable'];
    }
    
    if (!empty($_GET['teleportable'])) {
        $filters['teleportable'] = $_GET['teleportable'];
    }
    
    if (!empty($_GET['dungeon'])) {
        $filters['dungeon'] = $_GET['dungeon'];
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $maps = $mapModel->searchMaps($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Maps Management";
} elseif (!empty($filters)) {
    $maps = $mapModel->filterMaps($filters, $page);
    $pageTitle = "Filtered Maps - Maps Management";
} else {
    $maps = $mapModel->getAllMaps($page);
    $pageTitle = "Maps Management";
}

// Handle delete action
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $mapId = (int)$_POST['id'];
    $map = $mapModel->getMapById($mapId);
    
    if ($map) {
        if ($mapModel->deleteMap($mapId)) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Log activity with null-safe username
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'delete',
                "Deleted map: {$map['locationname']} (ID: $mapId)",
                'map',
                $mapId
            );
            
            $successMessage = "Map '{$map['locationname']}' has been deleted successfully.";
        } else {
            $errorMessage = "Failed to delete map. Please try again.";
        }
    } else {
        $errorMessage = "Map not found.";
    }
}

// Include admin header
include '../../includes/admin-header.php';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <div class="admin-header-actions">
                <h1 class="admin-page-title"><?php echo $pageTitle; ?></h1>
                <a href="create.php" class="admin-button admin-button-primary">
                    <i class="fas fa-plus"></i> Add New Map
                </a>
            </div>
            
            <?php if (isset($successMessage)): ?>
            <div class="admin-alert admin-alert-success">
                <?php echo $successMessage; ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Map has been deleted successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                New map has been created successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Map has been updated successfully.
            </div>
            <?php endif; ?>
            
            <!-- Search and Filters -->
            <div class="admin-filters">
                <form action="index.php" method="get" class="admin-filter-form">
                    <div class="admin-filter-group">
                        <label for="search" class="admin-filter-label">Search</label>
                        <input type="text" id="search" name="search" class="admin-filter-input" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search maps...">
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="underwater" class="admin-filter-label">Underwater</label>
                        <select id="underwater" name="underwater" class="admin-filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['underwater']) && $filters['underwater'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['underwater']) && $filters['underwater'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="markable" class="admin-filter-label">Markable</label>
                        <select id="markable" name="markable" class="admin-filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['markable']) && $filters['markable'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['markable']) && $filters['markable'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="teleportable" class="admin-filter-label">Teleportable</label>
                        <select id="teleportable" name="teleportable" class="admin-filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['teleportable']) && $filters['teleportable'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['teleportable']) && $filters['teleportable'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="dungeon" class="admin-filter-label">Dungeon</label>
                        <select id="dungeon" name="dungeon" class="admin-filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['dungeon']) && $filters['dungeon'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['dungeon']) && $filters['dungeon'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-actions">
                        <input type="hidden" name="filter" value="1">
                        <button type="submit" class="admin-button admin-button-primary">Apply Filters</button>
                        <a href="index.php" class="admin-button admin-button-secondary">Reset</a>
                    </div>
                </form>
            </div>
            
            <!-- Results Count -->
            <p class="admin-results-count">
                Showing <?php echo count($maps['data']); ?> of <?php echo $maps['total_records']; ?> maps
            </p>
            
            <!-- Maps Table -->
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Korean</th>
                            <th>Dungeon</th>
                            <th>Underwater</th>
                            <th>Teleportable</th>
                            <th>Markable</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($maps['data'])): ?>
                        <tr>
                            <td colspan="9" class="admin-table-empty">No maps found.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($maps['data'] as $map): ?>
                            <tr>
                                <td><?php echo $map['mapid']; ?></td>
                                <td>
                                    <img src="<?php echo getMapIconUrl($map['pngId']); ?>" alt="Map Icon" class="admin-table-img-sm">
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $map['mapid']; ?>" class="admin-link">
                                        <?php echo htmlspecialchars($map['locationname'] ?? "Map #" . $map['mapid']); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($map['desc_kr'] ?? 'N/A'); ?></td>
                                <td><?php echo formatYesNo($map['dungeon']); ?></td>
                                <td><?php echo formatYesNo($map['underwater']); ?></td>
                                <td><?php echo formatYesNo($map['teleportable']); ?></td>
                                <td><?php echo formatYesNo($map['markable']); ?></td>
                                <td class="admin-actions">
                                    <a href="edit.php?id=<?php echo $map['mapid']; ?>" class="admin-action admin-action-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="../public/maps/detail.php?id=<?php echo $map['mapid']; ?>" class="admin-action admin-action-view" title="View" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="index.php" method="post" class="admin-delete-form" onsubmit="return confirm('Are you sure you want to delete this map?');">
                                        <input type="hidden" name="id" value="<?php echo $map['mapid']; ?>">
                                        <button type="submit" name="delete" class="admin-action admin-action-delete" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($maps['total_pages'] > 1): ?>
            <div class="admin-pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($maps['total_pages'], $page + 2);
                
                if ($startPage > 1): ?>
                <a href="?page=1<?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">1</a>
                <?php if ($startPage > 2): ?>
                <span class="admin-pagination-ellipsis">...</span>
                <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
                <?php endfor; ?>
                
                <?php if ($endPage < $maps['total_pages']): ?>
                <?php if ($endPage < $maps['total_pages'] - 1): ?>
                <span class="admin-pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $maps['total_pages']; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">
                    <?php echo $maps['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $maps['total_pages']): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Include footer
include '../../includes/admin-footer.php';
?> 