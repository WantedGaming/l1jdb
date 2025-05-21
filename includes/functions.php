<?php
/**
 * Helper functions for formatting and displaying data
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
function formatArmorGrade($grade) {
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