<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Item.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize item model
$itemModel = new Item();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

// Handle filters
$filters = [];
if (isset($_GET['filter'])) {
    if (!empty($_GET['item_type'])) {
        $filters['item_type'] = $_GET['item_type'];
    }
    
    if (!empty($_GET['use_type'])) {
        $filters['use_type'] = $_GET['use_type'];
    }
    
    if (!empty($_GET['material'])) {
        $filters['material'] = $_GET['material'];
    }
    
    if (!empty($_GET['grade'])) {
        $filters['grade'] = $_GET['grade'];
    }
    
    if (!empty($_GET['max_charge_count']) && $_GET['max_charge_count'] > 0) {
        $filters['max_charge_count'] = $_GET['max_charge_count'];
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $items = $itemModel->searchItems($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Items";
} elseif (!empty($filters)) {
    $items = $itemModel->filterItems($filters, $page);
    $pageTitle = "Filtered Items";
} else {
    $items = $itemModel->getAllItems($page);
    $pageTitle = "All Items";
}

// Get filter options for the filter form
$itemTypes = $itemModel->getItemTypes();
$itemUseTypes = $itemModel->getItemUseTypes();
$itemMaterials = $itemModel->getItemMaterials();
$itemGrades = $itemModel->getItemGrades();

// Include header
$heroTitle = "Items Database";
$heroSubtitle = "Explore all items available in the game world";
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
            
            <!-- Filters - Modified for single row layout -->
            <div class="filters">
                <form action="index.php" method="get" class="filter-form filter-form-inline">
                    <div class="filter-group">
                        <label for="item_type" class="filter-label">Item Type</label>
                        <select id="item_type" name="item_type" class="filter-select">
                            <option value="">All Types</option>
                            <?php foreach ($itemTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($filters['item_type']) && $filters['item_type'] === $type) ? 'selected' : ''; ?>>
                                <?php echo ucfirst(strtolower(str_replace('_', ' ', $type))); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="use_type" class="filter-label">Use Type</label>
                        <select id="use_type" name="use_type" class="filter-select">
                            <option value="">All Use Types</option>
                            <?php foreach ($itemUseTypes as $useType): ?>
                            <option value="<?php echo $useType; ?>" <?php echo (isset($filters['use_type']) && $filters['use_type'] === $useType) ? 'selected' : ''; ?>>
                                <?php echo ucfirst(strtolower(str_replace('_', ' ', $useType))); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="material" class="filter-label">Material</label>
                        <select id="material" name="material" class="filter-select">
                            <option value="">All Materials</option>
                            <?php foreach ($itemMaterials as $material): ?>
                            <option value="<?php echo $material; ?>" <?php echo (isset($filters['material']) && $filters['material'] === $material) ? 'selected' : ''; ?>>
                                <?php echo formatMaterial($material); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="grade" class="filter-label">Grade</label>
                        <select id="grade" name="grade" class="filter-select">
                            <option value="">All Grades</option>
                            <?php foreach ($itemGrades as $grade): ?>
                            <option value="<?php echo $grade; ?>" <?php echo (isset($filters['grade']) && $filters['grade'] === $grade) ? 'selected' : ''; ?>>
                                <?php echo formatArmorGrade($grade); ?>
                            </option>
                            <?php endforeach; ?>
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
                Showing <?php echo count($items['data']); ?> of <?php echo $items['total_records']; ?> items
            </p>
            
            <!-- Items Grid -->
            <div class="card-grid">
                <?php if (empty($items['data'])): ?>
                <div class="no-results">
                    <p>No items found. Please try a different search or filter.</p>
                </div>
                <?php else: ?>
                    <?php foreach ($items['data'] as $item): ?>
                    <div class="card item-card">
                        <a href="detail.php?id=<?php echo $item['item_id']; ?>" class="card-link-overlay"></a>
                        <div class="card-header">
                            <h3 class="card-header-title"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['item_type']))); ?></h3>
                            <span class="card-badge"><?php echo formatArmorGrade($item['itemGrade']); ?></span>
                        </div>
                        <div class="card-img-container">
                            <img src="<?php echo getItemIconUrl($item['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?>" class="card-img">
                        </div>
                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?></h3>
                            <div class="card-stats">
                                <div class="card-stat">
                                    <span class="card-stat-label">Use Type:</span>
                                    <span class="card-stat-value">
                                        <?php echo ucfirst(strtolower(str_replace('_', ' ', $item['use_type']))); ?>
                                    </span>
                                </div>
                                <div class="card-stat">
                                    <span class="card-stat-label">Material:</span>
                                    <span class="card-stat-value"><?php echo formatMaterial($item['material']); ?></span>
                                </div>
                                <?php if (isset($item['max_charge_count']) && $item['max_charge_count'] > 0): ?>
                                <div class="card-stat">
                                    <span class="card-stat-label">Charges:</span>
                                    <span class="card-stat-value"><?php echo $item['max_charge_count']; ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
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
            <?php if ($items['total_pages'] > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($items['total_pages'], $page + 2);
                
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
                
                <?php if ($endPage < $items['total_pages']): ?>
                <?php if ($endPage < $items['total_pages'] - 1): ?>
                <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $items['total_pages']; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">
                    <?php echo $items['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $items['total_pages']): ?>
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