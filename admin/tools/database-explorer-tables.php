<?php
// database-explorer-tables.php
// This file is included by database-explorer.php
?>

<div class="admin-filters">
    <form class="admin-filter-form" method="get">
        <input type="hidden" name="mode" value="tables">
        <div class="admin-filter-group">
            <label class="admin-filter-label">Select Table</label>
            <select name="table" class="admin-filter-select" onchange="this.form.submit()">
                <option value="">-- Select a Table --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo htmlspecialchars($table); ?>" <?php echo $selectedTable === $table ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($table); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>

<?php if ($selectedTable): ?>
    <?php
    // Get table structure
    $columns = $pdo->query("DESCRIBE `$selectedTable`")->fetchAll(PDO::FETCH_ASSOC);
    
    // Get table stats
    $tableStats = $pdo->query("
        SELECT 
            table_rows as row_count,
            round(((data_length + index_length) / 1024 / 1024), 2) as size_mb,
            create_time,
            update_time
        FROM information_schema.TABLES 
        WHERE table_schema = DATABASE() AND table_name = '$selectedTable'
    ")->fetch(PDO::FETCH_ASSOC);
    ?>
    
    <div class="admin-results-count">
        Table: <strong><?php echo htmlspecialchars($selectedTable); ?></strong> | 
        Rows: <strong><?php echo number_format($tableStats['row_count']); ?></strong> | 
        Size: <strong><?php echo $tableStats['size_mb']; ?> MB</strong> |
        Columns: <strong><?php echo count($columns); ?></strong>
    </div>

    <div class="admin-content-area">
        <div class="admin-main-content">
            <div class="admin-form-container">
                <div class="admin-form-section">
                    <h3 class="admin-form-section-title">Table Structure</h3>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Nullable</th>
                                    <th>Key</th>
                                    <th>Default</th>
                                    <th>Extra</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($columns as $column): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($column['Field']); ?></td>
                                    <td><?php echo htmlspecialchars($column['Type']); ?></td>
                                    <td>
                                        <?php if ($column['Null'] === 'YES'): ?>
                                            <span class="admin-badge admin-badge-secondary">YES</span>
                                        <?php else: ?>
                                            <span class="admin-badge admin-badge-success">NO</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($column['Key'] === 'PRI'): ?>
                                            <span class="activity-badge create">PRIMARY</span>
                                        <?php elseif ($column['Key'] === 'UNI'): ?>
                                            <span class="activity-badge update">UNIQUE</span>
                                        <?php elseif ($column['Key'] === 'MUL'): ?>
                                            <span class="activity-badge view">INDEX</span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td title="<?php echo htmlspecialchars($column['Default'] ?? 'NULL'); ?>">
                                        <?php 
                                        $default = $column['Default'] ?? 'NULL';
                                        echo strlen($default) > 20 ? htmlspecialchars(substr($default, 0, 20)) . '...' : htmlspecialchars($default);
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($column['Extra']); ?></td>
                                    <td class="admin-actions">
                                        <a href="?mode=tables&table=<?php echo urlencode($selectedTable); ?>&column=<?php echo urlencode($column['Field']); ?>" 
                                           class="admin-button admin-button-info" title="View Column Stats">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($selectedColumn): ?>
                    <?php include 'database-explorer-column-stats.php'; ?>
                <?php endif; ?>

                <?php if ($viewData): ?>
                    <?php include 'database-explorer-table-data.php'; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="admin-sidebar">
            <div class="admin-sidebar-card">
                <h3 class="admin-sidebar-title">Table Actions</h3>
                <ul class="admin-quick-links">
                    <li class="admin-quick-link">
                        <a href="?mode=tables&table=<?php echo urlencode($selectedTable); ?>&view_data=1">
                            <i class="fas fa-eye"></i> View Table Data
                        </a>
                    </li>
                    <li class="admin-quick-link">
                        <a href="?mode=search&search=<?php echo urlencode($selectedTable); ?>">
                            <i class="fas fa-search"></i> Find Similar Tables
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="admin-sidebar-card">
                <h3 class="admin-sidebar-title">Table Info</h3>
                <div style="font-size: 0.9rem; color: var(--admin-light);">
                    <?php if ($tableStats['create_time']): ?>
                        <p><strong>Created:</strong><br><?php echo date('Y-m-d H:i', strtotime($tableStats['create_time'])); ?></p>
                    <?php endif; ?>
                    <?php if ($tableStats['update_time']): ?>
                        <p><strong>Last Updated:</strong><br><?php echo date('Y-m-d H:i', strtotime($tableStats['update_time'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="admin-alert admin-alert-info">Please select a table from the dropdown above.</div>
<?php endif; ?>