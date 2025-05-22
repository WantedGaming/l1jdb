<?php
/**
 * Enhanced global helper functions for the L1J Database website
 * Consolidated common functionality from Weapon, Armor, and Item classes
 */

/**
 * Format weapon type to make it more readable
 * 
 * @param string $type The weapon type from database
 * @return string Formatted weapon type
 */
function formatWeaponType($type) {
    // List of weapon types that need special formatting
    $specialTypes = [
        'BLUNT' => 'Blunt',
        'BOW' => 'Bow',
        'CHAINSWORD' => 'Chainsword',
        'CLAW' => 'Claw',
        'DAGGER' => 'Dagger',
        'EDORYU' => 'Edoryu',
        'GAUNTLET' => 'Gauntlet',
        'KEYRINGK' => 'Keyringk',
        'SINGLE_BOW' => 'Bow (1H)',
        'SINGLE_SPEAR' => 'Spear (1H)',
        'SPEAR' => 'Spear',
        'STAFF' => 'Staff',
        'SWORD' => 'Sword',
        'TOHAND_BLUNT' => 'Blunt (2H)',
        'TOHAND_STAFF' => 'Staff (2H)',
        'TOHAND_SWORD' => 'Sword (2H)',
    ];
    
    // Check if it's a special type
    if (isset($specialTypes[strtoupper($type)])) {
        return $specialTypes[strtoupper($type)];
    }
    
    // For types not in the special list, just capitalize first letter of each word
    return ucwords(strtolower(str_replace('_', ' ', $type)));
}

/**
 * Format armor type to make it more readable
 * 
 * @param string $type The armor type from database
 * @return string Formatted armor type
 */
function formatArmorType($type) {
    // List of armor types that need special formatting
    $specialTypes = [
        'AMULET' => 'Amulet',
        'ARMOR' => 'Armor',
        'BELT' => 'Belt',
        'BOOTS' => 'Boots',
        'BOW' => 'Bow',
        'BRACER' => 'Bracer',
        'CLOAK' => 'Cloak',
        'GLOVE' => 'Glove',
        'GUARDER' => 'Guarder',
        'HELM' => 'Helm',
        'RING' => 'Ring',
        'SHIELD' => 'Shield',
        'T_SHIRT' => 'T-Shirt'
    ];
    
    // Check if it's a special type
    if (isset($specialTypes[strtoupper($type)])) {
        return $specialTypes[strtoupper($type)];
    }
    
    // For types not in the special list, just capitalize first letter of each word
    return ucwords(strtolower(str_replace('_', ' ', $type)));
}

/**
 * Format material to remove Korean text in parentheses and normalize
 * 
 * @param string $material The material from database
 * @return string Formatted material
 */
function formatMaterial($material) {
    // Remove Korean text in parentheses
    $material = preg_replace('/\([^)]*\)/', '', $material);
    
    // Remove any trailing hyphens and extra whitespace
    $material = trim(str_replace('-', '', $material));
    
    // List of materials that need special formatting
    $specialMaterials = [
        'IRON(철)' => 'Iron',
        'MITHRIL(미스릴)' => 'Mithril',
        'BONE(뼈)' => 'Bone',
        'ORIHARUKON(오리하루콘)' => 'Oriharukon',
        'SILVER(은)' => 'Silver',
        'PLASTIC(블랙미스릴)' => 'Plastic',
        'GOLD(금)' => 'Gold', 
        'METAL(금속)' => 'Metal',
        'PLATINUM(백금)' => 'Platinum',
        'DRAGON_HIDE(용비늘)' => 'Dragon Hide',
        'WOOD(나무)' => 'Wood',
        'LEATHER(가죽)' => 'Leather',
        'GEMSTONE(보석)' => 'Gemstone',
    ];
    
    // Check if it's a special material
    if (isset($specialMaterials[strtoupper($material)])) {
        return $specialMaterials[strtoupper($material)];
    }
    
    // For materials not in the special list, just capitalize first letter of each word
    return ucwords(strtolower($material));
}

/**
 * Format armor grade to make it more readable
 * 
 * @param string $grade The armor grade from database
 * @return string Formatted armor grade
 */
function formatGrade($grade) {
    // List of armor grades that need special formatting
    $gradeMap = [
        'NORMAL' => 'Normal',
        'ADVANC' => 'Advanced',
        'RARE' => 'Rare',
        'HERO' => 'Hero',
        'LEGEND' => 'Legend',
        'MYTH' => 'Myth',
        'ONLY' => 'Unique'
    ];
    
    // Check if it's a known grade
    if (isset($gradeMap[$grade])) {
        return $gradeMap[$grade];
    }
    
    // For grades not in the map, just capitalize first letter
    return ucfirst(strtolower($grade));
}

/**
 * Clean item name by removing prefix codes
 * 
 * @param string $name The item name from database (desc_en)
 * @return string Cleaned item name
 */
function cleanItemName($name) {
    // Define the prefixes to remove
    $prefixes = [
        '\aH',
        '\aF',
        '\f4',
        '\aG'
    ];
    
    // Remove each prefix
    foreach ($prefixes as $prefix) {
        $name = str_replace($prefix, '', $name);
    }
    
    // Trim any leading/trailing whitespace
    $name = trim($name);
    
    return $name;
}

// ============================================================================
// IMAGE AND ICON FUNCTIONS
// ============================================================================

/**
 * Get item icon URL with fallback to placeholder
 * Works for weapons, armor, and items
 * 
 * @param int $iconId The icon ID
 * @return string The complete URL to the icon
 */
function getItemIconUrl($iconId) {
    // For URL construction (browser access)
    $iconPath = '/assets/img/icons/' . $iconId . '.png';
    
    // For file existence check (server filesystem)
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $iconPath;
    
    // Check if icon exists
    if ($iconId > 0 && file_exists($fullPath)) {
        return SITE_URL . $iconPath;
    } else {
        return SITE_URL . '/assets/img/placeholders/0.png';
    }
}

/**
 * Get item sprite URL 
 * 
 * @param int $spriteId The sprite ID
 * @return string The complete URL to the sprite
 */
function getItemSpriteUrl($spriteId) {
    $spritePath = '/assets/img/sprites/' . $spriteId . '.png';
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $spritePath;
    
    if ($spriteId > 0 && file_exists($fullPath)) {
        return SITE_URL . $spritePath;
    } else {
        return SITE_URL . '/assets/img/placeholders/sprite.png';
    }
}

/**
 * Get monster sprite URL with PNG fallback to GIF and ms icon
 * 
 * @param int $spriteId The monster sprite ID
 * @return string The complete URL to the monster sprite
 */
function getMonsterSpriteUrl($spriteId) {
    $pngPath = '/assets/img/sprites/' . $spriteId . '.png';
    $gifPath = '/assets/img/sprites/' . $spriteId . '.gif';
    $msPath = '/assets/img/icons/ms' . $spriteId . '.png';
    
    // Check if PNG sprite exists first
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $pngPath)) {
        return SITE_URL . $pngPath;
    }
    
    // Then check if GIF sprite exists
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $gifPath)) {
        return SITE_URL . $gifPath;
    }
    
    // Finally check if ms icon exists
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $msPath)) {
        return SITE_URL . $msPath;
    }
    
    // Return placeholder if nothing exists
    return SITE_URL . '/assets/img/placeholders/monster.png';
}

// ============================================================================
// DATABASE UTILITY FUNCTIONS
// ============================================================================

/**
 * Get monsters that drop a specific item
 * 
 * @param int $itemId The item ID
 * @param Database $db Database instance
 * @return array Array of drop information
 */
function getItemDrops($itemId, $db) {
    $sql = "SELECT d.mobId, d.mobname_en, d.mobname_kr, d.moblevel, d.min, d.max, 
                  d.chance, d.Enchant, n.spriteId, n.lvl, n.hp, 
                  n.is_bossmonster  
           FROM droplist d
           JOIN npc n ON d.mobId = n.npcid 
           WHERE d.itemId = ? 
           ORDER BY d.chance DESC, n.lvl DESC";
    return $db->fetchAll($sql, [$itemId]);
}

/**
 * Check if an item has bin data
 * 
 * @param int $nameId The name ID to check
 * @param Database $db Database instance
 * @return bool Whether bin data exists
 */
function hasBinData($nameId, $db) {
    if (!$nameId || $nameId <= 0) {
        return false;
    }
    $sql = "SELECT COUNT(*) as count FROM bin_item_common WHERE name_id = ?";
    $result = $db->fetchOne($sql, [$nameId]);
    return ($result && $result['count'] > 0);
}

/**
 * Get bin item data
 * 
 * @param int $nameId The name ID
 * @param Database $db Database instance
 * @return array|null Bin data or null if not found
 */
function getBinItemData($nameId, $db) {
    if (!$nameId || $nameId <= 0) {
        return null;
    }
    $sql = "SELECT * FROM bin_item_common WHERE name_id = ?";
    return $db->fetchOne($sql, [$nameId]);
}

// ============================================================================
// RESISTANCE AND ATTRIBUTE FUNCTIONS
// ============================================================================

/**
 * Format resistance name for display
 * 
 * @param string $resistName The resistance field name
 * @return string Formatted resistance name
 */
function formatResistanceName($resistName) {
    $mapping = [
        'regist_skill' => 'Skill Resistance',
        'regist_spirit' => 'Spirit Resistance',
        'regist_dragon' => 'Dragon Resistance',
        'regist_fear' => 'Fear Resistance',
        'regist_all' => 'All Resistance',
        'regist_stone' => 'Stone Resistance',
        'regist_sleep' => 'Sleep Resistance',
        'regist_freeze' => 'Freeze Resistance',
        'regist_blind' => 'Blind Resistance',
        'hitup_skill' => 'Skill Hit',
        'hitup_spirit' => 'Spirit Hit',
        'hitup_dragon' => 'Dragon Hit',
        'hitup_fear' => 'Fear Hit',
        'hitup_all' => 'All Hit',
        'hitup_magic' => 'Magic Hit'
    ];
    
    return isset($mapping[$resistName]) ? $mapping[$resistName] : ucfirst(str_replace('_', ' ', $resistName));
}

/**
 * Get the class name display for equipment restrictions
 * 
 * @param array $item Item data with use_* fields
 * @return array Array of class restrictions
 */
function getClassRestrictions($item) {
    $classes = [
        'royal' => 'Royal',
        'knight' => 'Knight',
        'mage' => 'Mage',
        'elf' => 'Elf',
        'darkelf' => 'Dark Elf',
        'dragonknight' => 'Dragon Knight',
        'illusionist' => 'Illusionist',
        'warrior' => 'Warrior',
        'fencer' => 'Fencer',
        'lancer' => 'Lancer'
    ];
    
    $restrictions = [];
    foreach ($classes as $key => $name) {
        $restrictions[$key] = [
            'name' => $name,
            'can_use' => isset($item['use_' . $key]) ? (bool)$item['use_' . $key] : false
        ];
    }
    
    return $restrictions;
}

// ============================================================================
// ITEM FILTERING UTILITY FUNCTIONS
// ============================================================================

/**
 * Get grade order for sorting
 * 
 * @return array Grade order for MySQL FIELD() sorting
 */
function getGradeOrder() {
    return ['ONLY', 'MYTH', 'LEGEND', 'HERO', 'RARE', 'ADVANC', 'NORMAL'];
}

/**
 * Generate grade filter SQL
 * 
 * @param string $table Table name (weapon, armor, etcitem)
 * @return string SQL for ordering by grade
 */
function getGradeOrderSql($table = '') {
    $prefix = $table ? $table . '.' : '';
    $grades = implode("', '", getGradeOrder());
    return "FIELD({$prefix}itemGrade, '{$grades}')";
}

/**
 * Get distinct values from a table column
 * 
 * @param Database $db Database instance
 * @param string $table Table name
 * @param string $column Column name
 * @param string $where Optional WHERE clause
 * @param array $params Optional parameters for WHERE clause
 * @param string $orderBy Optional ORDER BY clause
 * @return array Array of distinct values
 */
function getDistinctValues($db, $table, $column, $where = '', $params = [], $orderBy = '') {
    $sql = "SELECT DISTINCT {$column} FROM {$table}";
    
    if ($where) {
        $sql .= " WHERE {$where}";
    }
    
    if ($orderBy) {
        $sql .= " ORDER BY {$orderBy}";
    } else {
        $sql .= " ORDER BY {$column}";
    }
    
    $results = $db->fetchAll($sql, $params);
    
    $values = [];
    foreach ($results as $result) {
        $values[] = $result[$column];
    }
    
    return $values;
}

// ============================================================================
// DISPLAY UTILITY FUNCTIONS
// ============================================================================

/**
 * Format stat bonus for display with + prefix for positive values
 * 
 * @param int $value The stat value
 * @return string Formatted stat value
 */
function formatStatBonus($value) {
    if ($value == 0) {
        return '—';
    }
    return $value > 0 ? '+' . $value : (string)$value;
}

/**
 * Format percentage value
 * 
 * @param float $value The percentage value
 * @param int $decimals Number of decimal places
 * @return string Formatted percentage
 */
function formatPercentage($value, $decimals = 1) {
    if ($value == 0) {
        return '—';
    }
    return number_format($value, $decimals) . '%';
}

/**
 * Format damage range display
 * 
 * @param int $small Small damage value
 * @param int $large Large damage value
 * @return string Formatted damage range
 */
function formatDamageRange($small, $large) {
    if ($small == 0 && $large == 0) {
        return '—';
    }
    return $small . ' - ' . $large;
}

/**
 * Check if item has any stat bonuses
 * 
 * @param array $item Item data
 * @param array $stats Array of stat field names to check
 * @return bool Whether any stat bonuses exist
 */
function hasStatBonuses($item, $stats = ['add_str', 'add_con', 'add_dex', 'add_int', 'add_wis', 'add_cha']) {
    foreach ($stats as $stat) {
        if (isset($item[$stat]) && $item[$stat] != 0) {
            return true;
        }
    }
    return false;
}

/**
 * Check if item has any resistances
 * 
 * @param array $item Item data
 * @param array $resistances Array of resistance field names to check
 * @return bool Whether any resistances exist
 */
function hasResistances($item, $resistances = ['regist_skill', 'regist_spirit', 'regist_dragon', 'regist_fear', 'regist_all']) {
    foreach ($resistances as $resistance) {
        if (isset($item[$resistance]) && $item[$resistance] != 0) {
            return true;
        }
    }
    
    // Also check for poison resistance
    if (isset($item['poisonRegist']) && $item['poisonRegist'] == 'true') {
        return true;
    }
    
    return false;
}

// ============================================================================
// PAGINATION UTILITY FUNCTIONS
// ============================================================================

/**
 * Generate pagination URL with preserved parameters
 * 
 * @param int $page Page number
 * @param array $params Additional parameters to preserve
 * @return string Generated URL
 */
function getPaginationUrl($page, $params = []) {
    $params['page'] = $page;
    return '?' . http_build_query($params);
}

/**
 * Generate pagination info text
 * 
 * @param int $currentPage Current page number
 * @param int $perPage Items per page
 * @param int $totalItems Total number of items
 * @return string Pagination info text
 */
function getPaginationInfo($currentPage, $perPage, $totalItems) {
    $start = ($currentPage - 1) * $perPage + 1;
    $end = min($currentPage * $perPage, $totalItems);
    
    return "Showing {$start} to {$end} of {$totalItems} items";
}

// ============================================================================
// DEBUGGING AND LOGGING FUNCTIONS
// ============================================================================

/**
 * Log database query for debugging
 * 
 * @param string $query SQL query
 * @param array $params Query parameters
 * @param float $executionTime Execution time in seconds
 */
function logQuery($query, $params = [], $executionTime = 0) {
    if (defined('DEBUG_QUERIES') && DEBUG_QUERIES) {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'query' => $query,
            'params' => $params,
            'execution_time' => $executionTime
        ];
        
        error_log('DB Query: ' . json_encode($logEntry));
    }
}

/**
 * Generate a cache key for database results
 * 
 * @param string $prefix Cache key prefix
 * @param array $params Parameters to include in cache key
 * @return string Generated cache key
 */
function generateCacheKey($prefix, $params = []) {
    $key = $prefix . '_' . md5(serialize($params));
    return $key;
}