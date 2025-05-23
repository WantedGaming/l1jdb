<?php
// database-explorer-overview.php
// This file is included by database-explorer.php

$dbInfo = $pdo->query("
    SELECT 
        SCHEMA_NAME as db_name,
        DEFAULT_CHARACTER_SET_NAME as charset,
        DEFAULT_COLLATION_NAME as collation
    FROM information_schema.SCHEMATA
    WHERE SCHEMA_NAME = DATABASE()
")->fetch(PDO::FETCH_ASSOC);

$tableCount = count($tables);
$totalSize = $pdo->query("
    SELECT round(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb 
    FROM information_schema.TABLES 
    WHERE table_schema = DATABASE()
")->fetchColumn();

$totalRows = $pdo->query("
    SELECT SUM(table_rows) 
    FROM information_schema.TABLES 
    WHERE table_schema = DATABASE()
")->fetchColumn();
?>

<div class="admin-stats">
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <h3 class="admin-stat-title">Database</h3>
            <i class="fas fa-database admin-stat-icon"></i>
        </div>
        <div class="admin-stat-value"><?php echo htmlspecialchars($dbInfo['db_name']); ?></div>
        <span class="admin-stat-link"><?php echo htmlspecialchars($dbInfo['charset']); ?> / <?php echo htmlspecialchars($dbInfo['collation']); ?></span>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <h3 class="admin-stat-title">Total Tables</h3>
            <i class="fas fa-table admin-stat-icon"></i>
        </div>
        <div class="admin-stat-value"><?php echo number_format($tableCount); ?></div>
        <a href="?mode=tables" class="admin-stat-link">View All Tables</a>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <h3 class="admin-stat-title">Total Rows</h3>
            <i class="fas fa-list admin-stat-icon"></i>
        </div>
        <div class="admin-stat-value"><?php echo number_format($totalRows); ?></div>
        <span class="admin-stat-link">Across all tables</span>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <h3 class="admin-stat-title">Database Size</h3>
            <i class="fas fa-hdd admin-stat-icon"></i>
        </div>
        <div class="admin-stat-value"><?php echo $totalSize; ?> MB</div>
        <span class="admin-stat-link">Total storage used</span>
    </div>
</div>

<div class="admin-stats-section">
    <h3 class="admin-section-title">Largest Tables</h3>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Table Name</th>
                    <th>Row Count</th>
                    <th>Size (MB)</th>
                    <th>% of Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $largestTables = $pdo->query("
                    SELECT table_name, 
                           table_rows as row_count,
                           round(((data_length + index_length) / 1024 / 1024), 2) as size_mb 
                    FROM information_schema.TABLES 
                    WHERE table_schema = DATABASE()
                    ORDER BY size_mb DESC
                    LIMIT 10
                ")->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($largestTables as $table): 
                    $percentOfTotal = $totalSize > 0 ? round(($table['size_mb'] / $totalSize) * 100, 1) : 0;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($table['table_name']); ?></td>
                        <td><?php echo number_format($table['row_count']); ?></td>
                        <td><?php echo $table['size_mb']; ?></td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div style="width: 50px;"><?php echo $percentOfTotal; ?>%</div>
                                <div style="flex-grow: 1; height: 8px; background-color: rgba(255,255,255,0.1); border-radius: 4px;">
                                    <div style="width: <?php echo $percentOfTotal; ?>%; height: 100%; background-color: var(--admin-accent); border-radius: 4px;"></div>
                                </div>
                            </div>
                        </td>
                        <td class="admin-actions">
                            <a href="?mode=tables&table=<?php echo urlencode($table['table_name']); ?>" 
                               class="admin-button admin-button-primary" title="View Table">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>