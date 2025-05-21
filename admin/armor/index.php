<?php
// Admin armor management page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Armor.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Initialize armor model
$armorModel = new Armor();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

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
    
    if (!empty($_GET['has_bin'])) {
        $filters['has_bin'] = $_GET['has_bin'];
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $armors = $armorModel->searchArmor($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Armor Management";
} elseif (!empty($filters)) {
    $armors = $armorModel->filterArmor($filters, $page);
    $pageTitle = "Filtered Armor - Armor Management";
} else {
    $armors = $armorModel->getAllArmor($page);
    $pageTitle = "Armor Management";
}

// Handle delete action
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $armorId = (int)$_POST['id'];
    $armor = $armorModel->getArmorById($armorId);
    
    if ($armor) {
        if ($armorModel->deleteArmor($armorId)) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Log activity with null-safe username
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'delete',
                "Deleted armor: {$armor['desc_en']} (ID: $armorId)",
                'armor',
                $armorId
            );
            
            $successMessage = "Armor '{$armor['desc_en']}' has been deleted successfully.";
        } else {
            $errorMessage = "Failed to delete armor. Please try again.";
        }
    } else {
        $errorMessage = "Armor not found.";
    }
}

// Get filter options for the filter form
$armorTypes = $armorModel->getArmorTypes();
$armorMaterials = $armorModel->getArmorMaterials();
$armorGrades = $armorModel->getArmorGrades();

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
                    <i class="fas fa-plus"></i> Add New Armor
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
                Armor has been deleted successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                New armor has been created successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Armor has been updated successfully.
            </div>
            <?php endif; ?>
            
            <!-- Search and Filters -->
            <div class="admin-filters">
                <form action="index.php" method="get" class="admin-filter-form">
                    <div class="admin-filter-group">
                        <label for="search" class="admin-filter-label">Search</label>
                        <input type="text" id="search" name="search" class="admin-filter-input" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search armor...">
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="type" class="admin-filter-label">Armor Type</label>
                        <select id="type" name="type" class="admin-filter-select">
                            <option value="">All Types</option>
                            <?php foreach ($armorTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($filters['type']) && $filters['type'] === $type) ? 'selected' : ''; ?>>
                                <?php echo $type; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="material" class="admin-filter-label">Material</label>
                        <select id="material" name="material" class="admin-filter-select">
                            <option value="">All Materials</option>
                            <?php foreach ($armorMaterials as $material): ?>
                            <option value="<?php echo $material; ?>" <?php echo (isset($filters['material']) && $filters['material'] === $material) ? 'selected' : ''; ?>>
                                <?php echo $material; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="grade" class="admin-filter-label">Grade</label>
                        <select id="grade" name="grade" class="admin-filter-select">
                            <option value="">All Grades</option>
                            <?php foreach ($armorGrades as $grade): ?>
                            <option value="<?php echo $grade; ?>" <?php echo (isset($filters['grade']) && $filters['grade'] === $grade) ? 'selected' : ''; ?>>
                                <?php echo $grade; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="has_set" class="admin-filter-label">Set Items</label>
                        <select id="has_set" name="has_set" class="admin-filter-select">
                            <option value="">All Items</option>
                            <option value="1" <?php echo (isset($filters['has_set']) && $filters['has_set'] == 1) ? 'selected' : ''; ?>>Set Items Only</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="has_bin" class="admin-filter-label">Bin Data</label>
                        <select id="has_bin" name="has_bin" class="admin-filter-select">
                            <option value="">All Items</option>
                            <option value="1" <?php echo (isset($filters['has_bin']) && $filters['has_bin'] == 1) ? 'selected' : ''; ?>>With Bin Data Only</option>
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
                Showing <?php echo count($armors['data']); ?> of <?php echo $armors['total_records']; ?> armor pieces
            </p>
            
            <!-- Armor Table -->
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Name (EN)</th>
                            <th>Name (KR)</th>
                            <th>Type</th>
                            <th>AC</th>
                            <th>Grade</th>
                            <th>Bin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($armors['data'])): ?>
                        <tr>
                            <td colspan="9" class="admin-table-empty">No armor found. Please try a different search or filter.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($armors['data'] as $armor): ?>
                            <tr>
                                <td><?php echo $armor['item_id']; ?></td>
                                <td>
                                    <img src="<?php echo $armorModel->getArmorIconUrl($armor['iconId']); ?>" alt="<?php echo htmlspecialchars($armor['desc_en']); ?>" class="admin-table-icon">
                                </td>
                                <td><?php echo htmlspecialchars($armor['desc_en']); ?></td>
                                <td><?php echo htmlspecialchars($armor['desc_kr']); ?></td>
                                <td><?php echo $armor['type']; ?></td>
                                <td><?php echo $armor['ac']; ?></td>
                                <td><?php echo $armor['itemGrade']; ?></td>
                                <td>
                                    <?php if ($armorModel->hasBinData($armor['item_name_id'])): ?>
                                    <span class="admin-badge admin-badge-success" title="Has bin data">✓</span>
                                    <?php else: ?>
                                    <span class="admin-badge admin-badge-secondary" title="No bin data">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="admin-actions">
                                    <a href="../../public/armor/detail.php?id=<?php echo $armor['item_id']; ?>" class="admin-button admin-button-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?php echo $armor['item_id']; ?>" class="admin-button admin-button-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $armor['item_id']; ?>" class="admin-button admin-button-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <?php if ($armorModel->hasBinData($armor['item_name_id'])): ?>
                                    <a href="bin_data.php?name_id=<?php echo $armor['item_name_id']; ?>" class="admin-button admin-button-warning" title="View Bin Data">
                                        <i class="fas fa-database"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($armors['total_pages'] > 1): ?>
            <div class="admin-pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($armors['total_pages'], $page + 2);
                
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
                
                <?php if ($endPage < $armors['total_pages']): ?>
                <?php if ($endPage < $armors['total_pages'] - 1): ?>
                <span class="admin-pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $armors['total_pages']; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">
                    <?php echo $armors['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $armors['total_pages']): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
.admin-badge {
    display: inline-block;
    width: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    border-radius: 50%;
    font-weight: bold;
}
.admin-badge-success {
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
}
.admin-badge-secondary {
    background-color: rgba(108, 117, 125, 0.2);
    color: #6c757d;
}
</style>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>