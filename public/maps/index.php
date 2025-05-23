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
    
    if (!empty($_GET['map_type'])) {
        $filters['map_type'] = $_GET['map_type'];
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

// Get unique map types based on existing data
$mapTypes = [
    ['type' => 'DUNGEON'],
    ['type' => 'FIELD'],
    ['type' => 'UNDERWATER'],
    ['type' => 'SPECIAL']
];

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
            <!-- Page Header -->
            <div class="category-header">
                <h2 class="category-title"><?php echo $pageTitle; ?></h2>
                <p class="category-description">
                    Browse through all available maps, filter by properties, and discover new locations to explore.
                </p>
            </div>
            
            <!-- Search Bar -->
            <div class="search-container" style="margin-bottom: var(--spacing-xl);">
                <form action="index.php" method="get" class="search-form">
                    <input type="text" 
                           name="q" 
                           class="search-input" 
                           placeholder="Search maps by name or location..." 
                           value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
            
            <!-- Filters -->
            <div class="filters">
                <form action="index.php" method="get" class="filter-form filter-form-inline">
                    <div class="filter-group">
                        <label for="map_type" class="filter-label">Map Type</label>
                        <select id="map_type" name="map_type" class="filter-select">
                            <option value="">All Types</option>
                            <?php foreach ($mapTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type['type']); ?>" 
                                    <?php echo (isset($filters['map_type']) && $filters['map_type'] === $type['type']) ? 'selected' : ''; ?>>
                                <?php echo formatMapType($type['type']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="dungeon" class="filter-label">Dungeon</label>
                        <select id="dungeon" name="dungeon" class="filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['dungeon']) && $filters['dungeon'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['dungeon']) && $filters['dungeon'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="underwater" class="filter-label">Underwater</label>
                        <select id="underwater" name="underwater" class="filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['underwater']) && $filters['underwater'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['underwater']) && $filters['underwater'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="markable" class="filter-label">Can Bookmark</label>
                        <select id="markable" name="markable" class="filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['markable']) && $filters['markable'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['markable']) && $filters['markable'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="teleportable" class="filter-label">Can Teleport</label>
                        <select id="teleportable" name="teleportable" class="filter-select">
                            <option value="">All Maps</option>
                            <option value="yes" <?php echo (isset($filters['teleportable']) && $filters['teleportable'] === 'yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="no" <?php echo (isset($filters['teleportable']) && $filters['teleportable'] === 'no') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="filter-actions">
                        <input type="hidden" name="filter" value="1">
                        <button type="submit" class="filter-button">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                        <a href="index.php" class="filter-reset">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Results Summary -->
            <div class="results-summary">
                <p class="results-count">
                    <i class="fas fa-map"></i> 
                    Showing <?php echo number_format(count($maps['data'])); ?> of <?php echo number_format($maps['total_records']); ?> maps
                    <?php if (!empty($searchTerm)): ?>
                        for "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>"
                    <?php endif; ?>
                </p>
                
                <?php if (!empty($filters)): ?>
                <div class="active-filters">
                    <span class="filter-label">Active filters:</span>
                    <?php foreach ($filters as $key => $value): ?>
                        <span class="active-filter-tag">
                            <?php 
                            $filterLabels = [
                                'map_type' => 'Type: ' . formatMapType($value),
                                'dungeon' => 'Dungeon: ' . ucfirst($value),
                                'underwater' => 'Underwater: ' . ucfirst($value),
                                'markable' => 'Bookmarkable: ' . ucfirst($value),
                                'teleportable' => 'Teleportable: ' . ucfirst($value)
                            ];
                            echo $filterLabels[$key] ?? ucfirst($key) . ': ' . ucfirst($value);
                            ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Maps Grid -->
            <div class="card-grid">
                <?php if (empty($maps['data'])): ?>
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3>No Maps Found</h3>
                    <p>No maps match your current search criteria. Try adjusting your filters or search terms.</p>
                    <a href="index.php" class="filter-button">
                        <i class="fas fa-refresh"></i> View All Maps
                    </a>
                </div>
                <?php else: ?>
                    <?php foreach ($maps['data'] as $map): 
                        // Determine map type based on existing fields - FIXED LOGIC
                        if ($map['dungeon'] == 1) {
                            $mapType = 'DUNGEON';
                        } elseif ($map['underwater'] == 1) {
                            $mapType = 'UNDERWATER';
                        } elseif (isset($map['beginZone']) && ($map['beginZone'] || $map['redKnightZone'] || $map['ruunCastleZone'])) {
                            $mapType = 'SPECIAL';
                        } else {
                            $mapType = 'FIELD';
                        }
                    ?>
                    <div class="card item-card">
                        <a href="detail.php?id=<?php echo $map['mapid']; ?>" class="card-link-overlay"></a>
                        
                        <!-- Card Header -->
                        <div class="card-header">
                            <h3 class="card-header-title">
                                <?php echo htmlspecialchars($map['locationname'] ?? "Map #" . $map['mapid']); ?>
                            </h3>
                            <span class="card-badge <?php echo $map['dungeon'] == 1 ? 'badge-dungeon' : 'badge-field'; ?>">
                                <?php echo $map['dungeon'] == 1 ? 'Dungeon' : 'Field'; ?>
                            </span>
                        </div>
                        
                        <!-- Card Image -->
                        <div class="card-img-container">
                            <img src="<?php echo getMapIconUrl($map['pngId']); ?>" 
                                 alt="<?php echo htmlspecialchars($map['locationname'] ?? "Map #" . $map['mapid']); ?>" 
                                 class="card-img">
                        </div>
                        
                        <!-- Card Content -->
                        <div class="card-content">
                            <div class="card-stats">
                                <div class="card-stat">
                                    <span class="card-stat-label">Map ID</span>
                                    <span class="card-stat-value"><?php echo $map['mapid']; ?></span>
                                </div>
                                <div class="card-stat">
                                    <span class="card-stat-label">Type</span>
                                    <span class="card-stat-value"><?php echo formatMapType($mapType); ?></span>
                                </div>
                                <?php if (isset($map['monster_amount']) && $map['monster_amount'] > 0): ?>
                                <div class="card-stat">
                                    <span class="card-stat-label">Monsters</span>
                                    <span class="card-stat-value"><?php echo number_format($map['monster_amount'], 1); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if ($map['underwater']): ?>
                                <div class="card-stat">
                                    <span class="card-stat-label">Special</span>
                                    <span class="card-stat-value water-badge">
                                        <i class="fas fa-water"></i> Underwater
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Map Properties -->
                            <div class="card-properties">
                                <?php if ($map['markable']): ?>
                                <span class="property-tag property-positive">
                                    <i class="fas fa-bookmark"></i> Bookmarkable
                                </span>
                                <?php endif; ?>
                                
                                <?php if ($map['teleportable']): ?>
                                <span class="property-tag property-positive">
                                    <i class="fas fa-magic"></i> Teleportable
                                </span>
                                <?php endif; ?>
                                
                                <?php if (!$map['markable'] && !$map['teleportable']): ?>
                                <span class="property-tag property-neutral">
                                    <i class="fas fa-walking"></i> Walking Only
                                </span>
                                <?php endif; ?>
                                
                                <!-- Add special zone indicators -->
                                <?php if (isset($map['beginZone']) && $map['beginZone']): ?>
                                <span class="property-tag property-positive">
                                    <i class="fas fa-baby"></i> Beginner
                                </span>
                                <?php endif; ?>
                                
                                <?php if (isset($map['redKnightZone']) && $map['redKnightZone']): ?>
                                <span class="property-tag property-positive">
                                    <i class="fas fa-chess-knight"></i> Red Knight
                                </span>
                                <?php endif; ?>
                                
                                <?php if (isset($map['ruunCastleZone']) && $map['ruunCastleZone']): ?>
                                <span class="property-tag property-positive">
                                    <i class="fas fa-castle"></i> Ruun Castle
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <span class="card-category">
                                <i class="fas fa-info-circle"></i> View Details
                            </span>
                            <div class="card-indicator">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($maps['total_pages'] > 1): ?>
            <nav class="pagination-nav" aria-label="Maps pagination">
                <div class="pagination">
                    <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" 
                       class="pagination-link pagination-prev" 
                       aria-label="Previous page">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                    <?php endif; ?>
                    
                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($maps['total_pages'], $page + 2);
                    
                    if ($startPage > 1): ?>
                    <a href="?page=1<?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" 
                       class="pagination-link">1</a>
                    <?php if ($startPage > 2): ?>
                    <span class="pagination-ellipsis">...</span>
                    <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?page=<?php echo $i; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" 
                       class="pagination-link <?php echo $i === $page ? 'active' : ''; ?>"
                       <?php if ($i === $page): ?>aria-current="page"<?php endif; ?>>
                        <?php echo $i; ?>
                    </a>
                    <?php endfor; ?>
                    
                    <?php if ($endPage < $maps['total_pages']): ?>
                    <?php if ($endPage < $maps['total_pages'] - 1): ?>
                    <span class="pagination-ellipsis">...</span>
                    <?php endif; ?>
                    <a href="?page=<?php echo $maps['total_pages']; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" 
                       class="pagination-link">
                        <?php echo $maps['total_pages']; ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($page < $maps['total_pages']): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" 
                       class="pagination-link pagination-next"
                       aria-label="Next page">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php endif; ?>
                </div>
                
                <div class="pagination-info">
                    <span>Page <?php echo $page; ?> of <?php echo $maps['total_pages']; ?></span>
                </div>
            </nav>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Include footer
include '../../includes/footer.php';
?>