<?php
// Admin weapons management page
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Weapon.php';
require_once '../../classes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Initialize weapons model
$weaponsModel = new Weapon();

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
    
    if (!empty($_GET['min_dmg'])) {
        $filters['min_dmg'] = (int)$_GET['min_dmg'];
    }
    
    if (!empty($_GET['max_dmg'])) {
        $filters['max_dmg'] = (int)$_GET['max_dmg'];
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $weapons = $weaponsModel->searchWeapons($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Weapons Management";
} elseif (!empty($filters)) {
    $weapons = $weaponsModel->filterWeapons($filters, $page);
    $pageTitle = "Filtered Weapons - Weapons Management";
} else {
    $weapons = $weaponsModel->getAllWeapons($page);
    $pageTitle = "Weapons Management";
}

// Handle delete action
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $weaponId = (int)$_POST['id'];
    $weapon = $weaponsModel->getWeaponById($weaponId);
    
    if ($weapon) {
        $result = $weaponsModel->deleteWeapon($weaponId);
        
        if ($result['success']) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Build detailed deletion message
            $deletionDetails = "Deleted weapon: {$weapon['desc_en']} (ID: $weaponId). ";
            $deletionDetails .= "Related records deleted: ";
            $deletionDetails .= "Droplists: {$result['report']['droplist']}, ";
            $deletionDetails .= "Weapon Skills: {$result['report']['weapon_skill']}, ";
            $deletionDetails .= "Weapon Skill Models: {$result['report']['weapon_skill_model']}, ";
            $deletionDetails .= "Weapon Damage Entries: {$result['report']['weapon_damege']}";
            
            // Log activity with null-safe username and detailed deletion info
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'delete',
                $deletionDetails,
                'weapon',
                $weaponId
            );
            
            // Store deletion report in session
            $_SESSION['deletion_report'] = $result['report'];
            $_SESSION['deleted_weapon_name'] = $weapon['desc_en'];
            
            $successMessage = "Weapon '{$weapon['desc_en']}' has been deleted successfully.";
        } else {
            $errorMessage = $result['message'] ?? "Failed to delete weapon. Please try again.";
        }
    } else {
        $errorMessage = "Weapon not found.";
    }
}

// Get filter options for the filter form
$weaponTypes = $weaponsModel->getWeaponTypes();
$weaponMaterials = $weaponsModel->getWeaponMaterials();
$weaponGrades = $weaponsModel->getWeaponGrades();

// Prepare deletion report from session if available
$deletionReport = null;
$deletedWeaponName = null;
if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    if (isset($_SESSION['deletion_report'])) {
        $deletionReport = $_SESSION['deletion_report'];
        unset($_SESSION['deletion_report']);
    }
    
    if (isset($_GET['weapon_name'])) {
        $deletedWeaponName = urldecode($_GET['weapon_name']);
    } elseif (isset($_SESSION['deleted_weapon_name'])) {
        $deletedWeaponName = $_SESSION['deleted_weapon_name'];
        unset($_SESSION['deleted_weapon_name']);
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
                    <i class="fas fa-plus"></i> Add New Weapon
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
            
            <?php if ($deletionReport && $deletedWeaponName): ?>
            <div class="admin-alert admin-alert-success">
                <p><strong>Success:</strong> Weapon "<?php echo htmlspecialchars($deletedWeaponName); ?>" has been deleted successfully.</p>
                <div class="admin-deletion-report">
                    <p><strong>Deletion Report:</strong></p>
                    <ul>
                        <li>Weapon record: <?php echo $deletionReport['weapon']; ?></li>
                        <li>Drop entries: <?php echo $deletionReport['droplist']; ?></li>
                        <li>Weapon skills: <?php echo $deletionReport['weapon_skill']; ?></li>
                        <li>Skill models: <?php echo $deletionReport['weapon_skill_model']; ?></li>
                        <li>Damage entries: <?php echo $deletionReport['weapon_damege']; ?></li>
                    </ul>
                    <p class="admin-deletion-total">
                        <strong>Total records deleted:</strong> 
                        <?php echo array_sum($deletionReport); ?>
                    </p>
                </div>
            </div>
            <?php elseif (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Weapon has been deleted successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['created']) && $_GET['created'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                New weapon has been created successfully.
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="admin-alert admin-alert-success">
                Weapon has been updated successfully.
            </div>
            <?php endif; ?>
            
            <!-- Filters -->
			<div class="admin-filters">
				<form action="index.php" method="get" class="admin-filter-form">
					<div class="admin-filter-group">
						<label for="search" class="admin-filter-label">Search</label>
						<input type="text" id="search" name="search" class="admin-filter-input" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search weapons...">
					</div>
					
					<div class="admin-filter-group">
						<label for="type" class="admin-filter-label">Weapon Type</label>
						<select id="type" name="type" class="admin-filter-select">
							<option value="">All Types</option>
							<?php foreach ($weaponTypes as $type): ?>
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
							<?php foreach ($weaponMaterials as $material): ?>
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
							<?php foreach ($weaponGrades as $grade): ?>
							<option value="<?php echo $grade; ?>" <?php echo (isset($filters['grade']) && $filters['grade'] === $grade) ? 'selected' : ''; ?>>
								<?php echo $grade; ?>
							</option>
							<?php endforeach; ?>
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
                Showing <?php echo count($weapons['data']); ?> of <?php echo $weapons['total_records']; ?> weapons
            </p>
            
            <!-- Weapons Table -->
			<div class="admin-table-container">
				<table class="admin-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Icon</th>
							<th>Name (EN)</th>
							<th>Name (KR)</th>
							<th>Type</th>
							<th>Damage</th>
							<th>Grade</th>
							<th>Bin</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($weapons['data'])): ?>
						<tr>
							<td colspan="9" class="admin-table-empty">No weapons found. Please try a different search or filter.</td>
						</tr>
						<?php else: ?>
							<?php foreach ($weapons['data'] as $weapon): ?>
							<tr>
								<td><?php echo $weapon['item_id']; ?></td>
								<td>
									<img src="<?php echo $weaponsModel->getWeaponIconUrl($weapon['iconId']); ?>" alt="<?php echo htmlspecialchars($weapon['desc_en']); ?>" class="admin-table-icon">
								</td>
								<td><?php echo htmlspecialchars($weapon['desc_en']); ?></td>
								<td><?php echo htmlspecialchars($weapon['desc_kr']); ?></td>
								<td><?php echo $weapon['type']; ?></td>
								<td><?php echo $weapon['dmg_small']; ?>-<?php echo $weapon['dmg_large']; ?></td>
								<td><?php echo $weapon['itemGrade']; ?></td>
								<td>
									<?php if ($weaponsModel->hasBinData($weapon['item_name_id'])): ?>
									<span class="admin-badge admin-badge-success" title="Has bin data">✓</span>
									<?php else: ?>
									<span class="admin-badge admin-badge-secondary" title="No bin data">-</span>
									<?php endif; ?>
								</td>
								<td class="admin-actions">
									<a href="../../public/weapons/detail.php?id=<?php echo $weapon['item_id']; ?>" class="admin-button admin-button-info" title="View">
										<i class="fas fa-eye"></i>
									</a>
									<a href="edit.php?id=<?php echo $weapon['item_id']; ?>" class="admin-button admin-button-primary" title="Edit">
										<i class="fas fa-edit"></i>
									</a>
									<a href="delete.php?id=<?php echo $weapon['item_id']; ?>" class="admin-button admin-button-danger" title="Delete">
										<i class="fas fa-trash-alt"></i>
									</a>
									<?php if ($weaponsModel->hasBinData($weapon['item_name_id'])): ?>
									<a href="bin_data.php?name_id=<?php echo $weapon['item_name_id']; ?>" class="admin-button admin-button-warning" title="View Bin Data">
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
            <?php if ($weapons['total_pages'] > 1): ?>
            <div class="admin-pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($weapons['total_pages'], $page + 2);
                
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
                
                <?php if ($endPage < $weapons['total_pages']): ?>
                <?php if ($endPage < $weapons['total_pages'] - 1): ?>
                <span class="admin-pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $weapons['total_pages']; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?><?php echo !empty($filters) ? '&filter=1&' . http_build_query(array_filter($filters)) : ''; ?>" class="admin-pagination-link">
                    <?php echo $weapons['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($page < $weapons['total_pages']): ?>
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