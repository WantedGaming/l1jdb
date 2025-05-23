<?php
/**
 * Enhanced global helper functions for the L1J Database website
 * Complete formatting functions for Weapon, Armor, and Etcitem tables
 */

// ============================================================================
// WEAPON TABLE FORMATTING FUNCTIONS
// ============================================================================

/**
 * Format weapon item grade for display
 * 
 * @param string $grade The weapon itemGrade from database
 * @return string Formatted weapon grade
 */
function formatWeaponGrade($grade) {
    $gradeMap = [
        'ONLY' => 'Unique',
        'MYTH' => 'Mythical',
        'LEGEND' => 'Legendary',
        'HERO' => 'Heroic',
        'RARE' => 'Rare',
        'ADVANC' => 'Advanced',
        'NORMAL' => 'Normal'
    ];
    
    return isset($gradeMap[strtoupper($grade)]) ? $gradeMap[strtoupper($grade)] : ucfirst(strtolower($grade));
}

/**
 * Format weapon type for display
 * 
 * @param string $type The weapon type from database
 * @return string Formatted weapon type
 */
function formatWeaponType($type) {
    $typeMap = [
        'SWORD' => 'Sword',
        'DAGGER' => 'Dagger',
        'TOHAND_SWORD' => 'Two-Handed Sword',
        'BOW' => 'Bow',
        'SPEAR' => 'Spear',
        'BLUNT' => 'Blunt Weapon',
        'STAFF' => 'Staff',
        'STING' => 'Sting',
        'ARROW' => 'Arrow',
        'GAUNTLET' => 'Gauntlet',
        'CLAW' => 'Claw',
        'EDORYU' => 'Edoryu',
        'SINGLE_BOW' => 'Single Bow',
        'SINGLE_SPEAR' => 'Single Spear',
        'TOHAND_BLUNT' => 'Two-Handed Blunt',
        'TOHAND_STAFF' => 'Two-Handed Staff',
        'KEYRINGK' => 'Keyringk',
        'CHAINSWORD' => 'Chainsword'
    ];
    
    return isset($typeMap[strtoupper($type)]) ? $typeMap[strtoupper($type)] : ucwords(strtolower(str_replace('_', ' ', $type)));
}

/**
 * Format weapon material for display
 * 
 * @param string $material The weapon material from database
 * @return string Formatted weapon material
 */
function formatWeaponMaterial($material) {
    // Remove Korean text in parentheses first
    $cleanMaterial = preg_replace('/\([^)]*\)/', '', $material);
    $cleanMaterial = trim($cleanMaterial);
    
    $materialMap = [
        'NONE' => 'None',
        'LIQUID' => 'Liquid',
        'WAX' => 'Wax',
        'VEGGY' => 'Vegetable',
        'FLESH' => 'Flesh',
        'PAPER' => 'Paper',
        'CLOTH' => 'Cloth',
        'LEATHER' => 'Leather',
        'WOOD' => 'Wood',
        'BONE' => 'Bone',
        'DRAGON_HIDE' => 'Dragon Hide',
        'IRON' => 'Iron',
        'METAL' => 'Metal',
        'COPPER' => 'Copper',
        'SILVER' => 'Silver',
        'GOLD' => 'Gold',
        'PLATINUM' => 'Platinum',
        'MITHRIL' => 'Mithril',
        'PLASTIC' => 'Black Mithril',
        'GLASS' => 'Glass',
        'GEMSTONE' => 'Gemstone',
        'MINERAL' => 'Mineral',
        'ORIHARUKON' => 'Oriharukon',
        'DRANIUM' => 'Dranium'
    ];
    
    return isset($materialMap[strtoupper($cleanMaterial)]) ? $materialMap[strtoupper($cleanMaterial)] : ucwords(strtolower($cleanMaterial));
}

// ============================================================================
// ARMOR TABLE FORMATTING FUNCTIONS
// ============================================================================

/**
 * Format armor item grade for display
 * 
 * @param string $grade The armor itemGrade from database
 * @return string Formatted armor grade
 */
function formatArmorGrade($grade) {
    $gradeMap = [
        'ONLY' => 'Unique',
        'MYTH' => 'Mythical',
        'LEGEND' => 'Legendary',
        'HERO' => 'Heroic',
        'RARE' => 'Rare',
        'ADVANC' => 'Advanced',
        'NORMAL' => 'Normal'
    ];
    
    return isset($gradeMap[strtoupper($grade)]) ? $gradeMap[strtoupper($grade)] : ucfirst(strtolower($grade));
}

/**
 * Format armor type for display
 * 
 * @param string $type The armor type from database
 * @return string Formatted armor type
 */
function formatArmorType($type) {
    $typeMap = [
        'NONE' => 'None',
        'HELMET' => 'Helmet',
        'ARMOR' => 'Armor',
        'T_SHIRT' => 'T-Shirt',
        'CLOAK' => 'Cloak',
        'GLOVE' => 'Gloves',
        'BOOTS' => 'Boots',
        'SHIELD' => 'Shield',
        'AMULET' => 'Amulet',
        'RING' => 'Ring',
        'BELT' => 'Belt',
        'RING_2' => 'Ring (2nd)',
        'EARRING' => 'Earring',
        'GARDER' => 'Garter',
        'RON' => 'Ron',
        'PAIR' => 'Pair',
        'SENTENCE' => 'Sentence',
        'SHOULDER' => 'Shoulder',
        'BADGE' => 'Badge',
        'PENDANT' => 'Pendant'
    ];
    
    return isset($typeMap[strtoupper($type)]) ? $typeMap[strtoupper($type)] : ucwords(strtolower(str_replace('_', ' ', $type)));
}

/**
 * Format armor material for display
 * 
 * @param string $material The armor material from database
 * @return string Formatted armor material
 */
function formatArmorMaterial($material) {
    // Remove Korean text in parentheses first
    $cleanMaterial = preg_replace('/\([^)]*\)/', '', $material);
    $cleanMaterial = trim($cleanMaterial);
    
    $materialMap = [
        'NONE' => 'None',
        'LIQUID' => 'Liquid',
        'WAX' => 'Wax',
        'VEGGY' => 'Vegetable',
        'FLESH' => 'Flesh',
        'PAPER' => 'Paper',
        'CLOTH' => 'Cloth',
        'LEATHER' => 'Leather',
        'WOOD' => 'Wood',
        'BONE' => 'Bone',
        'DRAGON_HIDE' => 'Dragon Hide',
        'IRON' => 'Iron',
        'METAL' => 'Metal',
        'COPPER' => 'Copper',
        'SILVER' => 'Silver',
        'GOLD' => 'Gold',
        'PLATINUM' => 'Platinum',
        'MITHRIL' => 'Mithril',
        'PLASTIC' => 'Black Mithril',
        'GLASS' => 'Glass',
        'GEMSTONE' => 'Gemstone',
        'MINERAL' => 'Mineral',
        'ORIHARUKON' => 'Oriharukon',
        'DRANIUM' => 'Dranium'
    ];
    
    return isset($materialMap[strtoupper($cleanMaterial)]) ? $materialMap[strtoupper($cleanMaterial)] : ucwords(strtolower($cleanMaterial));
}

// ============================================================================
// ETCITEM TABLE FORMATTING FUNCTIONS
// ============================================================================

/**
 * Format etcitem item grade for display
 * 
 * @param string $grade The etcitem itemGrade from database
 * @return string Formatted item grade
 */
function formatEtcitemGrade($grade) {
    $gradeMap = [
        'ONLY' => 'Unique',
        'MYTH' => 'Mythical',
        'LEGEND' => 'Legendary',
        'HERO' => 'Heroic',
        'RARE' => 'Rare',
        'ADVANC' => 'Advanced',
        'NORMAL' => 'Normal'
    ];
    
    return isset($gradeMap[strtoupper($grade)]) ? $gradeMap[strtoupper($grade)] : ucfirst(strtolower($grade));
}

/**
 * Format etcitem item type for display
 * 
 * @param string $type The etcitem item_type from database
 * @return string Formatted item type
 */
function formatEtcitemType($type) {
    $typeMap = [
        'ARROW' => 'Arrow',
        'WAND' => 'Wand',
        'LIGHT' => 'Light',
        'GEM' => 'Gem',
        'TOTEM' => 'Totem',
        'FIRE_CRACKER' => 'Firecracker',
        'POTION' => 'Potion',
        'FOOD' => 'Food',
        'SCROLL' => 'Scroll',
        'QUEST_ITEM' => 'Quest Item',
        'SPELL_BOOK' => 'Spell Book',
        'PET_ITEM' => 'Pet Item',
        'OTHER' => 'Other',
        'MATERIAL' => 'Material',
        'EVENT' => 'Event Item',
        'STING' => 'Sting',
        'TREASURE_BOX' => 'Treasure Box'
    ];
    
    return isset($typeMap[strtoupper($type)]) ? $typeMap[strtoupper($type)] : ucwords(strtolower(str_replace('_', ' ', $type)));
}

/**
 * Format etcitem use type for display
 * 
 * @param string $useType The etcitem use_type from database
 * @return string Formatted use type
 */
function formatEtcitemUseType($useType) {
    $useTypeMap = [
        'NONE' => 'None',
        'NORMAL' => 'Normal',
        'WAND1' => 'Wand (Type 1)',
        'WAND' => 'Wand',
        'SPELL_LONG' => 'Long Range Spell',
        'NTELE' => 'N-Teleport',
        'IDENTIFY' => 'Identify',
        'RES' => 'Resurrection',
        'TELEPORT' => 'Teleport',
        'INVISABLE' => 'Invisibility',
        'LETTER' => 'Letter',
        'LETTER_W' => 'Letter (W)',
        'CHOICE' => 'Choice',
        'INSTRUMENT' => 'Instrument',
        'SOSC' => 'SOSC',
        'SPELL_SHORT' => 'Short Range Spell',
        'T_SHIRT' => 'T-Shirt',
        'CLOAK' => 'Cloak',
        'GLOVE' => 'Glove',
        'BOOTS' => 'Boots',
        'HELMET' => 'Helmet',
        'RING' => 'Ring',
        'AMULET' => 'Amulet',
        'SHIELD' => 'Shield',
        'GARDER' => 'Garter',
        'DAI' => 'Dai',
        'ZEL' => 'Zel',
        'BLANK' => 'Blank',
        'BTELE' => 'B-Teleport',
        'SPELL_BUFF' => 'Buff Spell',
        'CCARD' => 'C-Card',
        'CCARD_W' => 'C-Card (W)',
        'VCARD' => 'V-Card',
        'VCARD_W' => 'V-Card (W)',
        'WCARD' => 'W-Card',
        'WCARD_W' => 'W-Card (W)',
        'BELT' => 'Belt',
        'SPELL_LONG2' => 'Long Range Spell (Type 2)',
        'EARRING' => 'Earring',
        'FISHING_ROD' => 'Fishing Rod',
        'RON' => 'Ron',
        'RON_2' => 'Ron (Type 2)',
        'ACCZEL' => 'Acczel',
        'PAIR' => 'Pair',
        'HEALING' => 'Healing',
        'SHOULDER' => 'Shoulder',
        'BADGE' => 'Badge',
        'POTENTIAL_SCROLL' => 'Potential Scroll',
        'SPELLMELT' => 'Spell Melt',
        'ELIXER_RON' => 'Elixir Ron',
        'INVENTORY_BONUS' => 'Inventory Bonus',
        'TAM_FRUIT' => 'Tam Fruit',
        'RACE_TICKET' => 'Race Ticket',
        'PAIR_2' => 'Pair (Type 2)',
        'MAGICDOLL' => 'Magic Doll',
        'SENTENCE' => 'Sentence',
        'SHOULDER_2' => 'Shoulder (Type 2)',
        'BADGE_2' => 'Badge (Type 2)',
        'PET_POTION' => 'Pet Potion',
        'GARDER_2' => 'Garter (Type 2)',
        'DOMINATION_POLY' => 'Domination Poly',
        'PENDANT' => 'Pendant',
        'SHOVEL' => 'Shovel',
        'LEV_100_POLY' => 'Level 100 Poly',
        'SMELTING' => 'Smelting',
        'PURIFY' => 'Purify',
        'CHARGED_MAP_TIME' => 'Charged Map Time'
    ];
    
    return isset($useTypeMap[strtoupper($useType)]) ? $useTypeMap[strtoupper($useType)] : ucwords(strtolower(str_replace('_', ' ', $useType)));
}

/**
 * Format etcitem material for display
 * 
 * @param string $material The etcitem material from database
 * @return string Formatted material
 */
function formatEtcitemMaterial($material) {
    // Remove Korean text in parentheses first
    $cleanMaterial = preg_replace('/\([^)]*\)/', '', $material);
    $cleanMaterial = trim($cleanMaterial);
    
    $materialMap = [
        'NONE' => 'None',
        'LIQUID' => 'Liquid',
        'WAX' => 'Wax',
        'VEGGY' => 'Vegetable',
        'FLESH' => 'Flesh',
        'PAPER' => 'Paper',
        'CLOTH' => 'Cloth',
        'LEATHER' => 'Leather',
        'WOOD' => 'Wood',
        'BONE' => 'Bone',
        'DRAGON_HIDE' => 'Dragon Hide',
        'IRON' => 'Iron',
        'METAL' => 'Metal',
        'COPPER' => 'Copper',
        'SILVER' => 'Silver',
        'GOLD' => 'Gold',
        'PLATINUM' => 'Platinum',
        'MITHRIL' => 'Mithril',
        'PLASTIC' => 'Black Mithril',
        'GLASS' => 'Glass',
        'GEMSTONE' => 'Gemstone',
        'MINERAL' => 'Mineral',
        'ORIHARUKON' => 'Oriharukon',
        'DRANIUM' => 'Dranium'
    ];
    
    return isset($materialMap[strtoupper($cleanMaterial)]) ? $materialMap[strtoupper($cleanMaterial)] : ucwords(strtolower($cleanMaterial));
}

/**
 * Format etcitem attribute for display
 * 
 * @param string $attr The etcitem attr from database
 * @return string Formatted attribute
 */
function formatEtcitemAttribute($attr) {
    $attrMap = [
        'EARTH' => 'Earth',
        'AIR' => 'Air',
        'WATER' => 'Water',
        'FIRE' => 'Fire',
        'NONE' => 'None'
    ];
    
    return isset($attrMap[strtoupper($attr)]) ? $attrMap[strtoupper($attr)] : ucfirst(strtolower($attr));
}

/**
 * Format etcitem alignment for display
 * 
 * @param string $alignment The etcitem alignment from database
 * @return string Formatted alignment
 */
function formatEtcitemAlignment($alignment) {
    $alignmentMap = [
        'CAOTIC' => 'Chaotic',
        'NEUTRAL' => 'Neutral',
        'LAWFUL' => 'Lawful',
        'NONE' => 'None'
    ];
    
    return isset($alignmentMap[strtoupper($alignment)]) ? $alignmentMap[strtoupper($alignment)] : ucfirst(strtolower($alignment));
}

/**
 * Format etcitem skill type for display
 * 
 * @param string $skillType The etcitem skill_type from database
 * @return string Formatted skill type
 */
function formatEtcitemSkillType($skillType) {
    $skillTypeMap = [
        'passive' => 'Passive',
        'active' => 'Active',
        'none' => 'None'
    ];
    
    return isset($skillTypeMap[strtolower($skillType)]) ? $skillTypeMap[strtolower($skillType)] : ucfirst(strtolower($skillType));
}

/**
 * Format etcitem limit type for display
 * 
 * @param string $limitType The etcitem limit_type from database
 * @return string Formatted limit type
 */
function formatEtcitemLimitType($limitType) {
    $limitTypeMap = [
        'WORLD_WAR' => 'World War',
        'BEGIN_ZONE' => 'Begin Zone',
        'NONE' => 'None'
    ];
    
    return isset($limitTypeMap[strtoupper($limitType)]) ? $limitTypeMap[strtoupper($limitType)] : ucwords(strtolower(str_replace('_', ' ', $limitType)));
}

// ============================================================================
// UNIVERSAL FORMATTING FUNCTIONS
// ============================================================================

/**
 * Format any item grade (works for all tables)
 * 
 * @param string $grade The itemGrade from database
 * @return string Formatted grade
 */
function formatGrade($grade) {
    $gradeMap = [
        'ONLY' => 'Unique',
        'MYTH' => 'Mythical',
        'LEGEND' => 'Legendary',
        'HERO' => 'Heroic',
        'RARE' => 'Rare',
        'ADVANC' => 'Advanced',
        'NORMAL' => 'Normal'
    ];
    
    return isset($gradeMap[strtoupper($grade)]) ? $gradeMap[strtoupper($grade)] : ucfirst(strtolower($grade));
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

/**
 * Format boolean values for display
 * 
 * @param string|int $value The boolean value from database
 * @return string Formatted boolean
 */
function formatBoolean($value) {
    if (is_string($value)) {
        return (strtolower($value) === 'true') ? 'Yes' : 'No';
    }
    return $value ? 'Yes' : 'No';
}

/**
 * Format merge status for display
 * 
 * @param string $merge The merge status from database
 * @return string Formatted merge status
 */
function formatMergeStatus($merge) {
    return (strtolower($merge) === 'true') ? 'Stackable' : 'Non-stackable';
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
// HELPER FUNCTIONS FOR FILTERING AND SORTING
// ============================================================================

/**
 * Get all possible weapon types for filtering
 * 
 * @return array Array of weapon types
 */
function getWeaponTypes() {
    return [
        'SWORD' => 'Sword',
        'DAGGER' => 'Dagger',
        'TOHAND_SWORD' => 'Two-Handed Sword',
        'BOW' => 'Bow',
        'SPEAR' => 'Spear',
        'BLUNT' => 'Blunt Weapon',
        'STAFF' => 'Staff',
        'STING' => 'Sting',
        'ARROW' => 'Arrow',
        'GAUNTLET' => 'Gauntlet',
        'CLAW' => 'Claw',
        'EDORYU' => 'Edoryu',
        'SINGLE_BOW' => 'Single Bow',
        'SINGLE_SPEAR' => 'Single Spear',
        'TOHAND_BLUNT' => 'Two-Handed Blunt',
        'TOHAND_STAFF' => 'Two-Handed Staff',
        'KEYRINGK' => 'Keyringk',
        'CHAINSWORD' => 'Chainsword'
    ];
}

/**
 * Get all possible armor types for filtering
 * 
 * @return array Array of armor types
 */
function getArmorTypes() {
    return [
        'HELMET' => 'Helmet',
        'ARMOR' => 'Armor',
        'T_SHIRT' => 'T-Shirt',
        'CLOAK' => 'Cloak',
        'GLOVE' => 'Gloves',
        'BOOTS' => 'Boots',
        'SHIELD' => 'Shield',
        'AMULET' => 'Amulet',
        'RING' => 'Ring',
        'BELT' => 'Belt',
        'RING_2' => 'Ring (2nd)',
        'EARRING' => 'Earring',
        'GARDER' => 'Garter',
        'RON' => 'Ron',
        'PAIR' => 'Pair',
        'SENTENCE' => 'Sentence',
        'SHOULDER' => 'Shoulder',
        'BADGE' => 'Badge',
        'PENDANT' => 'Pendant'
    ];
}

/**
 * Get all possible etcitem types for filtering
 * 
 * @return array Array of etcitem types
 */
function getEtcitemTypes() {
    return [
        'ARROW' => 'Arrow',
        'WAND' => 'Wand',
        'LIGHT' => 'Light',
        'GEM' => 'Gem',
        'TOTEM' => 'Totem',
        'FIRE_CRACKER' => 'Firecracker',
        'POTION' => 'Potion',
        'FOOD' => 'Food',
        'SCROLL' => 'Scroll',
        'QUEST_ITEM' => 'Quest Item',
        'SPELL_BOOK' => 'Spell Book',
        'PET_ITEM' => 'Pet Item',
        'OTHER' => 'Other',
        'MATERIAL' => 'Material',
        'EVENT' => 'Event Item',
        'STING' => 'Sting',
        'TREASURE_BOX' => 'Treasure Box'
    ];
}

/**
 * Get all available grades for filtering
 * 
 * @return array Array of grades
 */
function getAllGrades() {
    return [
        'ONLY' => 'Unique',
        'MYTH' => 'Mythical',
        'LEGEND' => 'Legendary',
        'HERO' => 'Heroic',
        'RARE' => 'Rare',
        'ADVANC' => 'Advanced',
        'NORMAL' => 'Normal'
    ];
}

/**
 * Get all available materials for filtering
 * 
 * @return array Array of materials
 */
function getAllMaterials() {
    return [
        'LIQUID' => 'Liquid',
        'WAX' => 'Wax',
        'VEGGY' => 'Vegetable',
        'FLESH' => 'Flesh',
        'PAPER' => 'Paper',
        'CLOTH' => 'Cloth',
        'LEATHER' => 'Leather',
        'WOOD' => 'Wood',
        'BONE' => 'Bone',
        'DRAGON_HIDE' => 'Dragon Hide',
        'IRON' => 'Iron',
        'METAL' => 'Metal',
        'COPPER' => 'Copper',
        'SILVER' => 'Silver',
        'GOLD' => 'Gold',
        'PLATINUM' => 'Platinum',
        'MITHRIL' => 'Mithril',
        'PLASTIC' => 'Black Mithril',
        'GLASS' => 'Glass',
        'GEMSTONE' => 'Gemstone',
        'MINERAL' => 'Mineral',
        'ORIHARUKON' => 'Oriharukon',
        'DRANIUM' => 'Dranium'
    ];
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

// ============================================================================
// MAP-RELATED FUNCTIONS
// ============================================================================

/**
 * Format map type for display based on existing table fields
 */
function formatMapType($mapData) {
    // If it's a string (already determined type), format it
    if (is_string($mapData)) {
        $types = [
            'FIELD' => 'Field Map',
            'DUNGEON' => 'Dungeon',
            'UNDERWATER' => 'Underwater',
            'SPECIAL' => 'Special Zone',
            'COMBAT' => 'Combat Zone',
            'SAFETY' => 'Safety Zone',
            'NORMAL' => 'Normal Zone'
        ];
        return $types[strtoupper($mapData)] ?? ucfirst(strtolower($mapData));
    }
    
    // If it's an array (map data), determine type
    if (is_array($mapData)) {
        if ($mapData['dungeon'] == 1) {
            return 'Dungeon';
        } elseif ($mapData['underwater'] == 1) {
            return 'Underwater';
        } elseif (isset($mapData['beginZone']) && ($mapData['beginZone'] || $mapData['redKnightZone'] || $mapData['ruunCastleZone'])) {
            return 'Special Zone';
        } else {
            return 'Field Map';
        }
    }
    
    return 'Unknown';
}

/**
 * Format boolean attributes as Yes/No
 */
function formatYesNo($value) {
    return $value == 1 ? 'Yes' : 'No';
}

/**
 * Get map icon URL - Updated version that works with your setup
 */
function getMapIconUrl($pngId) {
    // Default image path using your existing structure
    $defaultIcon = '/l1jdb/assets/img/placeholders/0.png';
    
    if (empty($pngId) || $pngId == 0) {
        return $defaultIcon;
    }
    
    // Try different possible paths for map images based on your existing structure
    $possiblePaths = [
        "/l1jdb/assets/img/maps/{$pngId}.png",
        "/l1jdb/assets/img/maps/{$pngId}.jpg",
        "/l1jdb/assets/img/maps/map_{$pngId}.png",
        "/l1jdb/assets/img/icons/{$pngId}.png", // Use your existing icons structure
        "/l1jdb/public/img/maps/{$pngId}.png"
    ];
    
    foreach ($possiblePaths as $path) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
            return $path;
        }
    }
    
    // Return default placeholder if no image found
    return $defaultIcon;
}

/**
 * Get map coordinates display
 */
function formatMapCoordinates($startX, $endX, $startY, $endY) {
    return "({$startX},{$startY}) to ({$endX},{$endY})";
}

/**
 * Calculate map area
 */
function calculateMapArea($startX, $endX, $startY, $endY) {
    $width = abs($endX - $startX);
    $height = abs($endY - $startY);
    return $width * $height;
}

/**
 * Format map area for display
 */
function formatMapArea($startX, $endX, $startY, $endY) {
    $area = calculateMapArea($startX, $endX, $startY, $endY);
    return number_format($area) . ' sq units';
}

/**
 * Get map difficulty based on properties
 */
function getMapDifficulty($map) {
    $difficulty = 0;
    
    // Increase difficulty for dungeons
    if ($map['dungeon']) {
        $difficulty += 2;
    }
    
    // Increase difficulty if underwater
    if ($map['underwater']) {
        $difficulty += 1;
    }
    
    // Increase difficulty if penalties apply
    if ($map['penalty']) {
        $difficulty += 1;
    }
    
    // Increase difficulty based on damage modifiers
    if (isset($map['dmgModiNpc2Pc']) && $map['dmgModiNpc2Pc'] > 100) {
        $difficulty += 1;
    }
    
    // Decrease difficulty if resurrection is allowed
    if ($map['resurrection']) {
        $difficulty -= 1;
    }
    
    $difficulty = max(0, min(5, $difficulty)); // Clamp between 0-5
    
    $levels = ['Very Easy', 'Easy', 'Normal', 'Hard', 'Very Hard', 'Extreme'];
    return $levels[$difficulty];
}

/**
 * Get map safety level
 */
function getMapSafety($map) {
    $safety = 5; // Start with maximum safety
    
    // Reduce safety for dungeons
    if ($map['dungeon']) {
        $safety -= 2;
    }
    
    // Reduce safety if penalties apply
    if ($map['penalty']) {
        $safety -= 1;
    }
    
    // Reduce safety if resurrection is not allowed
    if (!$map['resurrection']) {
        $safety -= 1;
    }
    
    // Reduce safety if escape is not allowed
    if (!$map['escapable']) {
        $safety -= 1;
    }
    
    $safety = max(1, min(5, $safety)); // Clamp between 1-5
    
    $levels = ['', 'Very Dangerous', 'Dangerous', 'Moderate', 'Safe', 'Very Safe'];
    return $levels[$safety];
}

/**
 * Check if map is PvP enabled (based on penalties and other factors)
 */
function isPvPMap($map) {
    // This is a basic heuristic - adjust based on your game's logic
    return $map['penalty'] && !$map['beginZone'];
}

/**
 * Get map features as array
 */
function getMapFeatures($map) {
    $features = [];
    
    if ($map['underwater']) $features[] = 'Underwater';
    if ($map['dungeon']) $features[] = 'Dungeon';
    if ($map['markable']) $features[] = 'Bookmarkable';
    if ($map['teleportable']) $features[] = 'Teleportable';
    if ($map['escapable']) $features[] = 'Escapable';
    if ($map['resurrection']) $features[] = 'Resurrection';
    if ($map['take_pets']) $features[] = 'Pets Allowed';
    if ($map['usable_item']) $features[] = 'Items Usable';
    if ($map['usable_skill']) $features[] = 'Skills Usable';
    if ($map['penalty']) $features[] = 'Death Penalty';
    if ($map['beginZone']) $features[] = 'Beginner Zone';
    if (isPvPMap($map)) $features[] = 'PvP Enabled';
    
    return $features;
}

/**
 * Get map restrictions as array
 */
function getMapRestrictions($map) {
    $restrictions = [];
    
    if (!$map['markable']) $restrictions[] = 'No Bookmarks';
    if (!$map['teleportable']) $restrictions[] = 'No Teleport';
    if (!$map['escapable']) $restrictions[] = 'No Escape';
    if (!$map['resurrection']) $restrictions[] = 'No Resurrection';
    if (!$map['take_pets']) $restrictions[] = 'No Pets';
    if (!$map['recall_pets']) $restrictions[] = 'No Pet Recall';
    if (!$map['usable_item']) $restrictions[] = 'No Items';
    if (!$map['usable_skill']) $restrictions[] = 'No Skills';
    
    return $restrictions;
}

/**
 * Generate breadcrumb trail for maps
 */
function getMapBreadcrumbs($map = null) {
    $breadcrumbs = [
        ['url' => '/l1jdb/public/', 'text' => 'Home', 'icon' => 'fa-home'],
        ['url' => '/l1jdb/public/maps/', 'text' => 'Maps', 'icon' => 'fa-map']
    ];
    
    if ($map) {
        $breadcrumbs[] = [
            'url' => null, 
            'text' => $map['locationname'] ?? "Map #{$map['mapid']}", 
            'icon' => 'fa-map-marker-alt'
        ];
    }
    
    return $breadcrumbs;
}

?>