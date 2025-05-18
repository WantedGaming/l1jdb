<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class Monster {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Get all monsters with pagination (filtered by impl)
    public function getAllMonsters($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'npc.npcid ASC') {
        return $this->db->paginate(
            'npc',
            $page,
            $perPage,
            'npc.impl IN (?, ?, ?)',
            ['L1Monster', 'L1BlackKnight', 'L1Doppelganger'],
            $orderBy,
            'npc.npcid, npc.classId, npc.desc_kr, npc.desc_en, npc.impl, npc.spriteId, 
            npc.lvl, npc.hp, npc.mp, npc.ac, npc.str, npc.con, npc.dex, npc.wis, npc.intel, 
            npc.mr, npc.exp, npc.alignment, npc.big, npc.weakAttr, npc.undead, npc.is_agro'
        );
    }
    
    // Get monster by ID
    public function getMonsterById($id) {
        $sql = "SELECT * FROM npc WHERE npcid = ? AND impl IN ('L1Monster', 'L1BlackKnight', 'L1Doppelganger')";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Search monsters
    public function searchMonsters($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $columns = ['npc.npcid', 'npc.desc_kr', 'npc.desc_en', 'npc.impl', 'npc.family'];
        return $this->db->search(
            'npc',
            $searchTerm,
            $columns,
            $page,
            $perPage,
            'npc.impl IN (?, ?, ?)',
            ['L1Monster', 'L1BlackKnight', 'L1Doppelganger'],
            'npc.npcid ASC',
            'npc.npcid, npc.classId, npc.desc_kr, npc.desc_en, npc.impl, npc.spriteId, 
            npc.lvl, npc.hp, npc.mp, npc.ac, npc.str, npc.con, npc.dex, npc.wis, npc.intel, 
            npc.mr, npc.exp, npc.alignment, npc.big, npc.weakAttr, npc.undead, npc.is_agro'
        );
    }
    
    // Filter monsters
    public function filterMonsters($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $conditions = ['npc.impl IN (?, ?, ?)'];
        $params = ['L1Monster', 'L1BlackKnight', 'L1Doppelganger'];
        
        if (!empty($filters['min_level'])) {
            $conditions[] = 'npc.lvl >= ?';
            $params[] = $filters['min_level'];
        }
        
        if (!empty($filters['max_level'])) {
            $conditions[] = 'npc.lvl <= ?';
            $params[] = $filters['max_level'];
        }
        
        if (!empty($filters['family'])) {
            $conditions[] = 'npc.family = ?';
            $params[] = $filters['family'];
        }
        
        if (!empty($filters['undead'])) {
            $conditions[] = 'npc.undead = ?';
            $params[] = $filters['undead'];
        }
        
        if (isset($filters['is_agro'])) {
            $conditions[] = 'npc.is_agro = ?';
            $params[] = $filters['is_agro'];
        }
        
        if (isset($filters['is_boss'])) {
            $conditions[] = 'npc.is_bossmonster = ?';
            $params[] = $filters['is_boss'];
        }
        
        if (!empty($filters['weakAttr'])) {
            $conditions[] = 'npc.weakAttr = ?';
            $params[] = $filters['weakAttr'];
        }
        
        $conditionSql = implode(' AND ', $conditions);
        
        return $this->db->paginate(
            'npc',
            $page,
            $perPage,
            $conditionSql,
            $params,
            'npc.npcid ASC',
            'npc.npcid, npc.classId, npc.desc_kr, npc.desc_en, npc.impl, npc.spriteId, 
            npc.lvl, npc.hp, npc.mp, npc.ac, npc.str, npc.con, npc.dex, npc.wis, npc.intel, 
            npc.mr, npc.exp, npc.alignment, npc.big, npc.weakAttr, npc.undead, npc.is_agro, 
            npc.is_bossmonster'
        );
    }
    
    
    // Get monster types (families) for filter
    public function getMonsterTypes() {
        $sql = "SELECT DISTINCT family FROM npc WHERE impl IN ('L1Monster', 'L1BlackKnight', 'L1Doppelganger') 
                AND family != '' ORDER BY family";
        $results = $this->db->fetchAll($sql);
        
        $types = [];
        foreach ($results as $result) {
            $types[] = $result['family'];
        }
        
        return $types;
    }
    
    // Get monster undead types for filter
    public function getMonsterUndeadTypes() {
        $sql = "SELECT DISTINCT undead FROM npc WHERE impl IN ('L1Monster', 'L1BlackKnight', 'L1Doppelganger') 
                AND undead != 'NONE' ORDER BY undead";
        $results = $this->db->fetchAll($sql);
        
        $undeadTypes = [];
        foreach ($results as $result) {
            $undeadTypes[] = $result['undead'];
        }
        
        return $undeadTypes;
    }
    
    // Get monster weak attributes for filter
    public function getMonsterWeakAttributes() {
        $sql = "SELECT DISTINCT weakAttr FROM npc WHERE impl IN ('L1Monster', 'L1BlackKnight', 'L1Doppelganger') 
                AND weakAttr != 'NONE' ORDER BY weakAttr";
        $results = $this->db->fetchAll($sql);
        
        $weakAttrs = [];
        foreach ($results as $result) {
            $weakAttrs[] = $result['weakAttr'];
        }
        
        return $weakAttrs;
    }
    
    // Get monster stats
    public function getMonsterStats($monsterId) {
        $sql = "SELECT lvl, hp, mp, ac, str, con, dex, wis, intel, mr, exp, alignment, 
                big, ranged, atkspeed, passispeed, damage_reduction FROM npc 
                WHERE npcid = ?";
        return $this->db->fetchOne($sql, [$monsterId]);
    }
    
    // Get monsters by level range
    public function getMonstersByLevelRange($minLevel, $maxLevel, $page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'npc',
            $page,
            $perPage,
            'npc.impl IN (?, ?, ?) AND npc.lvl >= ? AND npc.lvl <= ?',
            ['L1Monster', 'L1BlackKnight', 'L1Doppelganger', $minLevel, $maxLevel],
            'npc.lvl ASC',
            'npc.npcid, npc.desc_kr, npc.desc_en, npc.spriteId, npc.lvl, npc.hp, npc.exp'
        );
    }
    
    // Get boss monsters
    public function getBossMonsters($page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'npc',
            $page,
            $perPage,
            'npc.impl IN (?, ?, ?) AND npc.is_bossmonster = ?',
            ['L1Monster', 'L1BlackKnight', 'L1Doppelganger', 'true'],
            'npc.lvl DESC',
            'npc.npcid, npc.desc_kr, npc.desc_en, npc.spriteId, npc.lvl, npc.hp, npc.exp'
        );
    }
    
    // Create a new monster
    public function createMonster($data) {
        return $this->db->insert('npc', $data);
    }
    
    // Update an existing monster
    public function updateMonster($id, $data) {
        return $this->db->update('npc', $data, 'npcid = ?', [$id]);
    }
    
    // Delete a monster
    public function deleteMonster($id) {
        return $this->db->delete('npc', 'npcid = ?', [$id]);
    }
    
    // Get recently added monsters
    public function getRecentMonsters($limit = 5) {
        $sql = "SELECT npcid, desc_kr, desc_en, spriteId, lvl, hp, exp 
                FROM npc WHERE impl IN ('L1Monster', 'L1BlackKnight', 'L1Doppelganger') 
                ORDER BY npcid DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Get monster spawn locations
    public function getMonsterSpawnLocations($monsterId) {
        $sql = "SELECT s.id, s.mapid, s.count, s.loc_x, s.loc_y, m.locationname 
                FROM spawnlist s 
                JOIN mapids m ON s.mapid = m.mapid 
                WHERE s.npc_templateid = ?";
        return $this->db->fetchAll($sql, [$monsterId]);
    }
    
    // Get monster sprite URL
    public function getMonsterSpriteUrl($spriteId) {
        return SITE_URL . '/assets/images/sprites/' . $spriteId . '.png';
    }
}
