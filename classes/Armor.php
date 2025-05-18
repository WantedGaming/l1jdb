<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class Armor {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Get all armor items with pagination
    public function getAllArmor($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'armor.item_id ASC') {
        return $this->db->paginate(
            'armor',
            $page,
            $perPage,
            '',
            [],
            $orderBy,
            'armor.item_id, armor.item_name_id, armor.desc_kr, armor.desc_en, armor.type, 
            armor.material, armor.weight, armor.iconId, armor.spriteId, armor.itemGrade, 
            armor.ac, armor.safenchant, armor.Set_Id'
        );
    }
    
    // Get armor by ID
    public function getArmorById($id) {
        $sql = "SELECT * FROM armor WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Search armor
    public function searchArmor($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $columns = ['armor.item_id', 'armor.desc_kr', 'armor.desc_en', 'armor.type', 'armor.material'];
        return $this->db->search(
            'armor',
            $searchTerm,
            $columns,
            $page,
            $perPage,
            '',
            [],
            'armor.item_id ASC',
            'armor.item_id, armor.item_name_id, armor.desc_kr, armor.desc_en, armor.type, 
            armor.material, armor.weight, armor.iconId, armor.spriteId, armor.itemGrade, 
            armor.ac, armor.safenchant, armor.Set_Id'
        );
    }
    
    // Filter armor
    public function filterArmor($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $conditions = [];
        $params = [];
        
        if (!empty($filters['type'])) {
            $conditions[] = 'armor.type = ?';
            $params[] = $filters['type'];
        }
        
        if (!empty($filters['material'])) {
            $conditions[] = 'armor.material = ?';
            $params[] = $filters['material'];
        }
        
        if (!empty($filters['grade'])) {
            $conditions[] = 'armor.itemGrade = ?';
            $params[] = $filters['grade'];
        }
        
        if (!empty($filters['min_ac'])) {
            $conditions[] = 'armor.ac >= ?';
            $params[] = $filters['min_ac'];
        }
        
        if (!empty($filters['max_ac'])) {
            $conditions[] = 'armor.ac <= ?';
            $params[] = $filters['max_ac'];
        }
        
        if (!empty($filters['has_set'])) {
            $conditions[] = 'armor.Set_Id > 0';
        }
        
        $conditionSql = !empty($conditions) ? implode(' AND ', $conditions) : '';
        
        return $this->db->paginate(
            'armor',
            $page,
            $perPage,
            $conditionSql,
            $params,
            'armor.item_id ASC',
            'armor.item_id, armor.item_name_id, armor.desc_kr, armor.desc_en, armor.type, 
            armor.material, armor.weight, armor.iconId, armor.spriteId, armor.itemGrade, 
            armor.ac, armor.safenchant, armor.Set_Id'
        );
    }
    
    // Get armor types for filter
    public function getArmorTypes() {
        $sql = "SELECT DISTINCT type FROM armor WHERE type != 'NONE' ORDER BY type";
        $results = $this->db->fetchAll($sql);
        
        $types = [];
        foreach ($results as $result) {
            $types[] = $result['type'];
        }
        
        return $types;
    }
    
    // Get armor materials for filter
    public function getArmorMaterials() {
        $sql = "SELECT DISTINCT material FROM armor WHERE material != 'NONE(-)' ORDER BY material";
        $results = $this->db->fetchAll($sql);
        
        $materials = [];
        foreach ($results as $result) {
            $materials[] = $result['material'];
        }
        
        return $materials;
    }
    
    // Get armor grades for filter
    public function getArmorGrades() {
        $sql = "SELECT DISTINCT itemGrade FROM armor ORDER BY FIELD(itemGrade, 'ONLY', 'MYTH', 'LEGEND', 'HERO', 'RARE', 'ADVANC', 'NORMAL')";
        $results = $this->db->fetchAll($sql);
        
        $grades = [];
        foreach ($results as $result) {
            $grades[] = $result['itemGrade'];
        }
        
        return $grades;
    }
    
    // Get armor set details
    public function getArmorSet($setId) {
        $sql = "SELECT * FROM armor_set WHERE id = ?";
        return $this->db->fetchOne($sql, [$setId]);
    }
    
    // Get all armor sets
    public function getAllArmorSets($page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'armor_set',
            $page,
            $perPage,
            '',
            [],
            'id ASC',
            'id, note, sets, min_enchant, ac, hp, mp, mr, str, dex, con, wis, cha, intl'
        );
    }
    
    // Get all armor pieces in a set
    public function getArmorSetPieces($setId) {
        $sql = "SELECT item_id, desc_kr, desc_en, type, iconId, spriteId FROM armor WHERE Set_Id = ? ORDER BY type";
        return $this->db->fetchAll($sql, [$setId]);
    }
    
    // Get stats of armor
    public function getArmorStats($armorId) {
        $sql = "SELECT add_str, add_con, add_dex, add_int, add_wis, add_cha, add_hp, add_mp, 
                add_hpr, add_mpr, add_sp, m_def, damage_reduction, MagicDamageReduction FROM armor 
                WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$armorId]);
    }
    
    // Create a new armor
    public function createArmor($data) {
        return $this->db->insert('armor', $data);
    }
    
    // Update an existing armor
    public function updateArmor($id, $data) {
        return $this->db->update('armor', $data, 'item_id = ?', [$id]);
    }
    
    // Delete an armor
    public function deleteArmor($id) {
        return $this->db->delete('armor', 'item_id = ?', [$id]);
    }
    
    // Create a new armor set
    public function createArmorSet($data) {
        return $this->db->insert('armor_set', $data);
    }
    
    // Update an existing armor set
    public function updateArmorSet($id, $data) {
        return $this->db->update('armor_set', $data, 'id = ?', [$id]);
    }
    
    // Delete an armor set
    public function deleteArmorSet($id) {
        // First update armor items to remove the set association
        $this->db->update('armor', ['Set_Id' => 0], 'Set_Id = ?', [$id]);
        
        // Then delete the set
        return $this->db->delete('armor_set', 'id = ?', [$id]);
    }
    
    // Get recently added armor
    public function getRecentArmor($limit = 5) {
        $sql = "SELECT item_id, desc_kr, desc_en, type, iconId, itemGrade FROM armor ORDER BY item_id DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Get recently added armor sets
    public function getRecentArmorSets($limit = 5) {
        $sql = "SELECT id, note FROM armor_set ORDER BY id DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Get armor icon URL
    public function getArmorIconUrl($iconId) {
        return SITE_URL . '/assets/images/icons/items/' . $iconId . '.png';
    }
    
    // Get armor sprite URL
    public function getArmorSpriteUrl($spriteId) {
        return SITE_URL . '/assets/images/sprites/' . $spriteId . '.png';
    }
}
