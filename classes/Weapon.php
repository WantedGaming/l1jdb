<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class Weapon {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Get all weapons with pagination
    public function getAllWeapons($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'weapon.item_id ASC') {
        return $this->db->paginate(
            'weapon',
            $page,
            $perPage,
            '',
            [],
            $orderBy,
            'weapon.item_id, weapon.item_name_id, weapon.desc_kr, weapon.desc_en, weapon.type, 
            weapon.dmg_small, weapon.dmg_large, weapon.material, weapon.weight, weapon.iconId, 
            weapon.spriteId, weapon.itemGrade'
        );
    }
    
    // Get weapon by ID
    public function getWeaponById($id) {
        $sql = "SELECT * FROM weapon WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Search weapons
    public function searchWeapons($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $columns = ['weapon.item_id', 'weapon.desc_kr', 'weapon.desc_en', 'weapon.type', 'weapon.material'];
        return $this->db->search(
            'weapon',
            $searchTerm,
            $columns,
            $page,
            $perPage,
            '',
            [],
            'weapon.item_id ASC',
            'weapon.item_id, weapon.item_name_id, weapon.desc_kr, weapon.desc_en, weapon.type, 
            weapon.dmg_small, weapon.dmg_large, weapon.material, weapon.weight, weapon.iconId, 
            weapon.spriteId, weapon.itemGrade'
        );
    }
    
    // Filter weapons
    public function filterWeapons($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $conditions = [];
        $params = [];
        
        if (!empty($filters['type'])) {
            $conditions[] = 'weapon.type = ?';
            $params[] = $filters['type'];
        }
        
        if (!empty($filters['material'])) {
            $conditions[] = 'weapon.material = ?';
            $params[] = $filters['material'];
        }
        
        if (!empty($filters['grade'])) {
            $conditions[] = 'weapon.itemGrade = ?';
            $params[] = $filters['grade'];
        }
        
        if (!empty($filters['min_dmg'])) {
            $conditions[] = 'weapon.dmg_small >= ?';
            $params[] = $filters['min_dmg'];
        }
        
        if (!empty($filters['max_dmg'])) {
            $conditions[] = 'weapon.dmg_large <= ?';
            $params[] = $filters['max_dmg'];
        }
        
        $conditionSql = !empty($conditions) ? implode(' AND ', $conditions) : '';
        
        return $this->db->paginate(
            'weapon',
            $page,
            $perPage,
            $conditionSql,
            $params,
            'weapon.item_id ASC',
            'weapon.item_id, weapon.item_name_id, weapon.desc_kr, weapon.desc_en, weapon.type, 
            weapon.dmg_small, weapon.dmg_large, weapon.material, weapon.weight, weapon.iconId, 
            weapon.spriteId, weapon.itemGrade'
        );
    }
    
    // Get weapon types for filter
    public function getWeaponTypes() {
        $sql = "SELECT DISTINCT type FROM weapon ORDER BY type";
        $results = $this->db->fetchAll($sql);
        
        $types = [];
        foreach ($results as $result) {
            $types[] = $result['type'];
        }
        
        return $types;
    }
    
    // Get weapon materials for filter
    public function getWeaponMaterials() {
        $sql = "SELECT DISTINCT material FROM weapon ORDER BY material";
        $results = $this->db->fetchAll($sql);
        
        $materials = [];
        foreach ($results as $result) {
            $materials[] = $result['material'];
        }
        
        return $materials;
    }
    
    // Get weapon grades for filter
    public function getWeaponGrades() {
        $sql = "SELECT DISTINCT itemGrade FROM weapon ORDER BY FIELD(itemGrade, 'ONLY', 'MYTH', 'LEGEND', 'HERO', 'RARE', 'ADVANC', 'NORMAL')";
        $results = $this->db->fetchAll($sql);
        
        $grades = [];
        foreach ($results as $result) {
            $grades[] = $result['itemGrade'];
        }
        
        return $grades;
    }
    
    // Get weapon skills
    public function getWeaponSkills($weaponId) {
        $sql = "SELECT * FROM weapon_skill WHERE weapon_id = ?";
        return $this->db->fetchAll($sql, [$weaponId]);
    }
    
    // Create a new weapon
    public function createWeapon($data) {
        return $this->db->insert('weapon', $data);
    }
    
    // Update an existing weapon
    public function updateWeapon($id, $data) {
        return $this->db->update('weapon', $data, 'item_id = ?', [$id]);
    }
    
    // Delete a weapon
    public function deleteWeapon($id) {
        return $this->db->delete('weapon', 'item_id = ?', [$id]);
    }
    
    // Get recently added weapons
    public function getRecentWeapons($limit = 5) {
        $sql = "SELECT item_id, desc_kr, desc_en, type, iconId, itemGrade FROM weapon ORDER BY item_id DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Get weapon icon URL
    public function getWeaponIconUrl($iconId) {
        return SITE_URL . '/assets/img/icons/' . $iconId . '.png';
    }
    
    // Get weapon sprite URL
    public function getWeaponSpriteUrl($spriteId) {
        return SITE_URL . '/assets/img/icons/' . $spriteId . '.png';
    }
}
