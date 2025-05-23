<?php
// File: admin/database-explorer.php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Check if user is logged in and has admin access
if (!$user->isAdmin()) {
    header('Location: login.php');
    exit;
}

// Update user's last active time
$currentUser = $user->getCurrentUser();
if ($currentUser) {
    $user->updateLastActive($currentUser['login']);
}

$db = Database::getInstance();
$pdo = $db->getConnection();

// Get parameters
$mode = $_GET['mode'] ?? 'overview';
$selectedTable = $_GET['table'] ?? null;
$selectedColumn = $_GET['column'] ?? null;
$searchTerm = $_GET['search'] ?? null;
$viewData = isset($_GET['view_data']) && $_GET['view_data'] === '1';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 50;

// Get all tables
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

// Include admin header
include '../../includes/admin-header.php';
?>

<main class="admin-dashboard">
    <div class="container">
        <div class="admin-dashboard-header">
            <h1 class="admin-dashboard-title">Database Explorer</h1>
            <div class="admin-dashboard-actions">
                <a href="../index.php" class="admin-button admin-button-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Mode Selector Tabs -->
        <div class="admin-tabs">
            <ul class="admin-tabs-nav">
                <li class="admin-tab-item <?php echo $mode === 'overview' ? 'active' : ''; ?>">
                    <a href="?mode=overview">Database Overview</a>
                </li>
                <li class="admin-tab-item <?php echo $mode === 'tables' ? 'active' : ''; ?>">
                    <a href="?mode=tables">Explore Tables</a>
                </li>
                <li class="admin-tab-item <?php echo $mode === 'search' ? 'active' : ''; ?>">
                    <a href="?mode=search">Find Columns</a>
                </li>
            </ul>
        </div>

        <div class="admin-tabs-content">
            <?php if ($mode === 'overview'): ?>
                <!-- Database Overview -->
                <?php include 'database-explorer-overview.php'; ?>

            <?php elseif ($mode === 'tables'): ?>
                <!-- Table Explorer -->
                <?php include 'database-explorer-tables.php'; ?>

            <?php elseif ($mode === 'search'): ?>
                <!-- Column Search -->
                <?php include 'database-explorer-search.php'; ?>
                
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
.expandable-value {
    position: relative;
}

.expand-link {
    color: var(--admin-accent);
    font-size: 0.85rem;
    cursor: pointer;
    text-decoration: none;
}

.expand-link:hover {
    text-decoration: underline;
}

.expanded-content {
    white-space: pre-wrap;
    word-break: break-word;
    max-width: 500px;
}

/* Enhanced table styles for better data viewing */
.admin-table td {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.admin-table-container {
    position: relative;
}

/* Sticky first column for wide tables */
@media (min-width: 992px) {
    .admin-table.sticky-first td:first-child,
    .admin-table.sticky-first th:first-child {
        position: sticky;
        left: 0;
        background-color: var(--admin-primary);
        z-index: 5;
        box-shadow: 2px 0 4px rgba(0,0,0,0.1);
    }
}
</style>

<script>
function expandValue(link) {
    const container = link.closest('.expandable-value');
    const fullValue = container.getAttribute('data-full');
    
    if (link.textContent.includes('Show More') || link.textContent.includes('+')) {
        container.innerHTML = '<div class="expanded-content">' + escapeHtml(fullValue) + '</div> ' +
                            '<a href="#" class="expand-link" onclick="expandValue(this); return false;">[Show Less]</a>';
    } else {
        const truncated = fullValue.length > 100 ? fullValue.substring(0, 100) + '...' : fullValue;
        container.innerHTML = escapeHtml(truncated) + ' ' +
                            '<a href="#" class="expand-link" onclick="expandValue(this); return false;">[Show More]</a>';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.querySelector('input[name="search"]')?.focus();
    }
});
</script>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>