<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class Map
{
    private $db;
    private $perPage = 20;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all maps with pagination
     *
     * @param int $page Current page number
     * @return array Maps data with pagination info
     */
    public function getAllMaps(int $page = 1): array
    {
        $offset = ($page - 1) * $this->perPage;
        
        $query = "SELECT * FROM mapids ORDER BY mapid ASC LIMIT ?, ?";
        $maps = $this->db->fetchAll($query, [$offset, $this->perPage]);
        
        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) as total FROM mapids";
        $result = $this->db->fetchAll($countQuery);
        $totalRecords = $result[0]['total'] ?? 0;
        
        return [
            'data' => $maps,
            'total_records' => $totalRecords,
            'total_pages' => ceil($totalRecords / $this->perPage),
            'current_page' => $page
        ];
    }

    /**
     * Get a single map by ID
     *
     * @param int $mapId Map ID
     * @return array|null Map data or null if not found
     */
    public function getMapById(int $mapId): ?array
    {
        $query = "SELECT * FROM mapids WHERE mapid = ?";
        $result = $this->db->fetchOne($query, [$mapId]);
        
        return $result ?: null;
    }

    /**
     * Search maps by name
     *
     * @param string $searchTerm Search term
     * @param int $page Current page number
     * @return array Maps data with pagination info
     */
    public function searchMaps(string $searchTerm, int $page = 1): array
    {
        $offset = ($page - 1) * $this->perPage;
        $searchPattern = "%{$searchTerm}%";
        
        $query = "SELECT * FROM mapids WHERE 
                 locationname LIKE ? OR 
                 desc_kr LIKE ? 
                 ORDER BY mapid ASC LIMIT ?, ?";
        
        $maps = $this->db->fetchAll($query, [$searchPattern, $searchPattern, $offset, $this->perPage]);
        
        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) as total FROM mapids WHERE 
                     locationname LIKE ? OR 
                     desc_kr LIKE ?";
        
        $result = $this->db->fetchAll($countQuery, [$searchPattern, $searchPattern]);
        $totalRecords = $result[0]['total'] ?? 0;
        
        return [
            'data' => $maps,
            'total_records' => $totalRecords,
            'total_pages' => ceil($totalRecords / $this->perPage),
            'current_page' => $page
        ];
    }

    /**
     * Filter maps based on criteria
     *
     * @param array $filters Filter criteria
     * @param int $page Current page number
     * @return array Maps data with pagination info
     */
    public function filterMaps(array $filters, int $page = 1): array
    {
        $offset = ($page - 1) * $this->perPage;
        $whereConditions = [];
        $params = [];
        
        // Build WHERE conditions based on filters
        if (!empty($filters['underwater']) && $filters['underwater'] !== 'all') {
            $whereConditions[] = "underwater = ?";
            $params[] = $filters['underwater'] === 'yes' ? 1 : 0;
        }
        
        if (!empty($filters['markable']) && $filters['markable'] !== 'all') {
            $whereConditions[] = "markable = ?";
            $params[] = $filters['markable'] === 'yes' ? 1 : 0;
        }
        
        if (!empty($filters['teleportable']) && $filters['teleportable'] !== 'all') {
            $whereConditions[] = "teleportable = ?";
            $params[] = $filters['teleportable'] === 'yes' ? 1 : 0;
        }
        
        if (!empty($filters['dungeon']) && $filters['dungeon'] !== 'all') {
            $whereConditions[] = "dungeon = ?";
            $params[] = $filters['dungeon'] === 'yes' ? 1 : 0;
        }
        
        // Base query
        $query = "SELECT * FROM mapids";
        
        // Add WHERE clause if we have conditions
        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }
        
        // Add ORDER BY and LIMIT
        $query .= " ORDER BY mapid ASC LIMIT ?, ?";
        
        // Add pagination params
        $params[] = $offset;
        $params[] = $this->perPage;
        
        $maps = $this->db->fetchAll($query, $params);
        
        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) as total FROM mapids";
        
        if (!empty($whereConditions)) {
            $countQuery .= " WHERE " . implode(" AND ", $whereConditions);
        }
        
        $countParams = array_slice($params, 0, count($params) - 2); // Remove LIMIT params
        $result = $this->db->fetchAll($countQuery, $countParams);
        $totalRecords = $result[0]['total'] ?? 0;
        
        return [
            'data' => $maps,
            'total_records' => $totalRecords,
            'total_pages' => ceil($totalRecords / $this->perPage),
            'current_page' => $page
        ];
    }

    /**
     * Create a new map
     *
     * @param array $mapData Map data
     * @return int|false ID of the newly created map or false on failure
     */
    public function createMap(array $mapData)
    {
        $query = "INSERT INTO mapids (
            mapid, locationname, desc_kr, startX, endX, startY, endY, 
            monster_amount, drop_rate, underwater, markable, teleportable, 
            escapable, resurrection, painwand, penalty, take_pets, 
            recall_pets, usable_item, usable_skill, dungeon, 
            dmgModiPc2Npc, dmgModiNpc2Pc, decreaseHp, dominationTeleport, 
            beginZone, redKnightZone, ruunCastleZone, interWarZone, 
            geradBuffZone, growBuffZone, interKind, script, 
            cloneStart, cloneEnd, pngId
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
        
        $params = [
            $mapData['mapid'] ?? 0,
            $mapData['locationname'] ?? null,
            $mapData['desc_kr'] ?? '',
            $mapData['startX'] ?? 0,
            $mapData['endX'] ?? 0,
            $mapData['startY'] ?? 0,
            $mapData['endY'] ?? 0,
            $mapData['monster_amount'] ?? 0,
            $mapData['drop_rate'] ?? 0,
            $mapData['underwater'] ?? 0,
            $mapData['markable'] ?? 0,
            $mapData['teleportable'] ?? 0,
            $mapData['escapable'] ?? 0,
            $mapData['resurrection'] ?? 0,
            $mapData['painwand'] ?? 0,
            $mapData['penalty'] ?? 0,
            $mapData['take_pets'] ?? 0,
            $mapData['recall_pets'] ?? 0,
            $mapData['usable_item'] ?? 0,
            $mapData['usable_skill'] ?? 0,
            $mapData['dungeon'] ?? 0,
            $mapData['dmgModiPc2Npc'] ?? 0,
            $mapData['dmgModiNpc2Pc'] ?? 0,
            $mapData['decreaseHp'] ?? 0,
            $mapData['dominationTeleport'] ?? 0,
            $mapData['beginZone'] ?? 0,
            $mapData['redKnightZone'] ?? 0,
            $mapData['ruunCastleZone'] ?? 0,
            $mapData['interWarZone'] ?? 0,
            $mapData['geradBuffZone'] ?? 0,
            $mapData['growBuffZone'] ?? 0,
            $mapData['interKind'] ?? 0,
            $mapData['script'] ?? null,
            $mapData['cloneStart'] ?? 0,
            $mapData['cloneEnd'] ?? 0,
            $mapData['pngId'] ?? 0
        ];
        
        return $this->db->query($query, $params) ? $mapData['mapid'] : false;
    }

    /**
     * Update an existing map
     *
     * @param int $mapId Map ID
     * @param array $mapData Map data
     * @return bool Success status
     */
    public function updateMap(int $mapId, array $mapData): bool
    {
        $query = "UPDATE mapids SET
            locationname = ?,
            desc_kr = ?,
            startX = ?,
            endX = ?,
            startY = ?,
            endY = ?,
            monster_amount = ?,
            drop_rate = ?,
            underwater = ?,
            markable = ?,
            teleportable = ?,
            escapable = ?,
            resurrection = ?,
            painwand = ?,
            penalty = ?,
            take_pets = ?,
            recall_pets = ?,
            usable_item = ?,
            usable_skill = ?,
            dungeon = ?,
            dmgModiPc2Npc = ?,
            dmgModiNpc2Pc = ?,
            decreaseHp = ?,
            dominationTeleport = ?,
            beginZone = ?,
            redKnightZone = ?,
            ruunCastleZone = ?,
            interWarZone = ?,
            geradBuffZone = ?,
            growBuffZone = ?,
            interKind = ?,
            script = ?,
            cloneStart = ?,
            cloneEnd = ?,
            pngId = ?
        WHERE mapid = ?";
        
        $params = [
            $mapData['locationname'] ?? null,
            $mapData['desc_kr'] ?? '',
            $mapData['startX'] ?? 0,
            $mapData['endX'] ?? 0,
            $mapData['startY'] ?? 0,
            $mapData['endY'] ?? 0,
            $mapData['monster_amount'] ?? 0,
            $mapData['drop_rate'] ?? 0,
            $mapData['underwater'] ?? 0,
            $mapData['markable'] ?? 0,
            $mapData['teleportable'] ?? 0,
            $mapData['escapable'] ?? 0,
            $mapData['resurrection'] ?? 0,
            $mapData['painwand'] ?? 0,
            $mapData['penalty'] ?? 0,
            $mapData['take_pets'] ?? 0,
            $mapData['recall_pets'] ?? 0,
            $mapData['usable_item'] ?? 0,
            $mapData['usable_skill'] ?? 0,
            $mapData['dungeon'] ?? 0,
            $mapData['dmgModiPc2Npc'] ?? 0,
            $mapData['dmgModiNpc2Pc'] ?? 0,
            $mapData['decreaseHp'] ?? 0,
            $mapData['dominationTeleport'] ?? 0,
            $mapData['beginZone'] ?? 0,
            $mapData['redKnightZone'] ?? 0,
            $mapData['ruunCastleZone'] ?? 0,
            $mapData['interWarZone'] ?? 0,
            $mapData['geradBuffZone'] ?? 0,
            $mapData['growBuffZone'] ?? 0,
            $mapData['interKind'] ?? 0,
            $mapData['script'] ?? null,
            $mapData['cloneStart'] ?? 0,
            $mapData['cloneEnd'] ?? 0,
            $mapData['pngId'] ?? 0,
            $mapId
        ];
        
        $stmt = $this->db->query($query, $params);
        return $stmt ? $stmt->rowCount() > 0 : false;
    }

    /**
     * Delete a map
     *
     * @param int $mapId Map ID
     * @return bool Success status
     */
    public function deleteMap(int $mapId): bool
    {
        $query = "DELETE FROM mapids WHERE mapid = ?";
        $stmt = $this->db->query($query, [$mapId]);
        return $stmt ? $stmt->rowCount() > 0 : false;
    }

    /**
     * Get map types for filtering
     *
     * @return array Map types
     */
    public function getMapTypes(): array
    {
        $query = "SELECT DISTINCT type FROM map_type ORDER BY type";
        $results = $this->db->fetchAll($query);
        
        $types = [];
        foreach ($results as $result) {
            $types[] = $result['type'];
        }
        
        return $types;
    }

    /**
     * Get recent maps with limit
     *
     * @param int $limit Number of maps to retrieve
     * @return array Recent maps data
     */
    public function getRecentMaps(int $limit = 4): array
    {
        $query = "SELECT * FROM mapids ORDER BY mapid DESC LIMIT ?";
        return $this->db->fetchAll($query, [$limit]);
    }

    /**
     * Get map image URL based on pngId
     *
     * @param int $pngId The PNG ID for the map
     * @return string URL to the map image
     */
    public function getMapImageUrl(int $pngId): string
    {
        $iconPath = "/assets/img/icons/{$pngId}.png";
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $iconPath;
        
        if ($pngId > 0 && file_exists($fullPath)) {
            return $iconPath;
        }
        
        // Default icon if not found
        return "/assets/img/placeholders/noimage.png";
    }
}
