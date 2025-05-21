<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class Item {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Get all items with pagination (excluding Magic Dolls)
    public function getAllItems($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'etcitem.item_id ASC') {
        return $this->db->paginate(
            'etcitem',
            $page,
            $perPage,
            'etcitem.use_type != ?',
            ['MAGICDOLL'],
            $orderBy,
            'etcitem.item_id, etcitem.item_name_id, etcitem.desc_kr, etcitem.desc_en, 
            etcitem.item_type, etcitem.use_type, etcitem.material, etcitem.weight, 
            etcitem.iconId, etcitem.spriteId, etcitem.itemGrade'
        );
    }
    
    // Get item by ID
    public function getItemById($id) {
        $sql = "SELECT * FROM etcitem WHERE item_id = ? AND use_type != 'MAGICDOLL'";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Search items
    public function searchItems($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $columns = ['etcitem.item_id', 'etcitem.desc_kr', 'etcitem.desc_en', 'etcitem.item_type', 'etcitem.use_type', 'etcitem.material'];
        return $this->db->search(
            'etcitem',
            $searchTerm,
            $columns,
            $page,
            $perPage,
            'etcitem.use_type != ?',
            ['MAGICDOLL'],
            'etcitem.item_id ASC',
            'etcitem.item_id, etcitem.item_name_id, etcitem.desc_kr, etcitem.desc_en, 
            etcitem.item_type, etcitem.use_type, etcitem.material, etcitem.weight, 
            etcitem.iconId, etcitem.spriteId, etcitem.itemGrade'
        );
    }
    
    // Filter items
    public function filterItems($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $conditions = ['etcitem.use_type != ?'];
        $params = ['MAGICDOLL'];
        
        if (!empty($filters['item_type'])) {
            $conditions[] = 'etcitem.item_type = ?';
            $params[] = $filters['item_type'];
        }
        
        if (!empty($filters['use_type'])) {
            $conditions[] = 'etcitem.use_type = ?';
            $params[] = $filters['use_type'];
        }
        
        if (!empty($filters['material'])) {
            $conditions[] = 'etcitem.material = ?';
            $params[] = $filters['material'];
        }
        
        if (!empty($filters['grade'])) {
            $conditions[] = 'etcitem.itemGrade = ?';
            $params[] = $filters['grade'];
        }
        
        if (isset($filters['max_charge_count']) && $filters['max_charge_count'] > 0) {
            $conditions[] = 'etcitem.max_charge_count >= ?';
            $params[] = $filters['max_charge_count'];
        }
        
        $conditionSql = implode(' AND ', $conditions);
        
        return $this->db->paginate(
            'etcitem',
            $page,
            $perPage,
            $conditionSql,
            $params,
            'etcitem.item_id ASC',
            'etcitem.item_id, etcitem.item_name_id, etcitem.desc_kr, etcitem.desc_en, 
            etcitem.item_type, etcitem.use_type, etcitem.material, etcitem.weight, 
            etcitem.iconId, etcitem.spriteId, etcitem.itemGrade, etcitem.max_charge_count'
        );
    }
    
    // Get item types for filter
    public function getItemTypes() {
        $sql = "SELECT DISTINCT item_type FROM etcitem WHERE use_type != 'MAGICDOLL' AND item_type != 'OTHER' ORDER BY item_type";
        $results = $this->db->fetchAll($sql);
        
        $types = [];
        foreach ($results as $result) {
            $types[] = $result['item_type'];
        }
        
        return $types;
    }
    
    // Get item use types for filter
    public function getItemUseTypes() {
        $sql = "SELECT DISTINCT use_type FROM etcitem WHERE use_type != 'MAGICDOLL' AND use_type != 'NONE' ORDER BY use_type";
        $results = $this->db->fetchAll($sql);
        
        $useTypes = [];
        foreach ($results as $result) {
            $useTypes[] = $result['use_type'];
        }
        
        return $useTypes;
    }
    
    // Get item materials for filter
    public function getItemMaterials() {
        $sql = "SELECT DISTINCT material FROM etcitem WHERE use_type != 'MAGICDOLL' AND material != 'NONE(-)' ORDER BY material";
        $results = $this->db->fetchAll($sql);
        
        $materials = [];
        foreach ($results as $result) {
            $materials[] = $result['material'];
        }
        
        return $materials;
    }
    
    // Get item grades for filter
    public function getItemGrades() {
        $sql = "SELECT DISTINCT itemGrade FROM etcitem WHERE use_type != 'MAGICDOLL' ORDER BY FIELD(itemGrade, 'ONLY', 'MYTH', 'LEGEND', 'HERO', 'RARE', 'ADVANC', 'NORMAL')";
        $results = $this->db->fetchAll($sql);
        
        $grades = [];
        foreach ($results as $result) {
            $grades[] = $result['itemGrade'];
        }
        
        return $grades;
    }
    
    // Get item stats
    public function getItemStats($itemId) {
        $sql = "SELECT add_str, add_con, add_dex, add_int, add_wis, add_cha, add_hp, add_mp, 
                add_hpr, add_mpr, add_sp, ac_bonus, shortHit, shortDmg, longHit, longDmg,
                dmg_small, dmg_large FROM etcitem WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$itemId]);
    }
    
    // Get item delay info
    public function getItemDelayInfo($itemId) {
        $sql = "SELECT delay_id, delay_time, delay_effect FROM etcitem WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$itemId]);
    }
    
    // Get items by type
    public function getItemsByType($type, $page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'etcitem',
            $page,
            $perPage,
            'etcitem.item_type = ? AND etcitem.use_type != ?',
            [$type, 'MAGICDOLL'],
            'etcitem.item_id ASC',
            'etcitem.item_id, etcitem.desc_kr, etcitem.desc_en, etcitem.use_type, 
            etcitem.iconId, etcitem.spriteId, etcitem.itemGrade'
        );
    }
    
    // Get items by use type
    public function getItemsByUseType($useType, $page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'etcitem',
            $page,
            $perPage,
            'etcitem.use_type = ? AND etcitem.use_type != ?',
            [$useType, 'MAGICDOLL'],
            'etcitem.item_id ASC',
            'etcitem.item_id, etcitem.desc_kr, etcitem.desc_en, etcitem.item_type, 
            etcitem.iconId, etcitem.spriteId, etcitem.itemGrade'
        );
    }
    
    // Create a new item
    public function createItem($data) {
        return $this->db->insert('etcitem', $data);
    }
    
    // Update an existing item
    public function updateItem($id, $data) {
        return $this->db->update('etcitem', $data, 'item_id = ?', [$id]);
    }
    
    // Delete an item
    public function deleteItem($id) {
        return $this->db->delete('etcitem', 'item_id = ?', [$id]);
    }
    
    // Get recently added items
    public function getRecentItems($limit = 5) {
        $sql = "SELECT item_id, desc_kr, desc_en, item_type, use_type, iconId, itemGrade 
                FROM etcitem WHERE use_type != 'MAGICDOLL' ORDER BY item_id DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Get item icon URL - Updated with correct path
    public function getItemIconUrl($iconId) {
        return SITE_URL . '/assets/img/icons/' . $iconId . '.png';
    }
    
    // Get item sprite URL - Updated with correct path
    public function getItemSpriteUrl($spriteId) {
        return SITE_URL . '/assets/img/icons/' . $spriteId . '.png';
    }
    
    // Get monsters that drop this item
    public function getItemDrops($itemId) {
        $sql = "SELECT d.mobId, d.mobname_en, d.moblevel, d.min, d.max, 
                    d.chance, d.Enchant, n.spriteId, n.lvl, n.hp, 
                    n.is_bossmonster  
                FROM droplist d
                JOIN npc n ON d.mobId = n.npcid 
                WHERE d.itemId = ? 
                ORDER BY d.chance DESC, n.lvl DESC";
        return $this->db->fetchAll($sql, [$itemId]);
    }

    // Get monster sprite URL with PNG fallback to GIF
    public function getMonsterSpriteUrl($spriteId) {
        $pngPath = '/assets/img/icons/ms' . $spriteId . '.png';
        $gifPath = '/assets/img/icons/ms' . $spriteId . '.gif';
        
        // Check if PNG exists first
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $pngPath)) {
            return SITE_URL . '/' . $pngPath;
        }
        
        // Fall back to GIF
        return SITE_URL . '/' . $gifPath;
    }
    
    // Format resistance name
    public function formatResistName($resistName) {
        $mapping = [
            'regist_skill' => 'Skill Resistance',
            'regist_spirit' => 'Spirit Resistance',
            'regist_dragon' => 'Dragon Resistance',
            'regist_fear' => 'Fear Resistance',
            'regist_all' => 'All Resistance',
            'hitup_skill' => 'Skill Hit',
            'hitup_spirit' => 'Spirit Hit',
            'hitup_dragon' => 'Dragon Hit',
            'hitup_fear' => 'Fear Hit',
            'hitup_all' => 'All Hit',
            'hitup_magic' => 'Magic Hit'
        ];
        
        return isset($mapping[$resistName]) ? $mapping[$resistName] : ucfirst(str_replace('_', ' ', $resistName));
    }
}