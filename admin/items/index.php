<?php
// Admin items management page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Item.php';
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

// Initialize item model
$itemModel = new Item();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

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
    
    // Fixed: Use max_charge_count instead of has_charges to match the Item class expectations
    if (!empty($_GET['has_charges']) && $_GET['has_charges'] == 1) {
        $filters['max_charge_count'] = 1; // This will filter for items with charges > 0
    }
    
    // Add bin data filter
    if (!empty($_GET['has_bin']) && $_GET['has_bin'] == 1) {
        $filters['has_bin'] = 1; // This will filter for items with bin data
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $items = $itemModel->searchItems($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Items Management";
} elseif (!empty($filters)) {
    $items = $itemModel->filterItems($filters, $page);
    $pageTitle = "Filtered Items - Items Management";
} else {
    $items = $itemModel->getAllItems($page);
    $pageTitle = "Items Management";
}

// Handle delete action
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $itemId = (int)$_POST['id'];
    $item = $itemModel->getItemById($itemId);
    
    if ($item) {
        if ($itemModel->deleteItem($itemId)) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Log activity with null-safe username
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'delete',
                "Deleted item: {$item['desc_en']} (ID: $itemId)",
                'item',
                $itemId
            );
            
            $successMessage = "Item '{$item['desc_en']}' has been deleted successfully.";
        } else {
            $errorMessage = "Failed to delete item. Please try again.";
        }
    } else {
        $errorMessage = "Item not found.";
    }
}

// Get filter options for the filter form
$itemTypes = $itemModel->getItemTypes();
$itemUseTypes = $itemModel->getItemUseTypes();
$itemMaterials = $itemModel->getItemMaterials();
$itemGrades = $itemModel->getItemGrades();

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
                    <i class="fas fa-plus"></i> Add New Item
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
                Item has been deleted successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                New item has been created successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Item has been updated successfully.
            </div>
            <?php endif; ?>
            
            <!-- Search and Filters -->
            <div class="admin-filters">
                <form action="index.php" method="get" class="admin-filter-form">
                    <div class="admin-filter-group">
                        <label for="search" class="admin-filter-label">Search</label>
                        <input type="text" id="search" name="search" class="admin-filter-input" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search items...">
                    </div>
                    
                    <div class="admin-filter-group">
					<label for="item_type" class="admin-filter-label">Item Type</label>
					<div class="custom-select-wrapper">
						<select id="item_type" name="item_type" class="admin-filter-select">
							<option value="">All Types</option>
                            <?php foreach ($itemTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (isset($filters['item_type']) && $filters['item_type'] === $type) ? 'selected' : ''; ?>>
                                <?php echo ucfirst(strtolower(str_replace('_', ' ', $type))); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="use_type" class="admin-filter-label">Use Type</label>
                        <select id="use_type" name="use_type" class="admin-filter-select">
                            <option value="">All Use Types</option>
                            <?php foreach ($itemUseTypes as $useType): ?>
                            <option value="<?php echo $useType; ?>" <?php echo (isset($filters['use_type']) && $filters['use_type'] === $useType) ? 'selected' : ''; ?>>
                                <?php echo ucfirst(strtolower(str_replace('_', ' ', $useType))); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="material" class="admin-filter-label">Material</label>
                        <select id="material" name="material" class="admin-filter-select">
                            <option value="">All Materials</option>
                            <?php foreach ($itemMaterials as $material): ?>
                            <option value="<?php echo $material; ?>" <?php echo (isset($filters['material']) && $filters['material'] === $material) ? 'selected' : ''; ?>>
                                <?php echo formatMaterial($material); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="grade" class="admin-filter-label">Grade</label>
                        <select id="grade" name="grade" class="admin-filter-select">
                            <option value="">All Grades</option>
                            <?php foreach ($itemGrades as $grade): ?>
                            <option value="<?php echo $grade; ?>" <?php echo (isset($filters['grade']) && $filters['grade'] === $grade) ? 'selected' : ''; ?>>
                                <?php echo formatGrade($grade); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="has_charges" class="admin-filter-label">Has Charges</label>
                        <select id="has_charges" name="has_charges" class="admin-filter-select">
                            <option value="">All Items</option>
                            <option value="1" <?php echo (isset($_GET['has_charges']) && $_GET['has_charges'] == 1) ? 'selected' : ''; ?>>With Charges Only</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="has_bin" class="admin-filter-label">Bin Data</label>
                        <select id="has_bin" name="has_bin" class="admin-filter-select">
                            <option value="">All Items</option>
                            <option value="1" <?php echo (isset($_GET['has_bin']) && $_GET['has_bin'] == 1) ? 'selected' : ''; ?>>With Bin Data Only</option>
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
                Showing <?php echo count($items['data']); ?> of <?php echo $items['total_records']; ?> items
            </p>
            
            <!-- Items Table -->
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Name (EN)</th>
                            <th>Name (KR)</th>
                            <th>Item Type</th>
                            <th>Use Type</th>
                            <th>Material</th>
                            <th>Grade</th>
                            <th>Bin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items['data'])): ?>
                        <tr>
                            <td colspan="10" class="admin-table-empty">No items found. Please try a different search or filter.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($items['data'] as $item): ?>
                            <tr>
                                <td><?php echo $item['item_id']; ?></td>
                                <td>
                                    <img src="<?php echo getItemIconUrl($item['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?>" class="admin-table-icon">
                                </td>
                                <td><?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?></td>
                                <td><?php echo htmlspecialchars(cleanItemName($item['desc_kr'])); ?></td>
                                <td><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['item_type']))); ?></td>
                                <td><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['use_type']))); ?></td>
                                <td><?php echo formatMaterial($item['material']); ?></td>
                                <td>
                                    <span class="admin-badge admin-badge-<?php echo strtolower($item['itemGrade']); ?>">
                                        <?php echo formatGrade($item['itemGrade']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($itemModel->hasBinData($item['item_name_id'])): ?>
                                    <span class="admin-badge admin-badge-success" title="Has bin data">✓</span>
                                    <?php else: ?>
                                    <span class="admin-badge admin-badge-secondary" title="No bin data">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="admin-actions">
                                    <a href="../../public/items/detail.php?id=<?php echo $item['item_id']; ?>" class="admin-button admin-button-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?php echo $item['item_id']; ?>" class="admin-button admin-button-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $item['item_id']; ?>" class="admin-button admin-button-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <?php if ($itemModel->hasBinData($item['item_name_id'])): ?>
                                    <a href="bin_data.php?name_id=<?php echo $item['item_name_id']; ?>" class="admin-button admin-button-warning" title="View Bin Data">
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
            <?php if ($items['total_pages'] > 1): ?>
            <div class="admin-pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($items['total_pages'], $page + 2);
                
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
                
                <?php if ($endPage < $items['total_pages']): ?>
                <?php if ($endPage < $items['total_pages'] - 1): ?>
                <span class="admin-pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $items['total_pages']; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">
                    <?php echo $items['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $items['total_pages']): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>


<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>