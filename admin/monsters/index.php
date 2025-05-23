<?php
// Admin monsters management page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Monster.php';
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

// Initialize monsters model
$monstersModel = new Monster();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Handle filters
$filters = [];
if (isset($_GET['filter'])) {
    if (!empty($_GET['family'])) {
        $filters['family'] = $_GET['family'];
    }
    
    if (!empty($_GET['undead'])) {
        $filters['undead'] = $_GET['undead'];
    }
    
    if (!empty($_GET['weakAttr'])) {
        $filters['weakAttr'] = $_GET['weakAttr'];
    }
    
    if (!empty($_GET['min_level'])) {
        $filters['min_level'] = (int)$_GET['min_level'];
    }
    
    if (!empty($_GET['max_level'])) {
        $filters['max_level'] = (int)$_GET['max_level'];
    }
    
    if (isset($_GET['is_agro']) && $_GET['is_agro'] !== '') {
        $filters['is_agro'] = $_GET['is_agro'] === 'true' ? 'true' : 'false';
    }
    
    if (isset($_GET['is_boss']) && $_GET['is_boss'] !== '') {
        $filters['is_boss'] = $_GET['is_boss'] === 'true' ? 'true' : 'false';
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $monsters = $monstersModel->searchMonsters($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Monsters Management";
} elseif (!empty($filters)) {
    $monsters = $monstersModel->filterMonsters($filters, $page);
    $pageTitle = "Filtered Monsters - Monsters Management";
} else {
    $monsters = $monstersModel->getAllMonsters($page);
    $pageTitle = "Monsters Management";
}

// Handle delete action
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $monsterId = (int)$_POST['id'];
    $monster = $monstersModel->getMonsterById($monsterId);
    
    if ($monster) {
        $result = $monstersModel->deleteMonster($monsterId);
        
        if ($result) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Log activity
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'delete',
                "Deleted monster: {$monster['desc_en']} (ID: $monsterId)",
                'monster',
                $monsterId
            );
            
            $successMessage = "Monster '{$monster['desc_en']}' has been deleted successfully.";
        } else {
            $errorMessage = "Failed to delete monster. Please try again.";
        }
    } else {
        $errorMessage = "Monster not found.";
    }
}

// Get filter options for the filter form
$monsterTypes = $monstersModel->getMonsterTypes();
$monsterUndeadTypes = $monstersModel->getMonsterUndeadTypes();
$monsterWeakAttributes = $monstersModel->getMonsterWeakAttributes();

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
                    <i class="fas fa-plus"></i> Add New Monster
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
                Monster has been deleted successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                New monster has been created successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Monster has been updated successfully.
            </div>
            <?php endif; ?>
            
            <!-- Filters -->
            <div class="admin-filters">
                <form action="index.php" method="get" class="admin-filter-form">
                    <div class="admin-filter-group">
                        <label for="search" class="admin-filter-label">Search</label>
                        <input type="text" id="search" name="search" class="admin-filter-input" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search monsters...">
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="family" class="admin-filter-label">Family</label>
                        <select id="family" name="family" class="admin-filter-select">
                            <option value="">All Families</option>
                            <?php foreach ($monsterTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type); ?>" <?php echo (isset($filters['family']) && $filters['family'] === $type) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="undead" class="admin-filter-label">Undead Type</label>
                        <select id="undead" name="undead" class="admin-filter-select">
                            <option value="">All Types</option>
                            <?php foreach ($monsterUndeadTypes as $undead): ?>
                            <option value="<?php echo htmlspecialchars($undead); ?>" <?php echo (isset($filters['undead']) && $filters['undead'] === $undead) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($undead); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="weakAttr" class="admin-filter-label">Weak Attribute</label>
                        <select id="weakAttr" name="weakAttr" class="admin-filter-select">
                            <option value="">All Attributes</option>
                            <?php foreach ($monsterWeakAttributes as $attr): ?>
                            <option value="<?php echo htmlspecialchars($attr); ?>" <?php echo (isset($filters['weakAttr']) && $filters['weakAttr'] === $attr) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($attr); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="min_level" class="admin-filter-label">Min Level</label>
                        <input type="number" id="min_level" name="min_level" class="admin-filter-input" value="<?php echo isset($filters['min_level']) ? $filters['min_level'] : ''; ?>" min="0" max="999">
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="max_level" class="admin-filter-label">Max Level</label>
                        <input type="number" id="max_level" name="max_level" class="admin-filter-input" value="<?php echo isset($filters['max_level']) ? $filters['max_level'] : ''; ?>" min="0" max="999">
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="is_agro" class="admin-filter-label">Aggressive</label>
                        <select id="is_agro" name="is_agro" class="admin-filter-select">
                            <option value="">All</option>
                            <option value="true" <?php echo (isset($filters['is_agro']) && $filters['is_agro'] === 'true') ? 'selected' : ''; ?>>Yes</option>
                            <option value="false" <?php echo (isset($filters['is_agro']) && $filters['is_agro'] === 'false') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-group">
                        <label for="is_boss" class="admin-filter-label">Boss Monster</label>
                        <select id="is_boss" name="is_boss" class="admin-filter-select">
                            <option value="">All</option>
                            <option value="true" <?php echo (isset($filters['is_boss']) && $filters['is_boss'] === 'true') ? 'selected' : ''; ?>>Yes</option>
                            <option value="false" <?php echo (isset($filters['is_boss']) && $filters['is_boss'] === 'false') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="admin-filter-actions">
                        <button type="submit" name="filter" class="admin-button admin-button-secondary">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                        <a href="index.php" class="admin-button admin-button-light">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Data Table -->
            <div class="admin-data-table">
                <?php if ($monsters['total_records'] > 0): ?>
                
                <!-- Results summary -->
                <div class="admin-data-summary">
                    <?php 
                    // Calculate start and end positions
                    $start = (($monsters['current_page'] - 1) * $monsters['per_page']) + 1;
                    $end = min($start + count($monsters['data']) - 1, $monsters['total_records']);
                    ?>
                    Showing <?php echo number_format($start); ?> to <?php echo number_format($end); ?> 
                    of <?php echo number_format($monsters['total_records']); ?> monsters
                    (Page <?php echo $monsters['current_page']; ?> of <?php echo $monsters['total_pages']; ?>)
                </div>
                
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>ID</th>
                                <th>Name (EN)</th>
                                <th>Name (KR)</th>
                                <th>Level</th>
                                <th>HP</th>
                                <th>MP</th>
                                <th>Exp</th>
                                <th>Family</th>
                                <th>Type</th>
                                <th>Agro</th>
                                <th>Boss</th>
                                <th class="admin-actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($monsters['data'] as $monster): ?>
                            <tr>
                                <td class="admin-image-cell">
                                    <?php if ($monster['spriteId']): ?>
                                    <img src="../../assets/img/icons/ms<?php echo $monster['spriteId']; ?>.png" 
                                         alt="Monster <?php echo htmlspecialchars($monster['desc_en']); ?>" 
                                         class="admin-monster-icon"
                                         onerror="this.src='../../assets/img/placeholders/monster.png'">
                                    <?php else: ?>
                                    <img src="../../assets/img/placeholders/monster.png" alt="No image" class="admin-monster-icon">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $monster['npcid']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($monster['desc_en']); ?></strong>
                                    <?php if ($monster['impl'] === 'L1BlackKnight'): ?>
                                    <span class="admin-monster-type admin-monster-blackknight">Black Knight</span>
                                    <?php elseif ($monster['impl'] === 'L1Doppelganger'): ?>
                                    <span class="admin-monster-type admin-monster-doppelganger">Doppelganger</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($monster['desc_kr']); ?></td>
                                <td>
                                    <span class="admin-level-badge admin-level-<?php echo min(floor($monster['lvl'] / 10), 9); ?>">
                                        <?php echo $monster['lvl']; ?>
                                    </span>
                                </td>
                                <td><?php echo number_format($monster['hp']); ?></td>
                                <td><?php echo number_format($monster['mp']); ?></td>
                                <td><?php echo number_format($monster['exp']); ?></td>
                                <td><?php echo htmlspecialchars($monster['family'] ?: 'N/A'); ?></td>
                                <td>
                                    <?php if ($monster['undead'] !== 'NONE'): ?>
                                    <span class="admin-undead-badge"><?php echo htmlspecialchars($monster['undead']); ?></span>
                                    <?php else: ?>
                                    <span class="admin-type-normal">Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($monster['is_agro'] === 'true'): ?>
                                    <span class="admin-status-badge admin-status-danger">
                                        <i class="fas fa-exclamation-triangle"></i> Aggressive
                                    </span>
                                    <?php else: ?>
                                    <span class="admin-status-badge admin-status-success">
                                        <i class="fas fa-check"></i> Peaceful
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($monster['is_bossmonster']) && $monster['is_bossmonster'] === 'true'): ?>
                                    <span class="admin-status-badge admin-status-warning">
                                        <i class="fas fa-crown"></i> Boss
                                    </span>
                                    <?php else: ?>
                                    <span class="admin-status-badge admin-status-light">Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td class="admin-actions-cell">
                                    <div class="admin-actions">
                                        <a href="edit.php?id=<?php echo $monster['npcid']; ?>" 
                                           class="admin-action-button admin-action-edit" 
                                           title="Edit Monster">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="admin-action-button admin-action-delete" 
                                                onclick="confirmDelete(<?php echo $monster['npcid']; ?>, '<?php echo htmlspecialchars($monster['desc_en'], ENT_QUOTES); ?>')"
                                                title="Delete Monster">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($monsters['total_pages'] > 1): ?>
                <div class="admin-pagination">
                    <?php
                    $currentUrl = 'index.php';
                    $queryParams = [];
                    if (!empty($searchTerm)) $queryParams['search'] = $searchTerm;
                    if (!empty($filters)) {
                        $queryParams['filter'] = '1';
                        foreach ($filters as $key => $value) {
                            $queryParams[$key] = $value;
                        }
                    }
                    ?>
                    
                    <?php if ($monsters['current_page'] > 1): ?>
                    <a href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => 1])); ?>" 
                       class="admin-pagination-link">
                        <i class="fas fa-angle-double-left"></i>
                    </a>
                    <a href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $monsters['current_page'] - 1])); ?>" 
                       class="admin-pagination-link">
                        <i class="fas fa-angle-left"></i>
                    </a>
                    <?php endif; ?>
                    
                    <?php
                    $start = max(1, $monsters['current_page'] - 2);
                    $end = min($monsters['total_pages'], $monsters['current_page'] + 2);
                    
                    for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $i])); ?>" 
                       class="admin-pagination-link <?php echo ($i == $monsters['current_page']) ? 'admin-pagination-active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                    <?php endfor; ?>
                    
                    <?php if ($monsters['current_page'] < $monsters['total_pages']): ?>
                    <a href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $monsters['current_page'] + 1])); ?>" 
                       class="admin-pagination-link">
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $monsters['total_pages']])); ?>" 
                       class="admin-pagination-link">
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <?php else: ?>
                <div class="admin-no-data">
                    <div class="admin-no-data-icon">
                        <i class="fas fa-dragon"></i>
                    </div>
                    <h3>No monsters found</h3>
                    <?php if (!empty($searchTerm) || !empty($filters)): ?>
                    <p>No monsters match your search criteria. Try adjusting your filters or search terms.</p>
                    <a href="index.php" class="admin-button admin-button-secondary">Clear filters</a>
                    <?php else: ?>
                    <p>No monsters are currently in the database.</p>
                    <a href="create.php" class="admin-button admin-button-primary">Add first monster</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="admin-modal" style="display: none;">
    <div class="admin-modal-content">
        <div class="admin-modal-header">
            <h3>Confirm Deletion</h3>
            <button type="button" class="admin-modal-close" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="admin-modal-body">
            <p>Are you sure you want to delete this monster?</p>
            <p><strong id="deleteMonsterName"></strong></p>
            <p class="admin-warning">This action cannot be undone.</p>
        </div>
        <div class="admin-modal-footer">
            <form id="deleteForm" method="post" style="display: inline;">
                <input type="hidden" name="delete" value="1">
                <input type="hidden" name="id" id="deleteId">
                <button type="button" class="admin-button admin-button-secondary" onclick="closeDeleteModal()">
                    Cancel
                </button>
                <button type="submit" class="admin-button admin-button-danger">
                    <i class="fas fa-trash"></i> Delete Monster
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMonsterName').textContent = name;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

<?php include '../../includes/admin-footer.php'; ?> 