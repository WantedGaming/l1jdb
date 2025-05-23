<?php
// database-explorer-column-stats.php
// This file is included by database-explorer-tables.php when a column is selected

// Get column stats
$columnInfo = null;
foreach ($columns as $col) {
    if ($col['Field'] === $selectedColumn) {
        $columnInfo = $col;
        break;
    }
}

if ($columnInfo):
    // Get distinct values count
    $distinctCount = $pdo->query("SELECT COUNT(DISTINCT `$selectedColumn`) FROM `$selectedTable`")->fetchColumn();
    $nullCount = $pdo->query("SELECT COUNT(*) FROM `$selectedTable` WHERE `$selectedColumn` IS NULL")->fetchColumn();
    
    // Get value distribution (top 20)
    $valuesQuery = $pdo->query("
        SELECT `$selectedColumn` as value, COUNT(*) as count 
        FROM `$selectedTable` 
        GROUP BY `$selectedColumn` 
        ORDER BY count DESC
        LIMIT 20
    ");
    $values = $valuesQuery->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="admin-form-section">
        <h3 class="admin-form-section-title">
            Column Analysis: <?php echo htmlspecialchars($selectedColumn); ?>
        </h3>
        
        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Distinct Values</h3>
                    <i class="fas fa-fingerprint admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($distinctCount); ?></div>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">NULL Values</h3>
                    <i class="fas fa-ban admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value"><?php echo number_format($nullCount); ?></div>
                <span class="admin-stat-link"><?php echo round(($nullCount / $tableStats['row_count']) * 100, 2); ?>% of total</span>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <h3 class="admin-stat-title">Data Type</h3>
                    <i class="fas fa-code admin-stat-icon"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 1.2rem;"><?php echo htmlspecialchars($columnInfo['Type']); ?></div>
            </div>
        </div>
        
        <h4 style="margin-top: 20px; margin-bottom: 10px; color: var(--admin-accent);">Top Values Distribution</h4>
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Value</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($values as $value): 
                        $percentage = $tableStats['row_count'] > 0 ? round(($value['count'] / $tableStats['row_count']) * 100, 2) : 0;
                        $displayValue = $value['value'] === null ? '<em>NULL</em>' : htmlspecialchars($value['value']);
                        
                        // Handle long values
                        if (strlen($displayValue) > 100) {
                            $displayValue = '<div class="expandable-value" data-full="' . htmlspecialchars($value['value']) . '">' . 
                                           htmlspecialchars(substr($value['value'], 0, 100)) . '... ' .
                                           '<a href="#" class="expand-link" onclick="expandValue(this); return false;">[Show More]</a></div>';
                        }
                    ?>
                        <tr>
                            <td><?php echo $displayValue; ?></td>
                            <td><?php echo number_format($value['count']); ?></td>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 60px; margin-right: 10px;"><?php echo $percentage; ?>%</div>
                                    <div style="flex-grow: 1; height: 10px; background-color: rgba(255,255,255,0.1); border-radius: 5px;">
                                        <div style="width: <?php echo min($percentage, 100); ?>%; height: 100%; background-color: var(--admin-accent); border-radius: 5px;"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>