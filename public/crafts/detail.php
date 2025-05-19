<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/functions.php';

// Craft ID from URL
$craft_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize Database
$db = Database::getInstance();

// Get craft basic info
$craftInfo = $db->fetchOne("SELECT * FROM craft_info WHERE craft_id = ?", [$craft_id]);

// Get detailed craft data
$craftData = $db->fetchOne("SELECT * FROM bin_craft_common WHERE craft_id = ?", [$craft_id]);

// Get NPCs that can perform this craft
$craftNpcs = $db->fetchAll("SELECT * FROM craft_npcs WHERE craft_id_list LIKE ?", ["%$craft_id%"]);

// If craft doesn't exist, redirect to crafts list
if (!$craftInfo) {
    header('Location: index.php');
    exit;
}

// Parse inputs (required items)
$inputItems = [];
if (!empty($craftData['inputs_arr_input_item'])) {
    $inputItems = json_decode($craftData['inputs_arr_input_item'], true) ?: [];
}

// Parse optional items
$optionalItems = [];
if (!empty($craftData['inputs_arr_option_item'])) {
    $optionalItems = json_decode($craftData['inputs_arr_option_item'], true) ?: [];
}

// Parse success outputs
$successOutputs = [];
if (!empty($craftData['outputs_success'])) {
    $successOutputs = json_decode($craftData['outputs_success'], true) ?: [];
}

// Parse failure outputs
$failureOutputs = [];
if (!empty($craftData['outputs_failure'])) {
    $failureOutputs = json_decode($craftData['outputs_failure'], true) ?: [];
}

// Function to get item details by ID
function getItemDetails($itemId, $db) {
    // Try to find in weapon table
    $item = $db->fetchOne("SELECT item_id, desc_en, type, iconId, itemGrade FROM weapon WHERE item_id = ?", [$itemId]);
    
    if (!$item) {
        // Try armor table
        $item = $db->fetchOne("SELECT item_id, desc_en, type, iconId, itemGrade FROM armor WHERE item_id = ?", [$itemId]);
    }
    
    if (!$item) {
        // Try etcitem table
        $item = $db->fetchOne("SELECT item_id, desc_en, item_type as type, iconId, itemGrade FROM etcitem WHERE item_id = ?", [$itemId]);
    }
    
    return $item;
}

// Get success probability percentage
$successProbability = isset($craftInfo['probability_million']) ? 
    number_format($craftInfo['probability_million'] / 10000, 2) : 0;

// Format success probability for display
$formattedProbability = $successProbability . '%';

// Page title
$pageTitle = $craftInfo['name'] . " - Craft Details";

// Include header
include_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/header.php';

// Include hero section
include_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/hero.php';

// Include crafting CSS
$craftingCssPath = $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/assets/css/crafting.css';
if (file_exists($craftingCssPath)) {
    $craftingCss = '<style>' . file_get_contents($craftingCssPath) . '</style>';
    echo $craftingCss;
}
?>

<div class="detail-section">
    <div class="container">
        <!-- Page Title -->
        <div class="detail-title-card">
            <span class="detail-category">Recipe</span>
            <h1 class="detail-title"><?php echo htmlspecialchars($craftInfo['name']); ?></h1>
            <div class="detail-subtitle"><?php echo htmlspecialchars($craftInfo['desc_kr']); ?></div>
            <div class="detail-id">Craft ID: <?php echo $craft_id; ?></div>
        </div>
        
        <!-- Main Content Layout -->
        <div class="detail-layout">
            <!-- Left Column: Craft Information -->
            <div class="detail-stats-card">
                <h2 class="detail-stat-title">Craft Information</h2>
                <div class="detail-stats single-column">
                    <div class="detail-stat-group">
                        <div class="detail-stat">
                            <div class="detail-stat-label">Success Rate</div>
                            <div class="detail-stat-value craft-success-rate"><?php echo $formattedProbability; ?></div>
                        </div>
                        
                        <?php if ($craftData['min_level'] > 0): ?>
                        <div class="detail-stat">
                            <div class="detail-stat-label">Min Level</div>
                            <div class="detail-stat-value"><?php echo $craftData['min_level']; ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($craftData['max_level'] > 0): ?>
                        <div class="detail-stat">
                            <div class="detail-stat-label">Max Level</div>
                            <div class="detail-stat-value"><?php echo $craftData['max_level']; ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($craftData['batch_delay_sec'] > 0): ?>
                        <div class="detail-stat">
                            <div class="detail-stat-label">Crafting Time</div>
                            <div class="detail-stat-value"><?php echo $craftData['batch_delay_sec']; ?> seconds</div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($craftData['max_count'] > 0): ?>
                        <div class="detail-stat">
                            <div class="detail-stat-label">Max Count</div>
                            <div class="detail-stat-value"><?php echo $craftData['max_count']; ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($craftData['required_classes'] > 0): ?>
                        <div class="detail-stat">
                            <div class="detail-stat-label">Required Classes</div>
                            <div class="detail-stat-value">Class restriction: <?php echo $craftData['required_classes']; ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="detail-stat">
                            <div class="detail-stat-label">Success Type</div>
                            <div class="detail-stat-value"><?php echo $craftData['SuccessCountType']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Materials Required -->
            <div class="detail-stats-card">
                <h2 class="detail-stat-title">Materials Required</h2>
                <div class="craft-materials">
                    <?php if (empty($inputItems)): ?>
                    <p class="detail-placeholder-text">No materials required.</p>
                    <?php else: ?>
                    <div class="craft-materials-grid">
                        <?php foreach ($inputItems as $input): ?>
                            <?php 
                            $itemId = isset($input['id']) ? $input['id'] : 0;
                            $count = isset($input['count']) ? $input['count'] : 1;
                            $itemDetails = getItemDetails($itemId, $db);
                            ?>
                            <div class="craft-material">
                                <div class="craft-material-icon">
                                    <img src="<?php echo SITE_URL; ?>/assets/img/icons/<?php echo $itemDetails['iconId']; ?>.png" alt="Material">
                                </div>
                                <div class="craft-material-info">
                                    <div class="craft-material-name">
                                        <?php echo htmlspecialchars(cleanItemName($itemDetails['desc_en'])); ?>
                                    </div>
                                    <div class="craft-material-count">
                                        <?php echo $count; ?> required
                                    </div>
                                    <div class="craft-material-grade <?php echo strtolower($itemDetails['itemGrade']); ?>">
                                        <?php echo $itemDetails['itemGrade']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($optionalItems)): ?>
                    <h3 class="craft-section-subtitle">Optional Materials</h3>
                    <div class="craft-materials-grid">
                        <?php foreach ($optionalItems as $input): ?>
                            <?php 
                            $itemId = isset($input['id']) ? $input['id'] : 0;
                            $count = isset($input['count']) ? $input['count'] : 1;
                            $itemDetails = getItemDetails($itemId, $db);
                            ?>
                            <div class="craft-material optional">
                                <div class="craft-material-icon">
                                    <img src="<?php echo SITE_URL; ?>/assets/img/icons/<?php echo $itemDetails['iconId']; ?>.png" alt="Optional Material">
                                </div>
                                <div class="craft-material-info">
                                    <div class="craft-material-name">
                                        <?php echo htmlspecialchars(cleanItemName($itemDetails['desc_en'])); ?>
                                    </div>
                                    <div class="craft-material-count">
                                        <?php echo $count; ?> optional
                                    </div>
                                    <div class="craft-material-grade <?php echo strtolower($itemDetails['itemGrade']); ?>">
                                        <?php echo $itemDetails['itemGrade']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Craft Results -->
        <div class="detail-layout">
            <!-- Success Results -->
            <div class="detail-stats-card">
                <h2 class="detail-stat-title">Success Results</h2>
                <div class="craft-results success">
                    <?php if (empty($successOutputs)): ?>
                    <p class="detail-placeholder-text">No success results defined.</p>
                    <?php else: ?>
                    <div class="craft-materials-grid">
                        <?php foreach ($successOutputs as $output): ?>
                            <?php 
                            $itemId = isset($output['id']) ? $output['id'] : 0;
                            $count = isset($output['count']) ? $output['count'] : 1;
                            $probability = isset($output['probability']) ? $output['probability'] : 100;
                            $itemDetails = getItemDetails($itemId, $db);
                            ?>
                            <div class="craft-result">
                                <div class="craft-result-icon">
                                    <img src="<?php echo SITE_URL; ?>/assets/img/icons/<?php echo $itemDetails['iconId']; ?>.png" alt="Result">
                                </div>
                                <div class="craft-result-info">
                                    <div class="craft-result-name">
                                        <?php echo htmlspecialchars(cleanItemName($itemDetails['desc_en'])); ?>
                                    </div>
                                    <div class="craft-result-count">
                                        <?php echo $count; ?> obtained
                                    </div>
                                    <div class="craft-result-probability">
                                        <?php echo number_format($probability / 100, 2); ?>% chance
                                    </div>
                                    <div class="craft-material-grade <?php echo strtolower($itemDetails['itemGrade']); ?>">
                                        <?php echo $itemDetails['itemGrade']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Failure Results -->
            <div class="detail-stats-card">
                <h2 class="detail-stat-title">Failure Results</h2>
                <div class="craft-results failure">
                    <?php if (empty($failureOutputs)): ?>
                    <p class="detail-placeholder-text">No items returned on failure.</p>
                    <?php else: ?>
                    <div class="craft-materials-grid">
                        <?php foreach ($failureOutputs as $output): ?>
                            <?php 
                            $itemId = isset($output['id']) ? $output['id'] : 0;
                            $count = isset($output['count']) ? $output['count'] : 1;
                            $probability = isset($output['probability']) ? $output['probability'] : 100;
                            $itemDetails = getItemDetails($itemId, $db);
                            ?>
                            <div class="craft-result failure">
                                <div class="craft-result-icon">
                                    <img src="<?php echo SITE_URL; ?>/assets/img/icons/<?php echo $itemDetails['iconId']; ?>.png" alt="Failure Result">
                                </div>
                                <div class="craft-result-info">
                                    <div class="craft-result-name">
                                        <?php echo htmlspecialchars(cleanItemName($itemDetails['desc_en'])); ?>
                                    </div>
                                    <div class="craft-result-count">
                                        <?php echo $count; ?> returned
                                    </div>
                                    <div class="craft-result-probability">
                                        <?php echo number_format($probability / 100, 2); ?>% chance
                                    </div>
                                    <div class="craft-material-grade <?php echo strtolower($itemDetails['itemGrade']); ?>">
                                        <?php echo $itemDetails['itemGrade']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- NPCs that can craft this item -->
        <div class="detail-npcs-section">
            <h2 class="detail-stat-title">NPCs That Can Craft This Item</h2>
            <?php if (empty($craftNpcs)): ?>
            <p class="detail-placeholder-text">No NPCs can perform this craft.</p>
            <?php else: ?>
            <div class="craft-npc-grid">
                <?php foreach ($craftNpcs as $npc): ?>
                <div class="craft-npc-card">
                    <div class="craft-npc-name"><?php echo htmlspecialchars($npc['npc_name']); ?></div>
                    <div class="craft-npc-desc"><?php echo htmlspecialchars($npc['desc_kr']); ?></div>
                    <a href="<?php echo SITE_URL; ?>/public/npcs/detail.php?id=<?php echo $npc['npc_id']; ?>" class="craft-npc-link">View NPC Details</a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Back navigation -->
        <div class="detail-footer">
            <a href="<?php echo SITE_URL; ?>/public/crafts/index.php" class="detail-back-button">
                <i class="fas fa-arrow-left"></i> Back to Craft List
            </a>
        </div>
    </div>
</div>

<?php
// Include footer
include_once $_SERVER['DOCUMENT_ROOT'] . '/l1jdb/includes/footer.php';
?>