<?php
// database-explorer-table-data.php
// This file is included by database-explorer-tables.php when viewing table data

// Calculate pagination
$offset = ($page - 1) * $perPage;
$totalRows = $pdo->query("SELECT COUNT(*) FROM `$selectedTable`")->fetchColumn();
$totalPages = ceil($totalRows / $perPage);

// Get sample data
$sampleData = $pdo->query("SELECT * FROM `$selectedTable` LIMIT $offset, $perPage")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="admin-form-section">
    <h3 class="admin-form-section-title">
        Table Data (Page <?php echo $page; ?> of <?php echo $totalPages; ?>) - Total Records: <?php echo number_format($totalRows); ?>
    </h3>
    <div class="admin-table-container" style="overflow-x: auto;">
        <table class="admin-table" style="min-width: 100%;">
            <thead>
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <th><?php echo htmlspecialchars($column['Field']); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sampleData)): ?>
                    <tr>
                        <td colspan="<?php echo count($columns); ?>" class="admin-table-empty">
                            No data found in this table.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($sampleData as $row): ?>
                        <tr>
                            <?php foreach ($columns as $column): ?>
                                <td>
                                    <?php 
                                    $value = $row[$column['Field']];
                                    if ($value === null) {
                                        echo '<em style="color: var(--admin-light);">NULL</em>';
                                    } elseif (strlen($value) > 50) {
                                        echo '<div class="expandable-value" data-full="' . htmlspecialchars($value) . '">' . 
                                             htmlspecialchars(substr($value, 0, 50)) . '... ' .
                                             '<a href="#" class="expand-link" onclick="expandValue(this); return false;">[+]</a></div>';
                                    } else {
                                        echo htmlspecialchars($value);
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if ($totalPages > 1): ?>
        <div class="admin-pagination">
            <?php if ($page > 1): ?>
                <a href="?mode=tables&table=<?php echo urlencode($selectedTable); ?>&view_data=1&page=1" class="admin-pagination-link">
                    <i class="fas fa-angle-double-left"></i> First
                </a>
                <a href="?mode=tables&table=<?php echo urlencode($selectedTable); ?>&view_data=1&page=<?php echo $page - 1; ?>" class="admin-pagination-link">
                    <i class="fas fa-angle-left"></i> Previous
                </a>
            <?php endif; ?>
            
            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);
            
            if ($start > 1): ?>
                <span class="admin-pagination-ellipsis">...</span>
            <?php endif;
            
            for ($i = $start; $i <= $end; $i++): ?>
                <a href="?mode=tables&table=<?php echo urlencode($selectedTable); ?>&view_data=1&page=<?php echo $i; ?>" 
                   class="admin-pagination-link <?php echo $i === $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor;
            
            if ($end < $totalPages): ?>
                <span class="admin-pagination-ellipsis">...</span>
            <?php endif; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?mode=tables&table=<?php echo urlencode($selectedTable); ?>&view_data=1&page=<?php echo $page + 1; ?>" class="admin-pagination-link">
                    Next <i class="fas fa-angle-right"></i>
                </a>
                <a href="?mode=tables&table=<?php echo urlencode($selectedTable); ?>&view_data=1&page=<?php echo $totalPages; ?>" class="admin-pagination-link">
                    Last <i class="fas fa-angle-double-right"></i>
                </a>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center; margin-top: 10px; color: var(--admin-light); font-size: 0.9rem;">
            Showing <?php echo number_format($offset + 1); ?> to <?php echo number_format(min($offset + $perPage, $totalRows)); ?> of <?php echo number_format($totalRows); ?> records
        </div>
    <?php endif; ?>
</div>