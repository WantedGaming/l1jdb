<?php
// database-explorer-search.php
// This file is included by database-explorer.php
?>

<div class="admin-filters">
    <form class="admin-filter-form" method="get">
        <input type="hidden" name="mode" value="search">
        <div class="admin-filter-group">
            <label class="admin-filter-label">Search Column Names</label>
            <input type="text" name="search" class="admin-filter-input" 
                   placeholder="e.g. id, name, date, status" 
                   value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
        </div>
        <div class="admin-filter-actions">
            <button type="submit" class="admin-button admin-button-primary">
                <i class="fas fa-search"></i> Search
            </button>
            <a href="?mode=search" class="admin-button admin-button-secondary">Reset</a>
        </div>
    </form>
</div>

<?php if ($searchTerm): ?>
    <?php
    $searchResults = [];
    
    foreach ($tables as $table) {
        $columns = $pdo->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            if (stripos($column['Field'], $searchTerm) !== false) {
                $searchResults[] = [
                    'table' => $table,
                    'column' => $column['Field'],
                    'type' => $column['Type'],
                    'null' => $column['Null'],
                    'key' => $column['Key'],
                    'default' => $column['Default'] ?? '',
                    'extra' => $column['Extra']
                ];
            }
        }
    }
    
    $totalResults = count($searchResults);
    ?>
    
    <div class="admin-results-count">
        Found <strong><?php echo $totalResults; ?></strong> column<?php echo $totalResults !== 1 ? 's' : ''; ?> 
        matching &quot;<strong><?php echo htmlspecialchars($searchTerm); ?></strong>&quot;
    </div>
    
    <?php if (empty($searchResults)): ?>
        <div class="admin-alert admin-alert-info">
            No columns found matching your search term. Try searching for common patterns like "id", "name", "date", etc.
        </div>
    <?php else: ?>
        <?php
        // Group results by table
        $groupedResults = [];
        foreach ($searchResults as $result) {
            $groupedResults[$result['table']][] = $result;
        }
        ?>
        
        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Tables with Matches</h3>
                    <i class="fas fa-table admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo count($groupedResults); ?></div>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Total Columns Found</h3>
                    <i class="fas fa-columns admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo $totalResults; ?></div>
            </div>
        </div>
        
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Table</th>
                        <th>Column</th>
                        <th>Type</th>
                        <th>Nullable</th>
                        <th>Key</th>
                        <th>Default</th>
                        <th>Extra</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['table']); ?></td>
                        <td><strong><?php echo htmlspecialchars($result['column']); ?></strong></td>
                        <td><?php echo htmlspecialchars($result['type']); ?></td>
                        <td>
                            <?php if ($result['null'] === 'YES'): ?>
                                <span class="admin-badge admin-badge-secondary">YES</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge-success">NO</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($result['key'] === 'PRI'): ?>
                                <span class="activity-badge create">PRIMARY</span>
                            <?php elseif ($result['key'] === 'UNI'): ?>
                                <span class="activity-badge update">UNIQUE</span>
                            <?php elseif ($result['key'] === 'MUL'): ?>
                                <span class="activity-badge view">INDEX</span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td title="<?php echo htmlspecialchars($result['default']); ?>">
                            <?php 
                            $default = $result['default'] ?: '-';
                            echo strlen($default) > 20 ? htmlspecialchars(substr($default, 0, 20)) . '...' : htmlspecialchars($default);
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($result['extra']) ?: '-'; ?></td>
                        <td class="admin-actions">
                            <a href="?mode=tables&table=<?php echo urlencode($result['table']); ?>&column=<?php echo urlencode($result['column']); ?>" 
                               class="admin-button admin-button-info" title="View Column Stats">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                            <a href="?mode=tables&table=<?php echo urlencode($result['table']); ?>" 
                               class="admin-button admin-button-secondary" title="View Table">
                                <i class="fas fa-table"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="admin-alert admin-alert-info">
        <h4>Quick Column Search</h4>
        <p>Search for columns by name. Try common patterns like:</p>
        <div class="admin-quick-links" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-top: 15px;">
            <a href="?mode=search&search=id" class="admin-button admin-button-secondary">
                <i class="fas fa-fingerprint"></i> ID columns
            </a>
            <a href="?mode=search&search=name" class="admin-button admin-button-secondary">
                <i class="fas fa-user"></i> Name fields
            </a>
            <a href="?mode=search&search=date" class="admin-button admin-button-secondary">
                <i class="fas fa-calendar"></i> Date fields
            </a>
            <a href="?mode=search&search=time" class="admin-button admin-button-secondary">
                <i class="fas fa-clock"></i> Time fields
            </a>
            <a href="?mode=search&search=price" class="admin-button admin-button-secondary">
                <i class="fas fa-dollar-sign"></i> Price fields
            </a>
            <a href="?mode=search&search=status" class="admin-button admin-button-secondary">
                <i class="fas fa-flag"></i> Status fields
            </a>
            <a href="?mode=search&search=created" class="admin-button admin-button-secondary">
                <i class="fas fa-plus-circle"></i> Created fields
            </a>
            <a href="?mode=search&search=updated" class="admin-button admin-button-secondary">
                <i class="fas fa-edit"></i> Updated fields
            </a>
        </div>
    </div>
<?php endif; ?>