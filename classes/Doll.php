<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class Doll {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Get all dolls with pagination
    public function getAllDolls($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'etcitem.item_id ASC') {
        return $this->db->paginate(
            'etcitem',
            $page,
            $perPage,
            'etcitem.use_type = ?',
            ['MAGICDOLL'],
            $orderBy,
            'etcitem.item_id, etcitem.item_name_id, etcitem.desc_kr, etcitem.desc_en, 
            etcitem.material, etcitem.weight, etcitem.iconId, etcitem.spriteId, 
            etcitem.itemGrade, etcitem.min_lvl, etcitem.max_lvl'
        );
    }
    
    // Get doll by ID
    public function getDollById($id) {
        $sql = "SELECT * FROM etcitem WHERE item_id = ? AND use_type = 'MAGICDOLL'";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Search dolls
    public function searchDolls($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $columns = ['etcitem.item_id', 'etcitem.desc_kr', 'etcitem.desc_en', 'etcitem.material'];
        return $this->db->search(
            'etcitem',
            $searchTerm,
            $columns,
            $page,
            $perPage,
            'etcitem.use_type = ?',
            ['MAGICDOLL'],
            'etcitem.item_id ASC',
            'etcitem.item_id, etcitem.item_name_id, etcitem.desc_kr, etcitem.desc_en, 
            etcitem.material, etcitem.weight, etcitem.iconId, etcitem.spriteId, 
            etcitem.itemGrade, etcitem.min_lvl, etcitem.max_lvl'
        );
    }
    
    // Filter dolls
    public function filterDolls($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $conditions = ['etcitem.use_type = ?'];
        $params = ['MAGICDOLL'];
        
        if (!empty($filters['material'])) {
            $conditions[] = 'etcitem.material = ?';
            $params[] = $filters['material'];
        }
        
        if (!empty($filters['grade'])) {
            $conditions[] = 'etcitem.itemGrade = ?';
            $params[] = $filters['grade'];
        }
        
        if (!empty($filters['min_level'])) {
            $conditions[] = 'etcitem.min_lvl >= ?';
            $params[] = $filters['min_level'];
        }
        
        if (!empty($filters['max_level'])) {
            $conditions[] = 'etcitem.max_lvl <= ?';
            $params[] = $filters['max_level'];
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
            etcitem.material, etcitem.weight, etcitem.iconId, etcitem.spriteId, 
            etcitem.itemGrade, etcitem.min_lvl, etcitem.max_lvl'
        );
    }
    
    // Get doll materials for filter
    public function getDollMaterials() {
        $sql = "SELECT DISTINCT material FROM etcitem WHERE use_type = 'MAGICDOLL' AND material != 'NONE(-)' ORDER BY material";
        $results = $this->db->fetchAll($sql);
        
        $materials = [];
        foreach ($results as $result) {
            $materials[] = $result['material'];
        }
        
        return $materials;
    }
    
    // Get doll grades for filter
    public function getDollGrades() {
        $sql = "SELECT DISTINCT itemGrade FROM etcitem WHERE use_type = 'MAGICDOLL' ORDER BY FIELD(itemGrade, 'ONLY', 'MYTH', 'LEGEND', 'HERO', 'RARE', 'ADVANC', 'NORMAL')";
        $results = $this->db->fetchAll($sql);
        
        $grades = [];
        foreach ($results as $result) {
            $grades[] = $result['itemGrade'];
        }
        
        return $grades;
    }
    
    // Get doll stats
    public function getDollStats($dollId) {
        $sql = "SELECT add_str, add_con, add_dex, add_int, add_wis, add_cha, add_hp, add_mp, 
                add_hpr, add_mpr, add_sp, ac_bonus, shortHit, shortDmg, longHit, longDmg, 
                regist_stone, regist_sleep, regist_freeze, regist_blind, regist_skill, 
                regist_spirit, regist_dragon, regist_fear, regist_all, 
                hitup_skill, hitup_spirit, hitup_dragon, hitup_fear, hitup_all, hitup_magic, 
                damage_reduction, MagicDamageReduction FROM etcitem WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$dollId]);
    }
    
    // Get dolls by level range
    public function getDollsByLevelRange($minLevel, $maxLevel, $page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'etcitem',
            $page,
            $perPage,
            'etcitem.use_type = ? AND etcitem.min_lvl >= ? AND etcitem.max_lvl <= ?',
            ['MAGICDOLL', $minLevel, $maxLevel],
            'etcitem.min_lvl ASC',
            'etcitem.item_id, etcitem.desc_kr, etcitem.desc_en, etcitem.iconId, 
            etcitem.spriteId, etcitem.itemGrade, etcitem.min_lvl, etcitem.max_lvl'
        );
    }
    
    // Get class restrictions for doll
    public function getDollClassRestrictions($dollId) {
        $sql = "SELECT use_royal, use_knight, use_mage, use_elf, use_darkelf, 
                use_dragonknight, use_illusionist, use_warrior, use_fencer, use_lancer 
                FROM etcitem WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$dollId]);
    }
    
    // Create a new doll
    public function createDoll($data) {
        // Ensure it's a magic doll
        $data['use_type'] = 'MAGICDOLL';
        return $this->db->insert('etcitem', $data);
    }
    
    // Update an existing doll
    public function updateDoll($id, $data) {
        return $this->db->update('etcitem', $data, 'item_id = ? AND use_type = ?', [$id, 'MAGICDOLL']);
    }
    
    // Delete a doll
    public function deleteDoll($id) {
        return $this->db->delete('etcitem', 'item_id = ? AND use_type = ?', [$id, 'MAGICDOLL']);
    }
    
    // Get recently added dolls
    public function getRecentDolls($limit = 5) {
        $sql = "SELECT item_id, desc_kr, desc_en, iconId, spriteId, itemGrade, min_lvl 
                FROM etcitem WHERE use_type = 'MAGICDOLL' ORDER BY item_id DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Get doll icon URL
    public function getDollIconUrl($iconId) {
        return SITE_URL . '/assets/images/icons/items/' . $iconId . '.png';
    }
    
    // Get doll sprite URL
    public function getDollSpriteUrl($spriteId) {
        return SITE_URL . '/assets/images/sprites/' . $spriteId . '.png';
    }
    
    // Get total doll count
    public function getDollCount() {
        $sql = "SELECT COUNT(*) as count FROM etcitem WHERE use_type = 'MAGICDOLL'";
        $result = $this->db->fetchOne($sql);
        return $result['count'];
    }
    
    // Get highest level dolls
    public function getHighestLevelDolls($limit = 5) {
        $sql = "SELECT item_id, desc_kr, desc_en, iconId, itemGrade, min_lvl 
                FROM etcitem WHERE use_type = 'MAGICDOLL' 
                ORDER BY min_lvl DESC, item_id ASC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
}
