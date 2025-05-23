<?php
// Include configuration
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Monster.php';
require_once __DIR__ . '/../../includes/functions.php';

// Initialize session
init_session();

// Initialize user
$user = new User();

// Initialize monsters model
$monstersModel = new Monster();

// Get page number for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

// Handle filters
$filters = [];
if (isset($_GET['filter'])) {
    if (!empty($_GET['family'])) {
        $filters['family'] = $_GET['family'];
    }
    
    if (!empty($_GET['undead'])) {
        $filters['undead'] = $_GET['undead'];
    }
    
    if (!empty($_GET['level_range'])) {
        $levelRange = explode('-', $_GET['level_range']);
        if (count($levelRange) === 2) {
            $filters['min_level'] = (int)$levelRange[0];
            $filters['max_level'] = (int)$levelRange[1];
        }
    }
    
    if (isset($_GET['is_agro']) && $_GET['is_agro'] !== '') {
        $filters['is_agro'] = $_GET['is_agro'] === '1' ? 'true' : 'false';
    }
    
    if (isset($_GET['is_boss']) && $_GET['is_boss'] !== '') {
        $filters['is_boss'] = $_GET['is_boss'] === '1' ? 'true' : 'false';
    }
}

// Get data based on search or filters
if (!empty($searchTerm)) {
    $monsters = $monstersModel->searchMonsters($searchTerm, $page);
    $pageTitle = "Search Results for \"$searchTerm\" - Monsters";
} elseif (!empty($filters)) {
    $monsters = $monstersModel->filterMonsters($filters, $page);
    $pageTitle = "Filtered Monsters";
} else {
    $monsters = $monstersModel->getAllMonsters($page);
    $pageTitle = "All Monsters";
}

// Get filter options for the filter form
$monsterTypes = $monstersModel->getMonsterTypes();
$monsterUndeadTypes = $monstersModel->getMonsterUndeadTypes();

// Define level ranges for filter dropdown
$levelRanges = [
    '1-10' => 'Level 1-10 (Beginners)',
    '11-30' => 'Level 11-30 (Low Level)',
    '31-50' => 'Level 31-50 (Mid Level)',
    '51-70' => 'Level 51-70 (High Level)',
    '71-90' => 'Level 71-90 (Elite)',
    '91-999' => 'Level 91+ (Legendary)'
];

// Include header
$heroTitle = "Monsters Database";
$heroSubtitle = "Discover all creatures and monsters in the game world";
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
            
            <!-- Filters -->
            <div class="filters">
                <form action="index.php" method="get" class="filter-form filter-form-inline">
                    <div class="filter-group">
                        <label for="family" class="filter-label">Family</label>
                        <select id="family" name="family" class="filter-select">
                            <option value="">All Families</option>
                            <?php foreach ($monsterTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type); ?>" <?php echo (isset($filters['family']) && $filters['family'] === $type) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="undead" class="filter-label">Type</label>
                        <select id="undead" name="undead" class="filter-select">
                            <option value="">All Types</option>
                            <option value="NONE" <?php echo (isset($filters['undead']) && $filters['undead'] === 'NONE') ? 'selected' : ''; ?>>Normal</option>
                            <?php foreach ($monsterUndeadTypes as $undead): ?>
                            <option value="<?php echo htmlspecialchars($undead); ?>" <?php echo (isset($filters['undead']) && $filters['undead'] === $undead) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($undead); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="level_range" class="filter-label">Level Range</label>
                        <select id="level_range" name="level_range" class="filter-select">
                            <option value="">All Levels</option>
                            <?php foreach ($levelRanges as $range => $label): ?>
                            <option value="<?php echo $range; ?>" <?php echo (isset($_GET['level_range']) && $_GET['level_range'] === $range) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="is_agro" class="filter-label">Behavior</label>
                        <select id="is_agro" name="is_agro" class="filter-select">
                            <option value="">All</option>
                            <option value="0" <?php echo (isset($_GET['is_agro']) && $_GET['is_agro'] === '0') ? 'selected' : ''; ?>>Peaceful</option>
                            <option value="1" <?php echo (isset($_GET['is_agro']) && $_GET['is_agro'] === '1') ? 'selected' : ''; ?>>Aggressive</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="is_boss" class="filter-label">Boss</label>
                        <select id="is_boss" name="is_boss" class="filter-select">
                            <option value="">All</option>
                            <option value="0" <?php echo (isset($_GET['is_boss']) && $_GET['is_boss'] === '0') ? 'selected' : ''; ?>>Normal</option>
                            <option value="1" <?php echo (isset($_GET['is_boss']) && $_GET['is_boss'] === '1') ? 'selected' : ''; ?>>Boss</option>
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
                Showing <?php echo count($monsters['data']); ?> of <?php echo number_format($monsters['total_records']); ?> monsters
            </p>
            
            <!-- Monsters Grid -->
            <div class="card-grid">
                <?php if (empty($monsters['data'])): ?>
                <div class="no-results">
                    <p>No monsters found. Please try a different search or filter.</p>
                </div>
                <?php else: ?>
                    <?php foreach ($monsters['data'] as $monster): ?>
                    <div class="card monster-card">
                        <a href="detail.php?id=<?php echo $monster['npcid']; ?>" class="card-link-overlay"></a>
                        <div class="card-header">
                            <div class="monster-level-badge level-<?php echo min(floor($monster['lvl'] / 10), 9); ?>">
                                Lv. <?php echo $monster['lvl']; ?>
                            </div>
                            <div class="monster-type-badges">
                                <?php if ($monster['impl'] === 'L1BlackKnight'): ?>
                                <span class="monster-type-badge blackknight">Knight</span>
                                <?php elseif ($monster['impl'] === 'L1Doppelganger'): ?>
                                <span class="monster-type-badge doppelganger">Doppel</span>
                                <?php endif; ?>
                                
                                <?php if (isset($monster['is_bossmonster']) && $monster['is_bossmonster'] === 'true'): ?>
                                <span class="monster-type-badge boss">Boss</span>
                                <?php endif; ?>
                                
                                <?php if ($monster['is_agro'] === 'true'): ?>
                                <span class="monster-type-badge aggressive">Aggressive</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-img-container">
                            <?php if ($monster['spriteId']): ?>
                            <img src="../../assets/img/icons/ms<?php echo $monster['spriteId']; ?>.png" 
                                 alt="<?php echo htmlspecialchars($monster['desc_en']); ?>" 
                                 class="card-img monster-sprite"
                                 onerror="this.src='../../assets/img/placeholders/monster.png'">
                            <?php else: ?>
                            <img src="../../assets/img/placeholders/monster.png" alt="No image" class="card-img monster-sprite">
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars($monster['desc_en']); ?></h3>
                            <?php if (!empty($monster['desc_kr'])): ?>
                            <p class="monster-kr-name"><?php echo htmlspecialchars($monster['desc_kr']); ?></p>
                            <?php endif; ?>
                            
                            <div class="card-stats monster-stats">
                                <div class="card-stat">
                                    <span class="card-stat-label">HP:</span>
                                    <span class="card-stat-value"><?php echo number_format($monster['hp']); ?></span>
                                </div>
                                <div class="card-stat">
                                    <span class="card-stat-label">EXP:</span>
                                    <span class="card-stat-value"><?php echo number_format($monster['exp']); ?></span>
                                </div>
                                <?php if (!empty($monster['family'])): ?>
                                <div class="card-stat">
                                    <span class="card-stat-label">Family:</span>
                                    <span class="card-stat-value"><?php echo htmlspecialchars($monster['family']); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if ($monster['undead'] !== 'NONE'): ?>
                                <div class="card-stat">
                                    <span class="card-stat-label">Type:</span>
                                    <span class="card-stat-value"><?php echo htmlspecialchars($monster['undead']); ?></span>
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
            <?php if ($monsters['total_pages'] > 1): ?>
            <div class="pagination">
                <?php
                $queryParams = [];
                if (!empty($searchTerm)) $queryParams['q'] = $searchTerm;
                if (!empty($filters)) {
                    $queryParams['filter'] = '1';
                    foreach ($filters as $key => $value) {
                        if ($key === 'min_level' || $key === 'max_level') {
                            // Reconstruct level_range for URL
                            if (isset($filters['min_level']) && isset($filters['max_level'])) {
                                $queryParams['level_range'] = $filters['min_level'] . '-' . $filters['max_level'];
                            }
                        } else {
                            $queryParams[$key] = $value;
                        }
                    }
                    // Convert is_agro and is_boss back to 0/1 for URL
                    if (isset($queryParams['is_agro'])) {
                        $queryParams['is_agro'] = $queryParams['is_agro'] === 'true' ? '1' : '0';
                    }
                    if (isset($queryParams['is_boss'])) {
                        $queryParams['is_boss'] = $queryParams['is_boss'] === 'true' ? '1' : '0';
                    }
                }
                $baseQuery = !empty($queryParams) ? '&' . http_build_query($queryParams) : '';
                ?>
                
                <?php if ($monsters['current_page'] > 1): ?>
                <a href="?page=<?php echo $monsters['current_page'] - 1; ?><?php echo $baseQuery; ?>" class="pagination-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $monsters['current_page'] - 2);
                $endPage = min($monsters['total_pages'], $monsters['current_page'] + 2);
                
                if ($startPage > 1): ?>
                <a href="?page=1<?php echo $baseQuery; ?>" class="pagination-link">1</a>
                <?php if ($startPage > 2): ?>
                <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo $baseQuery; ?>" class="pagination-link <?php echo $i === $monsters['current_page'] ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
                <?php endfor; ?>
                
                <?php if ($endPage < $monsters['total_pages']): ?>
                <?php if ($endPage < $monsters['total_pages'] - 1): ?>
                <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $monsters['total_pages']; ?><?php echo $baseQuery; ?>" class="pagination-link">
                    <?php echo $monsters['total_pages']; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($monsters['current_page'] < $monsters['total_pages']): ?>
                <a href="?page=<?php echo $monsters['current_page'] + 1; ?><?php echo $baseQuery; ?>" class="pagination-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
/* Monster-specific styles */
.monster-card {
    position: relative;
}

.monster-level-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Level-based color coding */
.level-0, .level-1 { background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); } /* Green - Levels 0-19 */
.level-2, .level-3 { background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); } /* Blue - Levels 20-39 */
.level-4, .level-5 { background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%); } /* Purple - Levels 40-59 */
.level-6, .level-7 { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); } /* Orange - Levels 60-79 */
.level-8, .level-9 { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); } /* Red - Levels 80+ */

.monster-type-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    margin-top: 0.5rem;
}

.monster-type-badge {
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.125rem 0.5rem;
    border-radius: 8px;
    font-size: 0.625rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.monster-type-badge.blackknight {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
}

.monster-type-badge.doppelganger {
    background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
}

.monster-type-badge.boss {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
}

.monster-type-badge.aggressive {
    background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
}

.monster-sprite {
    width: 48px;
    height: 48px;
    object-fit: contain;
    image-rendering: pixelated;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
}

.monster-kr-name {
    color: #6b7280;
    font-size: 0.875rem;
    font-style: italic;
    margin: 0.25rem 0 0.5rem 0;
}

.monster-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.25rem;
}

.monster-stats .card-stat {
    font-size: 0.75rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.monster-type-badges {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .filter-form-inline {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .filter-actions {
        grid-column: 1;
    }
    
    .monster-stats {
        grid-template-columns: 1fr;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .monster-type-badges {
        flex-direction: row;
        align-items: flex-start;
    }
}
</style>

<?php include '../../includes/footer.php'; ?> 