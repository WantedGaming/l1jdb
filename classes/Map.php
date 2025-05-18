<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class Map {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Get all maps with pagination
    public function getAllMaps($page = 1, $perPage = ITEMS_PER_PAGE, $orderBy = 'mapids.mapid ASC') {
        return $this->db->paginate(
            'mapids',
            $page,
            $perPage,
            '',
            [],
            $orderBy,
            'mapids.mapid, mapids.locationname, mapids.desc_kr, mapids.startX, mapids.endX, 
            mapids.startY, mapids.endY, mapids.underwater, mapids.dungeon, mapids.teleportable, 
            mapids.escapable, mapids.pngId'
        );
    }
    
    // Get map by ID
    public function getMapById($id) {
        $sql = "SELECT * FROM mapids WHERE mapid = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    // Search maps
    public function searchMaps($searchTerm, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $columns = ['mapids.mapid', 'mapids.locationname', 'mapids.desc_kr'];
        return $this->db->search(
            'mapids',
            $searchTerm,
            $columns,
            $page,
            $perPage,
            '',
            [],
            'mapids.mapid ASC',
            'mapids.mapid, mapids.locationname, mapids.desc_kr, mapids.startX, mapids.endX, 
            mapids.startY, mapids.endY, mapids.underwater, mapids.dungeon, mapids.teleportable, 
            mapids.escapable, mapids.pngId'
        );
    }
    
    // Filter maps
    public function filterMaps($filters = [], $page = 1, $perPage = ITEMS_PER_PAGE) {
        $conditions = [];
        $params = [];
        
        if (isset($filters['dungeon']) && $filters['dungeon'] !== '') {
            $conditions[] = 'mapids.dungeon = ?';
            $params[] = $filters['dungeon'];
        }
        
        if (isset($filters['underwater']) && $filters['underwater'] !== '') {
            $conditions[] = 'mapids.underwater = ?';
            $params[] = $filters['underwater'];
        }
        
        if (isset($filters['teleportable']) && $filters['teleportable'] !== '') {
            $conditions[] = 'mapids.teleportable = ?';
            $params[] = $filters['teleportable'];
        }
        
        if (isset($filters['escapable']) && $filters['escapable'] !== '') {
            $conditions[] = 'mapids.escapable = ?';
            $params[] = $filters['escapable'];
        }
        
        if (isset($filters['beginZone']) && $filters['beginZone'] !== '') {
            $conditions[] = 'mapids.beginZone = ?';
            $params[] = $filters['beginZone'];
        }
        
        if (isset($filters['interWarZone']) && $filters['interWarZone'] !== '') {
            $conditions[] = 'mapids.interWarZone = ?';
            $params[] = $filters['interWarZone'];
        }
        
        $conditionSql = !empty($conditions) ? implode(' AND ', $conditions) : '';
        
        return $this->db->paginate(
            'mapids',
            $page,
            $perPage,
            $conditionSql,
            $params,
            'mapids.mapid ASC',
            'mapids.mapid, mapids.locationname, mapids.desc_kr, mapids.startX, mapids.endX, 
            mapids.startY, mapids.endY, mapids.underwater, mapids.dungeon, mapids.teleportable, 
            mapids.escapable, mapids.pngId'
        );
    }
    
    // Get dungeon maps
    public function getDungeonMaps($page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'mapids',
            $page,
            $perPage,
            'mapids.dungeon = ?',
            [1],
            'mapids.mapid ASC',
            'mapids.mapid, mapids.locationname, mapids.desc_kr, mapids.pngId'
        );
    }
    
    // Get underwater maps
    public function getUnderwaterMaps($page = 1, $perPage = ITEMS_PER_PAGE) {
        return $this->db->paginate(
            'mapids',
            $page,
            $perPage,
            'mapids.underwater = ?',
            [1],
            'mapids.mapid ASC',
            'mapids.mapid, mapids.locationname, mapids.desc_kr, mapids.pngId'
        );
    }
    
    // Get map details
    public function getMapDetails($mapId) {
        $sql = "SELECT mapid, locationname, desc_kr, startX, endX, startY, endY, underwater, 
                dungeon, teleportable, escapable, resurrection, monster_amount, drop_rate, 
                markable, usable_item, usable_skill, decreaseHp, beginZone, interWarZone, 
                dmgModiPc2Npc, dmgModiNpc2Pc, geradBuffZone, growBuffZone FROM mapids WHERE mapid = ?";
        return $this->db->fetchOne($sql, [$mapId]);
    }
    
    // Get NPC spawns in a map
    public function getMapNpcSpawns($mapId) {
        $sql = "SELECT s.id, s.location, s.count, s.npc_templateid, n.desc_kr, n.desc_en, n.lvl, n.hp, n.exp 
                FROM spawnlist s 
                JOIN npc n ON s.npc_templateid = n.npcid 
                WHERE s.mapid = ? AND n.impl IN ('L1Monster', 'L1BlackKnight', 'L1Doppelganger') 
                ORDER BY n.lvl DESC";
        return $this->db->fetchAll($sql, [$mapId]);
    }
    
    // Get cloned maps (for instance dungeons)
    public function getClonedMaps($baseMapId) {
        $sql = "SELECT mapid, locationname, desc_kr FROM mapids 
                WHERE cloneStart <= ? AND cloneEnd >= ? ORDER BY mapid";
        return $this->db->fetchAll($sql, [$baseMapId, $baseMapId]);
    }
    
    // Create a new map
    public function createMap($data) {
        return $this->db->insert('mapids', $data);
    }
    
    // Update an existing map
    public function updateMap($id, $data) {
        return $this->db->update('mapids', $data, 'mapid = ?', [$id]);
    }
    
    // Delete a map
    public function deleteMap($id) {
        return $this->db->delete('mapids', 'mapid = ?', [$id]);
    }
    
    // Get recently added maps
    public function getRecentMaps($limit = 5) {
        $sql = "SELECT mapid, locationname, desc_kr, pngId 
                FROM mapids ORDER BY mapid DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    // Get map image URL
    public function getMapImageUrl($pngId) {
        if ($pngId > 0) {
            return SITE_URL . '/assets/images/maps/' . $pngId . '.png';
        }
        return SITE_URL . '/assets/images/maps/no-map.png';
    }
    
    // Get map count
    public function getMapCount() {
        $sql = "SELECT COUNT(*) as count FROM mapids";
        $result = $this->db->fetchOne($sql);
        return $result['count'];
    }
    
    // Get dungeon map count
    public function getDungeonMapCount() {
        $sql = "SELECT COUNT(*) as count FROM mapids WHERE dungeon = 1";
        $result = $this->db->fetchOne($sql);
        return $result['count'];
    }
    
    // Get spawn count for map
    public function getMapSpawnCount($mapId) {
        $sql = "SELECT COUNT(*) as count FROM spawnlist WHERE mapid = ?";
        $result = $this->db->fetchOne($sql, [$mapId]);
        return $result['count'];
    }
    
    // Get map types for categorization
    public function getMapTypes() {
        $sql = "SELECT 
                CASE 
                    WHEN dungeon = 1 THEN 'Dungeon' 
                    WHEN underwater = 1 THEN 'Underwater' 
                    WHEN beginZone = 1 THEN 'Beginner Zone'
                    WHEN interWarZone = 1 THEN 'War Zone'
                    ELSE 'Regular Map'
                END as map_type 
                FROM mapids
                GROUP BY map_type
                ORDER BY 
                    CASE map_type
                        WHEN 'Beginner Zone' THEN 1
                        WHEN 'Regular Map' THEN 2
                        WHEN 'Dungeon' THEN 3
                        WHEN 'Underwater' THEN 4
                        WHEN 'War Zone' THEN 5
                        ELSE 6
                    END";
        $results = $this->db->fetchAll($sql);
        
        $types = [];
        foreach ($results as $result) {
            $types[] = $result['map_type'];
        }
        
        return $types;
    }
}
