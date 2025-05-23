<?php
/**
 * Item Reference Detection and Management Functions
 * Handles cross-table item reference detection and cleanup for L1J Database
 */

/**
 * Get comprehensive item references across all database tables
 * 
 * @param int $itemId The item ID to search for
 * @param Database $db Database instance
 * @param string $itemType Type of item (weapon, armor, etcitem) - optional for context
 * @return array Comprehensive array of all references found
 */
function findAllItemReferences($itemId, $db, $itemType = 'item') {
    $references = [];
    
    // Define all possible tables and their configurations
    $searchTables = getItemReferenceTableConfig();
    
    foreach ($searchTables as $tableName => $config) {
        $tableReferences = searchTableForItem($tableName, $config, $itemId, $db);
        
        if (!empty($tableReferences)) {
            $references[$tableName] = $tableReferences;
        }
    }
    
    return $references;
}

/**
 * Get configuration for all tables that may reference items
 * 
 * @return array Complete table configuration for reference searching
 */
function getItemReferenceTableConfig() {
    return [
        // Player-related tables
        'character_items' => [
            'name' => 'Player Inventories',
            'description' => 'Items currently in player inventories',
            'category' => 'player_data',
            'fields' => ['item_id'],
            'display_fields' => ['char_id', 'count', 'enchantlvl', 'is_equipped'],
            'join_tables' => [
                ['table' => 'characters', 'on' => 'character_items.char_id = characters.objid', 'select' => 'characters.char_name']
            ],
            'critical' => true,
            'description_detail' => 'This item is currently owned by players. Deleting will remove from inventories!'
        ],
        
        'character_warehouse' => [
            'name' => 'Player Warehouses',
            'description' => 'Items stored in player warehouses',
            'category' => 'player_data',
            'fields' => ['item_id'],
            'display_fields' => ['account_name', 'count', 'enchantlvl'],
            'critical' => true,
            'description_detail' => 'This item is stored in player warehouses. Deleting will remove from storage!'
        ],
        
        'character_elf_warehouse' => [
            'name' => 'Elf Warehouses',
            'description' => 'Items stored in elf warehouses',
            'category' => 'player_data',
            'fields' => ['item_id'],
            'display_fields' => ['account_name', 'count', 'enchantlvl'],
            'critical' => true
        ],
        
        'character_package_warehouse' => [
            'name' => 'Package Warehouses',
            'description' => 'Items in package warehouses',
            'category' => 'player_data',
            'fields' => ['item_id'],
            'display_fields' => ['account_name', 'count', 'enchantlvl'],
            'critical' => true
        ],
        
        'character_present_warehouse' => [
            'name' => 'Present Warehouses',
            'description' => 'Items in present warehouses',
            'category' => 'player_data',
            'fields' => ['item_id'],
            'display_fields' => ['account_name', 'count', 'enchantlvl'],
            'critical' => true
        ],
        
        'character_special_warehouse' => [
            'name' => 'Special Warehouses',
            'description' => 'Items in special warehouses',
            'category' => 'player_data',
            'fields' => ['item_id'],
            'display_fields' => ['account_name', 'count', 'enchantlvl'],
            'critical' => true
        ],
        
        'clan_warehouse' => [
            'name' => 'Clan Warehouses',
            'description' => 'Items stored in clan warehouses',
            'category' => 'player_data',
            'fields' => ['item_id'],
            'display_fields' => ['clan_name', 'count', 'enchantlvl'],
            'critical' => true
        ],
        
        // Drop and reward tables
        'droplist' => [
            'name' => 'Monster Drops',
            'description' => 'Monsters that drop this item',
            'category' => 'game_content',
            'fields' => ['itemId'],
            'display_fields' => ['mobId', 'mobname_en', 'min', 'max', 'chance'],
            'join_tables' => [
                ['table' => 'npc', 'on' => 'droplist.mobId = npc.npcid', 'select' => 'npc.desc_en as monster_name, npc.lvl as monster_level']
            ],
            'critical' => false
        ],
        
        'ai_user_drop' => [
            'name' => 'AI User Drops',
            'description' => 'AI users configured to drop this item',
            'category' => 'game_content',
            'fields' => ['itemId'],
            'display_fields' => ['class', 'count', 'chance'],
            'critical' => false
        ],
        
        'ai_user_item' => [
            'name' => 'AI User Equipment',
            'description' => 'AI users equipped with this item',
            'category' => 'game_content',
            'fields' => ['itemId'],
            'display_fields' => ['class', 'count', 'enchantLevel', 'equip'],
            'critical' => false
        ],
        
        // Shop and trading tables
        'shop' => [
            'name' => 'NPC Shops',
            'description' => 'NPCs selling this item',
            'category' => 'shop_trade',
            'fields' => ['item_id'],
            'display_fields' => ['npc_id', 'selling_price', 'purchasing_price', 'pack_count'],
            'join_tables' => [
                ['table' => 'npc', 'on' => 'shop.npc_id = npc.npcid', 'select' => 'npc.desc_en as npc_name']
            ],
            'critical' => false
        ],
        
        'shop_npc' => [
            'name' => 'NPC Shop Items',
            'description' => 'Alternative NPC shop configuration',
            'category' => 'shop_trade',
            'fields' => ['item_id'],
            'display_fields' => ['npc_id', 'selling_price', 'purchasing_price', 'count'],
            'critical' => false
        ],
        
        'app_nshop' => [
            'name' => 'Cash Shop',
            'description' => 'Items available in cash shop',
            'category' => 'shop_trade',
            'fields' => ['itemid'],
            'display_fields' => ['itemname', 'price', 'price_type', 'pack'],
            'critical' => false
        ],
        
        // Event and reward tables
        'attendance_item' => [
            'name' => 'Attendance Rewards',
            'description' => 'Items given as attendance rewards',
            'category' => 'events_rewards',
            'fields' => ['item_id'],
            'display_fields' => ['groupType', 'index', 'count', 'enchant', 'broadcast'],
            'critical' => false
        ],
        
        'attendance_item_random' => [
            'name' => 'Random Attendance Rewards',
            'description' => 'Items in random attendance reward pools',
            'category' => 'events_rewards',
            'fields' => ['itemId'],
            'display_fields' => ['groupType', 'index', 'count', 'broadcast', 'level'],
            'critical' => false
        ],
        
        'character_eventpush' => [
            'name' => 'Event Push Items',
            'description' => 'Items sent via event push system',
            'category' => 'events_rewards',
            'fields' => ['itemId'],
            'display_fields' => ['objId', 'subject', 'item_amount', 'item_enchant', 'status'],
            'critical' => false
        ],
        
        'levelup_quests_item' => [
            'name' => 'Level Up Quest Rewards',
            'description' => 'Items given as level up quest rewards',
            'category' => 'events_rewards',
            'fields' => ['item_id'],
            'display_fields' => ['level', 'type', 'count', 'enchant'],
            'critical' => false
        ],
        
        'beginner_box' => [
            'name' => 'Beginner Box Items',
            'description' => 'Items in beginner boxes',
            'category' => 'events_rewards',
            'fields' => ['itemid'],
            'display_fields' => ['count', 'enchantlvl', 'activate', 'bless'],
            'critical' => false
        ],
        
        'beginner' => [
            'name' => 'Beginner Items',
            'description' => 'Items given to new players',
            'category' => 'events_rewards',
            'fields' => ['item_id'],
            'display_fields' => ['count', 'charge_count', 'enchantlvl', 'activate'],
            'critical' => false
        ],
        
        // Box and container tables
        'item_box' => [
            'name' => 'Item Boxes',
            'description' => 'Items contained in boxes/containers',
            'category' => 'containers',
            'fields' => ['itemId'],
            'display_fields' => ['boxId', 'classType', 'count', 'enchant', 'chance'],
            'critical' => false
        ],
        
        'item_selector' => [
            'name' => 'Item Selectors',
            'description' => 'Items available in selection boxes',
            'category' => 'containers',
            'fields' => ['itemId', 'selectItemId'],
            'display_fields' => ['name', 'count', 'enchant', 'bless'],
            'critical' => false
        ],
        
        'item_selector_warehouse' => [
            'name' => 'Warehouse Item Selectors',
            'description' => 'Items in warehouse selection boxes',
            'category' => 'containers',
            'fields' => ['itemId', 'selectItemId'],
            'display_fields' => ['name', 'enchantLevel', 'attrLevel'],
            'critical' => false
        ],
        
        // Favor book and time collection
        'favorbook' => [
            'name' => 'Favor Book',
            'description' => 'Items configured in favor book system',
            'category' => 'collections',
            'fields' => ['itemIds'], // Special handling needed - comma separated
            'display_fields' => ['category', 'slotId', 'note'],
            'special_search' => 'favor_book_search',
            'critical' => false
        ],
        
        'character_favorbook' => [
            'name' => 'Player Favor Books',
            'description' => 'Items in player favor book collections',
            'category' => 'collections',
            'fields' => ['itemId'],
            'display_fields' => ['charObjId', 'category', 'slotId', 'count', 'enchantLevel'],
            'join_tables' => [
                ['table' => 'characters', 'on' => 'character_favorbook.charObjId = characters.objid', 'select' => 'characters.char_name']
            ],
            'critical' => true
        ],
        
        'character_timecollection' => [
            'name' => 'Time Collection Items',
            'description' => 'Items in player time collection slots',
            'category' => 'collections',
            'fields' => ['slots'], // Special JSON field handling needed
            'display_fields' => ['charObjId', 'groupId', 'setId', 'buffType'],
            'special_search' => 'time_collection_search',
            'critical' => true
        ],
        
        // Weapon-specific tables
        'weapon_skill' => [
            'name' => 'Weapon Skills',
            'description' => 'Weapon skill configurations',
            'category' => 'weapon_data',
            'fields' => ['weapon_id'],
            'display_fields' => ['probability', 'fix_damage', 'random_damage', 'skill_id'],
            'critical' => false,
            'item_types' => ['weapon'] // Only relevant for weapons
        ],
        
        'weapon_skill_model' => [
            'name' => 'Weapon Skill Models',
            'description' => 'Weapon skill model data',
            'category' => 'weapon_data',
            'fields' => ['item_id'],
            'display_fields' => ['procType', 'default_prob', 'enchant_prob'],
            'critical' => false,
            'item_types' => ['weapon']
        ],
        
        'weapon_damege' => [
            'name' => 'Weapon Damage Bonuses',
            'description' => 'Additional weapon damage configurations',
            'category' => 'weapon_data',
            'fields' => ['item_id'],
            'display_fields' => ['name', 'addDamege'],
            'critical' => false,
            'item_types' => ['weapon']
        ],
        
        // Item enhancement and modification
        'item_enchant_ablity' => [
            'name' => 'Enchant Abilities',
            'description' => 'Special enchant ability configurations',
            'category' => 'enhancements',
            'fields' => ['itemId'],
            'display_fields' => ['enchant', 'ac_bonus', 'str', 'dex', 'magicName'],
            'critical' => false
        ],
        
        'polyitems' => [
            'name' => 'Polymorph Items',
            'description' => 'Items that grant polymorph abilities',
            'category' => 'special_items',
            'fields' => ['itemId'],
            'display_fields' => ['name', 'polyId', 'duration', 'type'],
            'critical' => false
        ],
        
        'magicdoll_info' => [
            'name' => 'Magic Doll Items',
            'description' => 'Magic doll item configurations',
            'category' => 'special_items',
            'fields' => ['itemId', 'blessItemId', 'bonusItemId'],
            'display_fields' => ['dollNpcId', 'grade', 'bonusCount', 'damageChance'],
            'critical' => false
        ],
        
        // Crafting and resolution
        'resolvent' => [
            'name' => 'Resolvent Items',
            'description' => 'Items that can be resolved for crystals',
            'category' => 'crafting',
            'fields' => ['item_id'],
            'display_fields' => ['crystal_count', 'note'],
            'critical' => false
        ],
        
        // Item behavior and configuration
        'item_buff' => [
            'name' => 'Item Buffs',
            'description' => 'Items that provide buff effects',
            'category' => 'item_config',
            'fields' => ['item_id'],
            'display_fields' => ['name', 'skill_ids', 'delete'],
            'critical' => false
        ],
        
        'item_click_message' => [
            'name' => 'Item Click Messages',
            'description' => 'Items with special click messages',
            'category' => 'item_config',
            'fields' => ['itemId'],
            'display_fields' => ['type', 'msg', 'delete'],
            'critical' => false
        ],
        
        'item_collection' => [
            'name' => 'Item Collections',
            'description' => 'Items part of special collections',
            'category' => 'item_config',
            'fields' => ['itemId'],
            'display_fields' => ['name', 'type'],
            'critical' => false
        ],
        
        'item_ment' => [
            'name' => 'Item Messages',
            'description' => 'Items with special announcement messages',
            'category' => 'item_config',
            'fields' => ['itemId'],
            'display_fields' => ['itemName', 'mentType'],
            'critical' => false
        ],
        
        'item_terms' => [
            'name' => 'Item Terms',
            'description' => 'Items with time-based terms',
            'category' => 'item_config',
            'fields' => ['itemId'],
            'display_fields' => ['name', 'termMinut'],
            'critical' => false
        ],
        
        'repair_item_cost' => [
            'name' => 'Repair Costs',
            'description' => 'Item repair cost configurations',
            'category' => 'item_config',
            'fields' => ['itemId'],
            'display_fields' => ['name', 'cost'],
            'critical' => false
        ],
        
        // Miscellaneous tables
        'autoloot' => [
            'name' => 'Auto Loot',
            'description' => 'Items configured for auto-loot',
            'category' => 'misc',
            'fields' => ['item_id'],
            'display_fields' => ['note'],
            'critical' => false
        ],
        
        'penalty_protect_item' => [
            'name' => 'Penalty Protection',
            'description' => 'Items that provide penalty protection',
            'category' => 'misc',
            'fields' => ['itemId', 'dropItemId'],
            'display_fields' => ['name', 'type', 'itemPanalty', 'expPanalty'],
            'critical' => false
        ],
        
        'penalty_pass_item' => [
            'name' => 'Penalty Pass Items',
            'description' => 'Items that bypass penalties',
            'category' => 'misc',
            'fields' => ['itemId'],
            'display_fields' => ['desc'],
            'critical' => false
        ],
        
        'dungeon_timer_item' => [
            'name' => 'Dungeon Timer Items',
            'description' => 'Items related to dungeon timers',
            'category' => 'misc',
            'fields' => ['itemId'],
            'display_fields' => ['desc', 'timerId', 'groupId'],
            'critical' => false
        ],
        
        'tj_coupon' => [
            'name' => 'TJ Coupons',
            'description' => 'Items in TJ coupon system',
            'category' => 'misc',
            'fields' => ['itemId'],
            'display_fields' => ['objId', 'charId', 'count', 'enchantLevel', 'lostTime'],
            'critical' => true
        ]
    ];
}

/**
 * Search a specific table for item references
 * 
 * @param string $tableName Name of the table to search
 * @param array $config Table configuration
 * @param int $itemId Item ID to search for
 * @param Database $db Database instance
 * @return array|null Results or null if no matches
 */
function searchTableForItem($tableName, $config, $itemId, $db) {
    // Skip table if it doesn't exist
    if (!tableExists($tableName, $db)) {
        return null;
    }
    
    // Handle special search cases
    if (isset($config['special_search'])) {
        return handleSpecialSearch($tableName, $config, $itemId, $db);
    }
    
    $results = [];
    
    // Search each field that might contain the item ID
    foreach ($config['fields'] as $fieldName) {
        if (!columnExists($tableName, $fieldName, $db)) {
            continue;
        }
        
        $matches = searchTableField($tableName, $fieldName, $itemId, $config, $db);
        if (!empty($matches)) {
            $results = array_merge($results, $matches);
        }
    }
    
    if (empty($results)) {
        return null;
    }
    
    return [
        'table_name' => $tableName,
        'display_name' => $config['name'],
        'description' => $config['description'],
        'category' => $config['category'],
        'critical' => isset($config['critical']) ? $config['critical'] : false,
        'description_detail' => isset($config['description_detail']) ? $config['description_detail'] : $config['description'],
        'count' => count($results),
        'records' => $results,
        'display_fields' => $config['display_fields']
    ];
}

/**
 * Search a specific table field for item references
 * 
 * @param string $tableName Table name
 * @param string $fieldName Field name to search
 * @param int $itemId Item ID to search for
 * @param array $config Table configuration
 * @param Database $db Database instance
 * @return array Results array
 */
function searchTableField($tableName, $fieldName, $itemId, $config, $db) {
    try {
        // Build base query
        $select = $tableName . '.*';
        $joins = '';
        
        // Add joins if configured
        if (isset($config['join_tables'])) {
            foreach ($config['join_tables'] as $join) {
                $select .= ', ' . $join['select'];
                $joins .= ' LEFT JOIN ' . $join['table'] . ' ON ' . $join['on'];
            }
        }
        
        $sql = "SELECT {$select} FROM {$tableName}{$joins} WHERE {$tableName}.{$fieldName} = ?";
        
        $results = $db->fetchAll($sql, [$itemId]);
        
        // Add metadata to each result
        foreach ($results as &$result) {
            $result['_found_in_field'] = $fieldName;
            $result['_table_name'] = $tableName;
        }
        
        return $results;
        
    } catch (Exception $e) {
        // Log error but continue with other tables
        error_log("Error searching {$tableName}.{$fieldName}: " . $e->getMessage());
        return [];
    }
}

/**
 * Handle special search cases (like JSON fields or comma-separated lists)
 * 
 * @param string $tableName Table name
 * @param array $config Table configuration
 * @param int $itemId Item ID to search for
 * @param Database $db Database instance
 * @return array|null Results or null
 */
function handleSpecialSearch($tableName, $config, $itemId, $db) {
    switch ($config['special_search']) {
        case 'favor_book_search':
            return searchFavorBookItems($tableName, $itemId, $db);
            
        case 'time_collection_search':
            return searchTimeCollectionItems($tableName, $itemId, $db);
            
        default:
            return null;
    }
}

/**
 * Search favor book items (comma-separated itemIds field)
 * 
 * @param string $tableName Table name
 * @param int $itemId Item ID to search for
 * @param Database $db Database instance
 * @return array|null Results or null
 */
function searchFavorBookItems($tableName, $itemId, $db) {
    try {
        $sql = "SELECT * FROM {$tableName} WHERE FIND_IN_SET(?, itemIds) > 0";
        $results = $db->fetchAll($sql, [$itemId]);
        
        if (empty($results)) {
            return null;
        }
        
        return [
            'table_name' => $tableName,
            'display_name' => 'Favor Book Items',
            'description' => 'Items configured in favor book system',
            'category' => 'collections',
            'critical' => false,
            'count' => count($results),
            'records' => $results,
            'display_fields' => ['category', 'slotId', 'note', 'itemIds']
        ];
        
    } catch (Exception $e) {
        error_log("Error in favor book search: " . $e->getMessage());
        return null;
    }
}

/**
 * Search time collection items (JSON slots field)
 * 
 * @param string $tableName Table name
 * @param int $itemId Item ID to search for
 * @param Database $db Database instance
 * @return array|null Results or null
 */
function searchTimeCollectionItems($tableName, $itemId, $db) {
    try {
        // Search in JSON field for the item ID
        $sql = "SELECT * FROM {$tableName} WHERE JSON_SEARCH(slots, 'one', ?) IS NOT NULL";
        $results = $db->fetchAll($sql, [(string)$itemId]);
        
        if (empty($results)) {
            return null;
        }
        
        return [
            'table_name' => $tableName,
            'display_name' => 'Player Time Collections',
            'description' => 'Items in player time collection slots',
            'category' => 'collections',
            'critical' => true,
            'count' => count($results),
            'records' => $results,
            'display_fields' => ['charObjId', 'groupId', 'setId', 'buffType', 'slots']
        ];
        
    } catch (Exception $e) {
        error_log("Error in time collection search: " . $e->getMessage());
        return null;
    }
}

/**
 * Check if a table exists in the database
 * 
 * @param string $tableName Table name to check
 * @param Database $db Database instance
 * @return bool Whether table exists
 */
function tableExists($tableName, $db) {
    try {
        $sql = "SHOW TABLES LIKE ?";
        $result = $db->fetchOne($sql, [$tableName]);
        return !empty($result);
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Check if a column exists in a table
 * 
 * @param string $tableName Table name
 * @param string $columnName Column name
 * @param Database $db Database instance
 * @return bool Whether column exists
 */
function columnExists($tableName, $columnName, $db) {
    try {
        $sql = "SHOW COLUMNS FROM {$tableName} LIKE ?";
        $result = $db->fetchOne($sql, [$columnName]);
        return !empty($result);
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Delete item references from specified tables
 * 
 * @param int $itemId Item ID
 * @param array $tablesToClean Tables to clean (table_name => field_names)
 * @param Database $db Database instance
 * @param string $itemName Item name for logging
 * @return array Deletion results
 */
function deleteItemReferences($itemId, $tablesToClean, $db, $itemName = '') {
    $results = [];
    $totalDeleted = 0;
    
    foreach ($tablesToClean as $tableName => $fields) {
        $tableResults = deleteFromTable($tableName, $fields, $itemId, $db);
        $results[$tableName] = $tableResults;
        $totalDeleted += $tableResults['deleted_count'];
    }
    
    // Log the deletion activity
    if ($totalDeleted > 0) {
        $logMessage = "Cleaned item references for item ID {$itemId}";
        if ($itemName) {
            $logMessage .= " ({$itemName})";
        }
        $logMessage .= ". Deleted {$totalDeleted} references from " . count($tablesToClean) . " tables.";
        error_log($logMessage);
    }
    
    return [
        'success' => true,
        'total_deleted' => $totalDeleted,
        'tables_cleaned' => count($tablesToClean),
        'results' => $results
    ];
}

/**
 * Delete item references from a specific table
 * 
 * @param string $tableName Table name
 * @param array $fields Field names that contain the item ID
 * @param int $itemId Item ID to delete
 * @param Database $db Database instance
 * @return array Deletion results for the table
 */
function deleteFromTable($tableName, $fields, $itemId, $db) {
    $deletedCount = 0;
    $errors = [];
    
    foreach ($fields as $fieldName) {
        try {
            // Handle special cases
            if ($fieldName === 'itemIds') {
                // Favor book comma-separated field
                $deletedCount += cleanFavorBookField($tableName, $itemId, $db);
            } elseif ($fieldName === 'slots') {
                // Time collection JSON field
                $deletedCount += cleanTimeCollectionField($tableName, $itemId, $db);
            } else {
                // Standard field deletion
                $sql = "DELETE FROM {$tableName} WHERE {$fieldName} = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$itemId]);
                $deletedCount += $stmt->rowCount();
            }
        } catch (Exception $e) {
            $errors[] = "Error deleting from {$tableName}.{$fieldName}: " . $e->getMessage();
        }
    }
    
    return [
        'table_name' => $tableName,
        'deleted_count' => $deletedCount,
        'errors' => $errors
    ];
}

/**
 * Clean item ID from favor book comma-separated field
 * 
 * @param string $tableName Table name
 * @param int $itemId Item ID to remove
 * @param Database $db Database instance
 * @return int Number of rows affected
 */
function cleanFavorBookField($tableName, $itemId, $db) {
    try {
        // Get all rows that contain the item ID
        $sql = "SELECT * FROM {$tableName} WHERE FIND_IN_SET(?, itemIds) > 0";
        $rows = $db->fetchAll($sql, [$itemId]);
        
        $updatedCount = 0;
        
        foreach ($rows as $row) {
            $itemIds = explode(',', $row['itemIds']);
            $itemIds = array_filter($itemIds, function($id) use ($itemId) {
                return trim($id) != $itemId;
            });
            
            $newItemIds = implode(',', $itemIds);
            
            if (empty($newItemIds)) {
                // If no items left, delete the row
                $deleteSql = "DELETE FROM {$tableName} WHERE category = ? AND slotId = ?";
                $stmt = $db->prepare($deleteSql);
                $stmt->execute([$row['category'], $row['slotId']]);
            } else {
                // Update with new item list
                $updateSql = "UPDATE {$tableName} SET itemIds = ? WHERE category = ? AND slotId = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->execute([$newItemIds, $row['category'], $row['slotId']]);
            }
            $updatedCount++;
        }
        
        return $updatedCount;
        
    } catch (Exception $e) {
        error_log("Error cleaning favor book field: " . $e->getMessage());
        return 0;
    }
}

/**
 * Clean item ID from time collection JSON field
 * 
 * @param string $tableName Table name
 * @param int $itemId Item ID to remove
 * @param Database $db Database instance
 * @return int Number of rows affected
 */
function cleanTimeCollectionField($tableName, $itemId, $db) {
    try {
        // This would require complex JSON manipulation
        // For now, we'll just delete entire records that contain the item
        $sql = "DELETE FROM {$tableName} WHERE JSON_SEARCH(slots, 'one', ?) IS NOT NULL";
        $stmt = $db->prepare($sql);
        $stmt->execute([(string)$itemId]);
        
        return $stmt->rowCount();
        
    } catch (Exception $e) {
        error_log("Error cleaning time collection field: " . $e->getMessage());
        return 0;
    }
}

/**
 * Generate a summary of what will be deleted
 * 
 * @param array $references Array of found references
 * @return array Summary information
 */
function generateDeletionSummary($references) {
    $summary = [
        'total_tables' => count($references),
        'total_records' => 0,
        'critical_tables' => 0,
        'critical_records' => 0,
        'categories' => [],
        'warnings' => []
    ];
    
    foreach ($references as $tableData) {
        $summary['total_records'] += $tableData['count'];
        
        if ($tableData['critical']) {
            $summary['critical_tables']++;
            $summary['critical_records'] += $tableData['count'];
            
            $summary['warnings'][] = $tableData['display_name'] . ': ' . $tableData['description_detail'];
        }
        
        $category = $tableData['category'];
        if (!isset($summary['categories'][$category])) {
            $summary['categories'][$category] = [
                'name' => ucwords(str_replace('_', ' ', $category)),
                'tables' => 0,
                'records' => 0
            ];
        }
        
        $summary['categories'][$category]['tables']++;
        $summary['categories'][$category]['records'] += $tableData['count'];
    }
    
    return $summary;
}
