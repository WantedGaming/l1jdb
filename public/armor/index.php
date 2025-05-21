<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Armor.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize armor model
$armorModel = new Armor();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : ''; 

// Handle filters
$filters = [];
if (isset($_GET['filter'])) {
    if (!empty($_GET['type'])) {
        $filters['type'] = $_GET['type'];
    }
    
    if (!empty($_GET['material'])) {
        $filters['material'] = $_GET['material'];
    }
    
    if (!empty($_GET['grade'])) {
        $filters['grade'] = $_GET['grade'];
    }

    if (!empty($_GET['has_set'])) {
        $filters['has_set'] = $_GET['has_set'];
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $armors = $armorModel->searchArmor($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Armor";
} elseif (!empty($filters)) {
    $armors = $armorModel->filterArmor($filters, $page);
    $pageTitle = "Filtered Armor";
} else {
    $armors = $armorModel->getAllArmor($page);
    $pageTitle = "All Armor";
}

// Get filter options for the filter form
$armorTypes = $armorModel->getArmorTypes();
$armorMaterials = $armorModel->getArmorMaterials();
$armorGrades = $armorModel->getArmorGrades();

// Include header
$heroTitle = "Armor Database";
$heroSubtitle = "Explore all armor available in the game world";
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
                        <label for="type" class="filter-label">Armor Type</label>
                        <select id="type" name="type" class="filter-select">
                            <option value="">All Types</option>
                            <?php foreach ($armorTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($filters['type']) && $filters['type'] === $type) ? 'selected' : ''; ?>>
                                <?php echo $type; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="material" class="filter-label">Material</label>
                        <select id="material" name="material" class="filter-select">
                            <option value="">All Materials</option>
                            <?php foreach ($armorMaterials as $material): ?>
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
                            <?php foreach ($armorGrades as $grade): ?>
                            <option value="<?php echo $grade; ?>" <?php echo (isset($filters['grade']) && $filters['grade'] === $grade) ? 'selected' : ''; ?>>
                                <?php echo $grade; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="has_set" class="filter-label">Set Items</label>
                        <select id="has_set" name="has_set" class="filter-select">
                            <option value="">All Items</option>
                            <option value="1" <?php echo (isset($filters['has_set']) && $filters['has_set'] == 1) ? 'selected' : ''; ?>>Set Items Only</option>
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
                Showing <?php echo count($armors['data']); ?> of <?php echo $armors['total_records']; ?> armor pieces
            </p>
            
            <!-- Armor Grid -->
            <div class="card-grid">
                <?php if (empty($armors['data'])): ?>
                <div class="no-results">
                    <p>No armor found. Please try a different search or filter.</p>
                </div>
                <?php else: ?>
                    <?php foreach ($armors['data'] as $armor): ?>
                    <div class="card item-card">
                        <a href="detail.php?id=<?php echo $armor['item_id']; ?>" class="card-link-overlay"></a>
                        <div class="card-header">
                            <h3 class="card-header-title"><?php echo $armor['type']; ?></h3>
                            <span class="card-badge"><?php echo $armor['itemGrade']; ?></span>
                        </div>
                        <div class="card-img-container">
                            <img src="<?php echo $armorModel->getArmorIconUrl($armor['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($armor['desc_en'])); ?>" class="card-img">
                        </div>
                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars(cleanItemName($armor['desc_en'])); ?></h3>
                            <div class="card-stats">
                                <div class="card-stat">
                                    <span class="card-stat-label">AC:</span>
                                    <span class="card-stat-value"><?php echo $armor['ac']; ?></span>
                                </div>
                                <div class="card-stat">
                                    <span class="card-stat-label">Material:</span>
                                    <span class="card-stat-value"><?php echo formatMaterial($armor['material']); ?></span>
                                </div>
                                <?php if ($armor['Set_Id'] > 0): ?>
                                <div class="card-stat">
                                    <span class="card-stat-label">Set:</span>
                                    <span class="card-stat-value">Yes</span>
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
            <?php if ($armors['total_pages'] > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($armors['total_pages'], $page + 2);
                
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
                
                <?php if ($endPage < $armors['total_pages']): ?>
                <?php if ($endPage < $armors['total_pages'] - 1): ?>
                <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $armors['total_pages']; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">
                    <?php echo $armors['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $armors['total_pages']): ?>
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