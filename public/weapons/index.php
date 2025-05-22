<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Weapon.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize weapons model
$weaponsModel = new Weapon();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : ''; // Changed from 'search' to 'q' to match the hero search form

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
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $weapons = $weaponsModel->searchWeapons($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Weapons";
} elseif (!empty($filters)) {
    $weapons = $weaponsModel->filterWeapons($filters, $page);
    $pageTitle = "Filtered Weapons";
} else {
    $weapons = $weaponsModel->getAllWeapons($page);
    $pageTitle = "All Weapons";
}

// Get filter options for the filter form
$weaponTypes = $weaponsModel->getWeaponTypes();
$weaponMaterials = $weaponsModel->getWeaponMaterials();
$weaponGrades = $weaponsModel->getWeaponGrades();

// Include header
$heroTitle = "Weapons Database";
$heroSubtitle = "Explore all weapons available in the game world";
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
                        <label for="type" class="filter-label">Weapon Type</label>
                        <select id="type" name="type" class="filter-select">
                            <option value="">All Types</option>
                            <?php foreach ($weaponTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($filters['type']) && $filters['type'] === $type) ? 'selected' : ''; ?>>
                                <?php echo formatWeaponType($type); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="material" class="filter-label">Material</label>
                        <select id="material" name="material" class="filter-select">
                            <option value="">All Materials</option>
                            <?php foreach ($weaponMaterials as $material): ?>
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
                            <?php foreach ($weaponGrades as $grade): ?>
                            <option value="<?php echo $grade; ?>" <?php echo (isset($filters['grade']) && $filters['grade'] === $grade) ? 'selected' : ''; ?>>
                                <?php echo formatGrade($grade); ?>
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
                Showing <?php echo count($weapons['data']); ?> of <?php echo $weapons['total_records']; ?> weapons
            </p>
            
            <!-- Weapons Grid -->
            <div class="card-grid">
                <?php if (empty($weapons['data'])): ?>
                <div class="no-results">
                    <p>No weapons found. Please try a different search or filter.</p>
                </div>
                <?php else: ?>
                    <?php foreach ($weapons['data'] as $weapon): ?>
                    <div class="card item-card">
                        <a href="detail.php?id=<?php echo $weapon['item_id']; ?>" class="card-link-overlay"></a>
                        <div class="card-header">
                            <h3 class="card-header-title"><?php echo formatWeaponType($weapon['type']); ?></h3>
                            <span class="card-badge"><?php echo formatGrade($weapon['itemGrade']); ?></span>
                        </div>
                        <div class="card-img-container">
                            <img src="<?php echo getItemIconUrl($weapon['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($weapon['desc_en'])); ?>" class="card-img">
                        </div>
                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars(cleanItemName($weapon['desc_en'])); ?></h3>
                            <div class="card-stats">
                                <div class="card-stat">
                                    <span class="card-stat-label">Damage:</span>
                                    <span class="card-stat-value"><?php echo formatDamageRange($weapon['dmg_small'], $weapon['dmg_large']); ?></span>
                                </div>
                                <div class="card-stat">
                                    <span class="card-stat-label">Material:</span>
                                    <span class="card-stat-value"><?php echo formatMaterial($weapon['material']); ?></span>
                                </div>
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
            <?php if ($weapons['total_pages'] > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($weapons['total_pages'], $page + 2);
                
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
                
                <?php if ($endPage < $weapons['total_pages']): ?>
                <?php if ($endPage < $weapons['total_pages'] - 1): ?>
                <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $weapons['total_pages']; ?><?php echo !empty($searchTerm) ? '&q=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="pagination-link">
                    <?php echo $weapons['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $weapons['total_pages']): ?>
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