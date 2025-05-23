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

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

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
    $pageTitle = "Search Results for \"$searchTerm\" - Maps";
} elseif (!empty($filters)) {
    $maps = $mapModel->filterMaps($filters, $page);
    $pageTitle = "Filtered Maps";
} else {
    $maps = $mapModel->getAllMaps($page);
    $pageTitle = "All Maps";
}

// Include header
$heroTitle = "Maps Database";
$heroSubtitle = "Explore all maps available in the game world";
include '../../includes/header.php';
include '../../includes/hero.php';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <div class="category-header">
                <h2 class="category-title"><?php echo $pageTitle; ?></h2>
            </div>
            
            <!-- Filters -->
            <div class="filters">
                <form action="index.php" method="get" class="filter-form filter-form-inline">
                    <div class="filter-group">
                        <label for="underwater" class="filter-label">Underwater</label>
                        <select id="underwater" name="underwater" class="filter-select">
                            <option value="all">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['underwater']) && $filters['underwater'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['underwater']) && $filters['underwater'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="markable" class="filter-label">Can Bookmark</label>
                        <select id="markable" name="markable" class="filter-select">
                            <option value="all">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['markable']) && $filters['markable'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['markable']) && $filters['markable'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="teleportable" class="filter-label">Can Teleport</label>
                        <select id="teleportable" name="teleportable" class="filter-select">
                            <option value="all">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['teleportable']) && $filters['teleportable'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['teleportable']) && $filters['teleportable'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="dungeon" class="filter-label">Dungeon</label>
                        <select id="dungeon" name="dungeon" class="filter-select">
                            <option value="all">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['dungeon']) && $filters['dungeon'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['dungeon']) && $filters['dungeon'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-actions">
                        <input type="hidden" name="filter" value="1">
                        <button type="submit" class="filter-button">Apply Filters</button>
                        <a href="index.php" class="filter-reset">Reset</a>
                    </div>
                </form>
            </div>
            
            <!-- Results Count -->
            <p class="results-count">
                Showing <?php echo count($maps['data']); ?> of <?php echo $maps['total_records']; ?> maps
            </p>
            
            <!-- Maps Grid -->
            <div class="card-grid">
                <?php if (empty($maps['data'])): ?>
                <div class="no-results">
                    <p>No maps found. Please try a different search or filter.</p>
                </div>
                <?php else: ?>
                    <?php foreach ($maps['data'] as $map): ?>
                    <div class="card item-card">
                        <a href="detail.php?id=<?php echo $map['mapid']; ?>" class="card-link-overlay"></a>
                        <div class="card-header">
                            <h3 class="card-header-title"><?php echo htmlspecialchars($map['locationname'] ?? 'Unknown Map'); ?></h3>
                            <span class="card-badge"><?php echo $map['dungeon'] == 1 ? 'Dungeon' : 'Field'; ?></span>
                        </div>
                        <div class="card-img-container">
                            <img src="<?php echo getMapIconUrl($map['pngId']); ?>" alt="<?php echo htmlspecialchars($map['locationname'] ?? 'Unknown Map'); ?>" class="card-img">
                        </div>
                        <div class="card-content">
                            
                        </div>
                        <div class="card-footer">
                            <span class="card-category">View Details</span>
                            <div class="card-indicator">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($maps['total_pages'] > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($maps['total_pages'], $page + 2);
                
                if ($startPage > 1): ?>
                <a href="?page=1<?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">1</a>
                <?php if ($startPage > 2): ?>
                <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
                <?php endfor; ?>
                
                <?php if ($endPage < $maps['total_pages']): ?>
                <?php if ($endPage < $maps['total_pages'] - 1): ?>
                <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $maps['total_pages']; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">
                    <?php echo $maps['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $maps['total_pages']): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Include footer
include '../../includes/footer.php';
?> 