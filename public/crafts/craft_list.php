<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/functions.php';

// Initialize Database
$db = Database::getInstance();

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = ITEMS_PER_PAGE;
$offset = ($page - 1) * $perPage;

// Filtering
$filters = [];
$filterSql = '';
$params = [];

// Grade filter
if (isset($_GET['grade']) && !empty($_GET['grade'])) {
    $craftIds = [];
    $grades = explode(',', $_GET['grade']);
    
    // Get craft_ids that produce items of the selected grades
    foreach ($grades as $grade) {
        // Search in weapon table
        $weaponResults = $db->fetchAll(
            "SELECT ci.craft_id FROM craft_info ci 
             JOIN weapon w ON ci.output_name_id = w.item_id 
             WHERE w.itemGrade = ?",
            [$grade]
        );
        
        // Search in armor table
        $armorResults = $db->fetchAll(
            "SELECT ci.craft_id FROM craft_info ci 
             JOIN armor a ON ci.output_name_id = a.item_id 
             WHERE a.itemGrade = ?",
            [$grade]
        );
        
        // Search in etcitem table
        $etcResults = $db->fetchAll(
            "SELECT ci.craft_id FROM craft_info ci 
             JOIN etcitem e ON ci.output_name_id = e.item_id 
             WHERE e.itemGrade = ?",
            [$grade]
        );
        
        // Combine results
        foreach (array_merge($weaponResults, $armorResults, $etcResults) as $result) {
            $craftIds[] = $result['craft_id'];
        }
    }
    
    if (!empty($craftIds)) {
        $placeholders = implode(',', array_fill(0, count($craftIds), '?'));
        $filterSql .= " AND ci.craft_id IN ($placeholders)";
        $params = array_merge($params, $craftIds);
        $filters['grade'] = $_GET['grade'];
    }
}

// Success rate filter
if (isset($_GET['min_success']) && !empty($_GET['min_success'])) {
    $minSuccess = (int)$_GET['min_success'] * 10000; // Convert to internal format
    $filterSql .= " AND ci.probability_million >= ?";
    $params[] = $minSuccess;
    $filters['min_success'] = $_GET['min_success'];
}

if (isset($_GET['max_success']) && !empty($_GET['max_success'])) {
    $maxSuccess = (int)$_GET['max_success'] * 10000; // Convert to internal format
    $filterSql .= " AND ci.probability_million <= ?";
    $params[] = $maxSuccess;
    $filters['max_success'] = $_GET['max_success'];
}

// Level filter
if (isset($_GET['min_level']) && !empty($_GET['min_level'])) {
    $filterSql .= " AND bcc.min_level >= ?";
    $params[] = $_GET['min_level'];
    $filters['min_level'] = $_GET['min_level'];
}

if (isset($_GET['max_level']) && !empty($_GET['max_level'])) {
    $filterSql .= " AND bcc.max_level <= ?";
    $params[] = $_GET['max_level'];
    $filters['max_level'] = $_GET['max_level'];
}

// Search filter
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $filterSql .= " AND (ci.name LIKE ? OR ci.desc_kr LIKE ?)";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $filters['search'] = $_GET['search'];
}

// Count total crafts for pagination
$countQuery = "SELECT COUNT(*) as total FROM craft_info ci 
               JOIN bin_craft_common bcc ON ci.craft_id = bcc.craft_id 
               WHERE 1=1 $filterSql";
$totalResults = $db->fetchOne($countQuery, $params);
$totalPages = ceil($totalResults['total'] / $perPage);

// Get crafts with pagination
$query = "SELECT ci.*, bcc.min_level, bcc.max_level, bcc.outputs_success 
          FROM craft_info ci 
          JOIN bin_craft_common bcc ON ci.craft_id = bcc.craft_id 
          WHERE 1=1 $filterSql 
          ORDER BY ci.probability_million DESC 
          LIMIT $perPage OFFSET $offset";
$crafts = $db->fetchAll($query, $params);

// Function to get item name and icon by id
function getOutputItemDetails($craftOutputs, $db) {
    if (empty($craftOutputs)) return null;
    
    $outputs = json_decode($craftOutputs, true);
    if (empty($outputs)) return null;
    
    // Get the first output item (main result)
    $firstOutput = reset($outputs);
    $itemId = isset($firstOutput['id']) ? $firstOutput['id'] : 0;
    
    // Try to find in weapon table
    $item = $db->fetchOne("SELECT item_id, desc_en, iconId, itemGrade FROM weapon WHERE item_id = ?", [$itemId]);
    
    if (!$item) {
        // Try armor table
        $item = $db->fetchOne("SELECT item_id, desc_en, iconId, itemGrade FROM armor WHERE item_id = ?", [$itemId]);
    }
    
    if (!$item) {
        // Try etcitem table
        $item = $db->fetchOne("SELECT item_id, desc_en, iconId, itemGrade FROM etcitem WHERE item_id = ?", [$itemId]);
    }
    
    if ($item) {
        $item['cleanName'] = cleanItemName($item['desc_en']);
    }
    
    return $item;
}

// Get unique grades for filter
$grades = $db->fetchAll("
    SELECT DISTINCT itemGrade FROM (
        SELECT w.itemGrade FROM craft_info ci 
        JOIN weapon w ON ci.output_name_id = w.item_id
        UNION
        SELECT a.itemGrade FROM craft_info ci 
        JOIN armor a ON ci.output_name_id = a.item_id
        UNION
        SELECT e.itemGrade FROM craft_info ci 
        JOIN etcitem e ON ci.output_name_id = e.item_id
    ) AS grades
    ORDER BY FIELD(itemGrade, 'ONLY', 'MYTH', 'LEGEND', 'HERO', 'RARE', 'ADVANC', 'NORMAL')
");

// Page title
$pageTitle = "Crafting Recipes";

// Include header
include_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/header.php';

// Include hero section
include_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/hero.php';

// Include crafting CSS
$craftingCssPath = $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/assets/css/crafting.css';
if (file_exists($craftingCssPath)) {
    $craftingCss = '<style>' . file_get_contents($craftingCssPath) . '</style>';
    echo $craftingCss;
}
?>

<div class="section crafting-section">
    <div class="container">
        <h1 class="section-title">Crafting Recipes</h1>
        
        <!-- Filters -->
        <div class="filters">
            <form action="" method="get" class="filter-form-inline">
                <div class="filter-group">
                    <label for="search" class="filter-label">Search</label>
                    <input type="text" name="search" id="search" class="filter-input" 
                           value="<?php echo isset($filters['search']) ? htmlspecialchars($filters['search']) : ''; ?>" 
                           placeholder="Search recipes...">
                </div>
                
                <div class="filter-group">
                    <label for="grade" class="filter-label">Item Grade</label>
                    <select name="grade" id="grade" class="filter-select">
                        <option value="">All Grades</option>
                        <?php foreach ($grades as $grade): ?>
                            <option value="<?php echo $grade['itemGrade']; ?>" 
                                <?php echo (isset($filters['grade']) && $filters['grade'] == $grade['itemGrade']) ? 'selected' : ''; ?>>
                                <?php echo $grade['itemGrade']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="min_success" class="filter-label">Min Success Rate (%)</label>
                    <input type="number" name="min_success" id="min_success" class="filter-input" 
                           value="<?php echo isset($filters['min_success']) ? htmlspecialchars($filters['min_success']) : ''; ?>" 
                           min="0" max="100" step="1">
                </div>
                
                <div class="filter-group">
                    <label for="min_level" class="filter-label">Min Level</label>
                    <input type="number" name="min_level" id="min_level" class="filter-input" 
                           value="<?php echo isset($filters['min_level']) ? htmlspecialchars($filters['min_level']) : ''; ?>" 
                           min="0" max="99">
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="filter-button">Apply Filters</button>
                    <a href="index.php" class="filter-reset">Reset</a>
                </div>
            </form>
        </div>
        
        <!-- Results count -->
        <div class="results-count">
            Found <?php echo $totalResults['total']; ?> crafting recipes
        </div>
        
        <!-- Craft Grid -->
        <div class="card-grid craft-grid">
            <?php if (empty($crafts)): ?>
                <div class="no-results">No crafting recipes found matching your criteria.</div>
            <?php else: ?>
                <?php foreach ($crafts as $craft): ?>
                    <?php 
                    $outputItem = getOutputItemDetails($craft['outputs_success'], $db);
                    $successRate = number_format($craft['probability_million'] / 10000, 2);
                    ?>
                    <div class="card craft-card" onclick="window.location='<?php echo SITE_URL; ?>/public/crafts/detail.php?id=<?php echo $craft['craft_id']; ?>';" style="cursor:pointer;">
                        <div class="card-header">
                            <h3 class="card-header-title"><?php echo htmlspecialchars($craft['name']); ?></h3>
                            <?php if ($outputItem): ?>
                                <div class="card-badge <?php echo strtolower($outputItem['itemGrade']); ?>">
                                    <?php echo $outputItem['itemGrade']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-img-container">
                            <?php if ($outputItem): ?>
                                <img src="<?php echo SITE_URL; ?>/assets/img/icons/<?php echo $outputItem['iconId']; ?>.png" 
                                     alt="<?php echo htmlspecialchars($outputItem['cleanName']); ?>" class="card-img">
                            <?php else: ?>
                                <img src="<?php echo SITE_URL; ?>/assets/img/icons/default.png" alt="Recipe" class="card-img">
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-content">
                            <?php if ($outputItem): ?>
                                <h3 class="card-title"><?php echo htmlspecialchars($outputItem['cleanName']); ?></h3>
                            <?php else: ?>
                                <h3 class="card-title">Unknown Output</h3>
                            <?php endif; ?>
                            
                            <div class="card-stats">
                                <div class="card-stat">
                                    <div class="card-stat-label">Success Rate</div>
                                    <div class="card-stat-value craft-success-rate"><?php echo $successRate; ?>%</div>
                                </div>
                                
                                <?php if ($craft['min_level'] > 0): ?>
                                <div class="card-stat">
                                    <div class="card-stat-label">Min Level</div>
                                    <div class="card-stat-value"><?php echo $craft['min_level']; ?></div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($craft['max_level'] > 0): ?>
                                <div class="card-stat">
                                    <div class="card-stat-label">Max Level</div>
                                    <div class="card-stat-value"><?php echo $craft['max_level']; ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="card-category">Recipe ID: <?php echo $craft['craft_id']; ?></div>
                            <div class="card-indicator">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="pagination-link">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);
                
                if ($startPage > 1) {
                    echo '<a href="?page=1' . (!empty($filters) ? '&' . http_build_query($filters) : '') . '" class="pagination-link">1</a>';
                    if ($startPage > 2) {
                        echo '<span class="pagination-ellipsis">...</span>';
                    }
                }
                
                for ($i = $startPage; $i <= $endPage; $i++) {
                    $activeClass = ($i == $page) ? 'active' : '';
                    echo '<a href="?page=' . $i . (!empty($filters) ? '&' . http_build_query($filters) : '') . '" class="pagination-link ' . $activeClass . '">' . $i . '</a>';
                }
                
                if ($endPage < $totalPages) {
                    if ($endPage < $totalPages - 1) {
                        echo '<span class="pagination-ellipsis">...</span>';
                    }
                    echo '<a href="?page=' . $totalPages . (!empty($filters) ? '&' . http_build_query($filters) : '') . '" class="pagination-link">' . $totalPages . '</a>';
                }
                ?>
                
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="pagination-link">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Include footer
include_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/footer.php';
?>