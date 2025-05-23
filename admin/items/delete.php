<?php
// Admin item delete page with comprehensive cross-reference checking
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../classes/User.php';
require_once '../../classes/Item.php';
require_once '../../includes/functions.php';
require_once '../../includes/item-reference-functions.php';

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

// Get item ID from URL
$itemId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get item details
$item = $itemModel->getItemById($itemId);

// If item not found, redirect to list page
if (!$item) {
    header('Location: index.php');
    exit;
}

// Include the item reference functions and get comprehensive cross-references
$references = findAllItemReferences($itemId, $db, 'item');

// Handle bulk delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_delete'])) {
    $tablesToDelete = $_POST['delete_tables'] ?? [];
    $deleteType = $_POST['delete_type'] ?? 'item_only';
    
    if ($deleteType === 'item_and_references' && !empty($tablesToDelete)) {
        // Prepare tables for deletion
        $tablesToClean = [];
        foreach ($tablesToDelete as $tableName) {
            if (isset($references[$tableName])) {
                $config = getItemReferenceTableConfig()[$tableName];
                $tablesToClean[$tableName] = $config['fields'];
            }
        }
        
        // Delete references first
        $cleanupResult = deleteItemReferences($itemId, $tablesToClean, $db, $item['desc_en']);
        
        // Then delete the main item
        $itemDeleted = $itemModel->deleteItem($itemId);
        
        if ($itemDeleted && $cleanupResult['success']) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Build detailed deletion message
            $deletionDetails = "Deleted item: {$item['desc_en']} (ID: $itemId) and {$cleanupResult['total_deleted']} references from {$cleanupResult['tables_cleaned']} tables.";
            
            // Log activity
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'delete',
                $deletionDetails,
                'item',
                $itemId
            );
            
            // Store deletion report in session
            $_SESSION['deletion_report'] = $cleanupResult;
            
            // Redirect with success message
            header('Location: index.php?deleted=1&item_name=' . urlencode($item['desc_en']) . '&cleaned_references=' . $cleanupResult['total_deleted']);
            exit;
        } else {
            $errorMessage = "Failed to delete item and/or references. Please try again.";
        }
    } elseif ($deleteType === 'item_only') {
        // Delete only the main item
        if ($itemModel->deleteItem($itemId)) {
            // Get current user data
            $currentUser = $user->getCurrentUser();
            
            // Log activity
            $user->logActivity(
                $currentUser ? $currentUser['login'] : null,
                'delete',
                "Deleted item: {$item['desc_en']} (ID: $itemId) - item only, references left intact",
                'item',
                $itemId
            );
            
            // Redirect with success message
            header('Location: index.php?deleted=1&item_name=' . urlencode($item['desc_en']));
            exit;
        } else {
            $errorMessage = "Failed to delete item. Please try again.";
        }
    }
}

// Generate deletion summary
$deletionSummary = generateDeletionSummary($references);

// Set page title
$pageTitle = "Delete Item: " . cleanItemName($item['desc_en']);

// Include admin header
include '../../includes/admin-header.php';
?>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <div class="admin-header-actions">
                <h1 class="admin-page-title"><?php echo $pageTitle; ?></h1>
                <div class="admin-header-buttons">
                    <a href="index.php" class="admin-button admin-button-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Items
                    </a>
                    <a href="../../public/items/detail.php?id=<?php echo $itemId; ?>" class="admin-button admin-button-info">
                        <i class="fas fa-eye"></i> View Item
                    </a>
                </div>
            </div>
            
            <?php if (isset($errorMessage)): ?>
            <div class="admin-alert admin-alert-danger">
                <?php echo $errorMessage; ?>
            </div>
            <?php endif; ?>
            
            <!-- Item Preview -->
            <div class="admin-delete-preview">
                <div class="admin-detail-layout">
                    <!-- Image Card -->
                    <div class="admin-image-card">
                        <h3 class="admin-form-header">Item Preview</h3>
                        <div class="admin-image-container">
                            <img src="<?php echo getItemIconUrl($item['iconId']); ?>" alt="<?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?>" class="admin-image-large">
                            <div class="admin-status-indicator success">Icon: <?php echo $item['iconId']; ?></div>
                        </div>
                    </div>
                    
                    <!-- Basic Info Card -->
                    <div class="admin-form-section" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none; background-color: var(--admin-dark);">
                        <h3 class="admin-form-header">Basic Information</h3>
                        
                        <div class="admin-detail-info">
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Item ID:</div>
                                <div class="admin-detail-value"><?php echo $item['item_id']; ?></div>
                            </div>
                            
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Name (English):</div>
                                <div class="admin-detail-value"><?php echo htmlspecialchars(cleanItemName($item['desc_en'])); ?></div>
                            </div>
                            
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Name (Korean):</div>
                                <div class="admin-detail-value"><?php echo htmlspecialchars(cleanItemName($item['desc_kr'] ?? 'N/A')); ?></div>
                            </div>
                            
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Item Type:</div>
                                <div class="admin-detail-value"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['item_type']))); ?></div>
                            </div>
                            
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Use Type:</div>
                                <div class="admin-detail-value"><?php echo ucfirst(strtolower(str_replace('_', ' ', $item['use_type']))); ?></div>
                            </div>
                            
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Material:</div>
                                <div class="admin-detail-value"><?php echo formatMaterial($item['material']); ?></div>
                            </div>
                            
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Grade:</div>
                                <div class="admin-detail-value"><?php echo formatGrade($item['itemGrade']); ?></div>
                            </div>
                            
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Weight:</div>
                                <div class="admin-detail-value"><?php echo $item['weight']; ?></div>
                            </div>
                            
                            <?php if (isset($item['max_charge_count']) && $item['max_charge_count'] > 0): ?>
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Max Charges:</div>
                                <div class="admin-detail-value"><?php echo $item['max_charge_count']; ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['note'])): ?>
                            <div class="admin-detail-row">
                                <div class="admin-detail-label">Description:</div>
                                <div class="admin-detail-value"><?php echo nl2br(htmlspecialchars($item['note'])); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($references)): ?>
            <!-- Cross-Reference Analysis -->
            <div class="admin-alert admin-alert-warning">
                <h3><i class="fas fa-exclamation-triangle"></i> Cross-Reference Analysis</h3>
                <p><strong>This item is referenced in <?php echo $deletionSummary['total_tables']; ?> table(s) with <?php echo $deletionSummary['total_records']; ?> total references.</strong></p>
                
                <?php if ($deletionSummary['critical_tables'] > 0): ?>
                <div class="admin-alert admin-alert-danger" style="margin: 15px 0;">
                    <p><strong>⚠️ CRITICAL REFERENCES DETECTED (<?php echo $deletionSummary['critical_records']; ?> records):</strong></p>
                    <ul>
                        <?php foreach ($deletionSummary['warnings'] as $warning): ?>
                        <li><?php echo htmlspecialchars($warning); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- Category Summary -->
                <div class="reference-categories">
                    <h4>References by Category:</h4>
                    <div class="category-grid">
                        <?php foreach ($deletionSummary['categories'] as $category => $data): ?>
                        <div class="category-item">
                            <div class="category-name"><?php echo $data['name']; ?></div>
                            <div class="category-stats"><?php echo $data['tables']; ?> tables, <?php echo $data['records']; ?> records</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Reference Information -->
            <div class="admin-references-container">
                <h3 class="admin-form-header">Detailed Reference Analysis</h3>
                
                <?php foreach ($references as $tableName => $refData): ?>
                <div class="reference-table-section <?php echo $refData['critical'] ? 'critical' : ''; ?>">
                    <div class="reference-header">
                        <h4>
                            <?php if ($refData['critical']): ?>
                            <i class="fas fa-exclamation-circle text-danger"></i>
                            <?php else: ?>
                            <i class="fas fa-info-circle text-info"></i>
                            <?php endif; ?>
                            <?php echo htmlspecialchars($refData['display_name']); ?>
                            <span class="record-count">(<?php echo $refData['count']; ?> record<?php echo $refData['count'] != 1 ? 's' : ''; ?>)</span>
                        </h4>
                        <p class="reference-description"><?php echo htmlspecialchars($refData['description']); ?></p>
                    </div>
                    
                    <!-- Show sample records -->
                    <div class="reference-records">
                        <?php 
                        $displayRecords = array_slice($refData['records'], 0, 5); // Show first 5 records
                        $hasMore = count($refData['records']) > 5;
                        ?>
                        
                        <table class="reference-table">
                            <thead>
                                <tr>
                                    <?php foreach ($refData['display_fields'] as $field): ?>
                                    <th><?php echo ucwords(str_replace('_', ' ', $field)); ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($displayRecords as $record): ?>
                                <tr>
                                    <?php foreach ($refData['display_fields'] as $field): ?>
                                    <td>
                                        <?php 
                                        $value = isset($record[$field]) ? $record[$field] : '—';
                                        if (strlen($value) > 50) {
                                            echo htmlspecialchars(substr($value, 0, 50)) . '...';
                                        } else {
                                            echo htmlspecialchars($value);
                                        }
                                        ?>
                                    </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <?php if ($hasMore): ?>
                        <p class="text-muted">... and <?php echo count($refData['records']) - 5; ?> more record(s)</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Deletion Options -->
            <div class="admin-deletion-options">
                <h3 class="admin-form-header">Deletion Options</h3>
                
                <form method="post" id="deletionForm">
                    <div class="deletion-choice">
                        <label class="radio-option">
                            <input type="radio" name="delete_type" value="item_only" checked>
                            <div class="option-content">
                                <h4>Delete Item Only</h4>
                                <p>Delete only the main item record. All references will remain in the database (may cause broken links).</p>
                                <div class="option-warning">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                    This may leave orphaned references that could cause issues.
                                </div>
                            </div>
                        </label>
                        
                        <label class="radio-option">
                            <input type="radio" name="delete_type" value="item_and_references">
                            <div class="option-content">
                                <h4>Delete Item and All References</h4>
                                <p>Delete the main item AND clean up all references from other tables.</p>
                                <div class="option-impact">
                                    <strong>This will delete:</strong>
                                    <ul>
                                        <li>The main item record</li>
                                        <li><?php echo $deletionSummary['total_records']; ?> reference records from <?php echo $deletionSummary['total_tables']; ?> tables</li>
                                        <?php if ($deletionSummary['critical_records'] > 0): ?>
                                        <li class="critical"><strong><?php echo $deletionSummary['critical_records']; ?> CRITICAL records (player data, etc.)</strong></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Table Selection for Advanced Users -->
                    <div class="advanced-options" id="advancedOptions" style="display: none;">
                        <h4>Select Tables to Clean (Advanced)</h4>
                        <div class="table-checkboxes">
                            <?php foreach ($references as $tableName => $refData): ?>
                            <label class="table-checkbox <?php echo $refData['critical'] ? 'critical' : ''; ?>">
                                <input type="checkbox" name="delete_tables[]" value="<?php echo $tableName; ?>" checked>
                                <span class="checkbox-content">
                                    <strong><?php echo htmlspecialchars($refData['display_name']); ?></strong>
                                    <span class="record-count">(<?php echo $refData['count']; ?> records)</span>
                                    <?php if ($refData['critical']): ?>
                                    <span class="critical-badge">CRITICAL</span>
                                    <?php endif; ?>
                                </span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <a href="index.php" class="admin-button admin-button-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <a href="edit.php?id=<?php echo $itemId; ?>" class="admin-button admin-button-primary">
                            <i class="fas fa-edit"></i> Edit Instead
                        </a>
                        <button type="button" id="showAdvanced" class="admin-button admin-button-info">
                            <i class="fas fa-cog"></i> Advanced Options
                        </button>
                        <button type="submit" name="bulk_delete" class="admin-button admin-button-danger" id="deleteButton">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
            
            <?php else: ?>
            <!-- No References Found - Simple Delete -->
            <div class="admin-alert admin-alert-success">
                <h3><i class="fas fa-check-circle"></i> No References Found</h3>
                <p>This item has no references in other database tables. It can be safely deleted without affecting other data.</p>
            </div>
            
            <form method="post" class="simple-delete-form">
                <input type="hidden" name="delete_type" value="item_only">
                <div class="form-actions">
                    <a href="index.php" class="admin-button admin-button-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <a href="edit.php?id=<?php echo $itemId; ?>" class="admin-button admin-button-primary">
                        <i class="fas fa-edit"></i> Edit Instead
                    </a>
                    <button type="submit" name="bulk_delete" class="admin-button admin-button-danger" 
                            onclick="return confirm('Are you sure you want to delete this item?');">
                        <i class="fas fa-trash-alt"></i> Delete Item
                    </button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
/* Cross-Reference Analysis Styles */
.admin-references-container {
    margin: 20px 0;
    background: var(--admin-card-background);
    border-radius: 8px;
    padding: 20px;
    border: 1px solid var(--admin-border);
}

.admin-delete-preview {
    margin-bottom: 30px;
}

.admin-detail-info {
    display: grid;
    gap: 15px;
}

.admin-detail-row {
    display: grid;
    grid-template-columns: 150px 1fr;
    gap: 15px;
    padding: 10px 0;
    border-bottom: 1px solid var(--admin-border);
}

.admin-detail-row:last-child {
    border-bottom: none;
}

.admin-detail-label {
    font-weight: 600;
    color: var(--admin-text-muted);
}

.admin-detail-value {
    color: var(--admin-text);
}

.reference-categories {
    margin-top: 15px;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.category-item {
    background: var(--admin-background);
    padding: 10px;
    border-radius: 4px;
    border: 1px solid var(--admin-border);
}

.category-name {
    font-weight: 600;
    color: var(--admin-text);
}

.category-stats {
    font-size: 0.9em;
    color: var(--admin-text-muted);
}

.reference-table-section {
    margin: 20px 0;
    border: 1px solid var(--admin-border);
    border-radius: 6px;
    overflow: hidden;
}

.reference-table-section.critical {
    border-left: 4px solid #dc3545;
    background: rgba(220, 53, 69, 0.05);
}

.reference-header {
    padding: 15px;
    background: var(--admin-background);
    border-bottom: 1px solid var(--admin-border);
}

.reference-header h4 {
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.record-count {
    font-size: 0.85em;
    font-weight: normal;
    color: var(--admin-text-muted);
}

.reference-description {
    margin: 0;
    color: var(--admin-text-muted);
    font-size: 0.9em;
}

.reference-records {
    padding: 0;
}

.reference-table {
    width: 100%;
    border-collapse: collapse;
}

.reference-table th,
.reference-table td {
    padding: 8px 12px;
    text-align: left;
    border-bottom: 1px solid var(--admin-border);
}

.reference-table th {
    background: var(--admin-background);
    font-weight: 600;
    font-size: 0.85em;
    color: var(--admin-text-muted);
}

.reference-table td {
    font-size: 0.9em;
}

/* Deletion Options Styles */
.admin-deletion-options {
    margin: 20px 0;
    background: var(--admin-card-background);
    border-radius: 8px;
    padding: 20px;
    border: 1px solid var(--admin-border);
}

.deletion-choice {
    margin: 15px 0;
}

.radio-option {
    display: block;
    margin: 15px 0;
    cursor: pointer;
}

.radio-option input[type="radio"] {
    margin-right: 10px;
}

.option-content {
    background: var(--admin-background);
    border: 2px solid var(--admin-border);
    border-radius: 6px;
    padding: 15px;
    margin-left: 25px;
    transition: border-color 0.2s ease;
}

.radio-option input[type="radio"]:checked + .option-content {
    border-color: var(--admin-primary);
    background: rgba(0, 123, 255, 0.05);
}

.option-content h4 {
    margin: 0 0 8px 0;
    color: var(--admin-text);
}

.option-content p {
    margin: 0 0 10px 0;
    color: var(--admin-text-muted);
}

.option-warning {
    padding: 8px 12px;
    background: rgba(255, 193, 7, 0.1);
    border-left: 3px solid #ffc107;
    border-radius: 4px;
    font-size: 0.9em;
}

.option-impact {
    padding: 10px 12px;
    background: rgba(220, 53, 69, 0.1);
    border-left: 3px solid #dc3545;
    border-radius: 4px;
}

.option-impact ul {
    margin: 8px 0 0 20px;
    padding: 0;
}

.option-impact li.critical {
    color: #dc3545;
    font-weight: 600;
}

/* Advanced Options */
.advanced-options {
    margin: 20px 0;
    padding: 15px;
    background: var(--admin-background);
    border: 1px solid var(--admin-border);
    border-radius: 6px;
}

.table-checkboxes {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.table-checkbox {
    display: flex;
    align-items: center;
    padding: 10px;
    background: var(--admin-card-background);
    border: 1px solid var(--admin-border);
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.table-checkbox:hover {
    background: var(--admin-hover);
}

.table-checkbox.critical {
    border-left: 4px solid #dc3545;
}

.table-checkbox input[type="checkbox"] {
    margin-right: 10px;
}

.checkbox-content {
    flex: 1;
}

.critical-badge {
    background: #dc3545;
    color: white;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 0.75em;
    font-weight: 600;
    margin-left: 8px;
}

.form-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--admin-border);
}

.simple-delete-form {
    background: var(--admin-card-background);
    padding: 20px;
    border-radius: 8px;
    border: 1px solid var(--admin-border);
    text-align: center;
}

.text-danger {
    color: #dc3545;
}

.text-warning {
    color: #ffc107;
}

.text-info {
    color: #17a2b8;
}

.text-muted {
    color: var(--admin-text-muted);
    font-style: italic;
    padding: 10px;
    text-align: center;
}

@media (max-width: 768px) {
    .category-grid {
        grid-template-columns: 1fr;
    }
    
    .table-checkboxes {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .reference-table {
        font-size: 0.8em;
    }
    
    .reference-table th,
    .reference-table td {
        padding: 6px 8px;
    }
    
    .admin-detail-row {
        grid-template-columns: 1fr;
        gap: 5px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteTypeRadios = document.querySelectorAll('input[name="delete_type"]');
    const advancedOptions = document.getElementById('advancedOptions');
    const showAdvancedBtn = document.getElementById('showAdvanced');
    const deleteButton = document.getElementById('deleteButton');
    const deletionForm = document.getElementById('deletionForm');
    
    // Handle advanced options toggle
    if (showAdvancedBtn) {
        showAdvancedBtn.addEventListener('click', function() {
            if (advancedOptions.style.display === 'none') {
                advancedOptions.style.display = 'block';
                this.innerHTML = '<i class="fas fa-cog"></i> Hide Advanced';
            } else {
                advancedOptions.style.display = 'none';
                this.innerHTML = '<i class="fas fa-cog"></i> Advanced Options';
            }
        });
    }
    
    // Handle delete type changes
    deleteTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateDeleteButton();
        });
    });
    
    // Update delete button text based on selection
    function updateDeleteButton() {
        const selectedType = document.querySelector('input[name="delete_type"]:checked').value;
        if (deleteButton) {
            if (selectedType === 'item_only') {
                deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Delete Item Only';
                deleteButton.className = 'admin-button admin-button-warning';
            } else {
                deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i> Delete Item & References';
                deleteButton.className = 'admin-button admin-button-danger';
            }
        }
    }
    
    // Handle form submission with confirmation
    if (deletionForm) {
        deletionForm.addEventListener('submit', function(e) {
            const selectedType = document.querySelector('input[name="delete_type"]:checked').value;
            let confirmMessage = '';
            
            if (selectedType === 'item_only') {
                confirmMessage = 'Are you sure you want to delete this item? References will remain in the database.';
            } else {
                const checkedTables = document.querySelectorAll('input[name="delete_tables[]"]:checked');
                const totalReferences = <?php echo json_encode($deletionSummary['total_records'] ?? 0); ?>;
                const criticalReferences = <?php echo json_encode($deletionSummary['critical_records'] ?? 0); ?>;
                
                confirmMessage = `Are you sure you want to delete this item AND ${totalReferences} references from ${checkedTables.length} tables?`;
                
                if (criticalReferences > 0) {
                    confirmMessage += `\n\nWARNING: This includes ${criticalReferences} CRITICAL references (player data, etc.) that cannot be recovered!`;
                }
                
                confirmMessage += '\n\nThis action cannot be undone!';
            }
            
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        });
    }
    
    // Initialize delete button text
    updateDeleteButton();
});
</script>

<?php
// Include admin footer
include '../../includes/admin-footer.php';
?>