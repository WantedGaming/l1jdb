<?php
/**
 * Map class for handling map-related database operations
 */
class Map {
    private $db;
    private $itemsPerPage = 24;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Get all maps with pagination
     */
    public function getAllMaps($page = 1) {
        $offset = ($page - 1) * $this->itemsPerPage;
        
        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM mapids";
        $totalResult = $this->db->fetchAll($countQuery);
        $totalRecords = $totalResult[0]['total'];
        $totalPages = ceil($totalRecords / $this->itemsPerPage);
        
        // Get paginated results - include all fields that might be used in filtering
        $query = "SELECT mapid, locationname, desc_kr, pngId, underwater, markable, 
                         teleportable, dungeon, monster_amount, drop_rate, beginZone, 
                         redKnightZone, ruunCastleZone
                  FROM mapids 
                  ORDER BY mapid ASC 
                  LIMIT ? OFFSET ?";
        
        $maps = $this->db->fetchAll($query, [$this->itemsPerPage, $offset]);
        
        return [
            'data' => $maps,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'items_per_page' => $this->itemsPerPage
        ];
    }
    
    /**
     * Search maps by name or location
     */
    public function searchMaps($searchTerm, $page = 1) {
        $offset = ($page - 1) * $this->itemsPerPage;
        $searchPattern = "%{$searchTerm}%";
        
        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM mapids 
                       WHERE locationname LIKE ? OR desc_kr LIKE ? OR mapid LIKE ?";
        $totalResult = $this->db->fetchAll($countQuery, [$searchPattern, $searchPattern, $searchPattern]);
        $totalRecords = $totalResult[0]['total'];
        $totalPages = ceil($totalRecords / $this->itemsPerPage);
        
        // Get paginated results
        $query = "SELECT mapid, locationname, desc_kr, pngId, underwater, markable, 
                         teleportable, dungeon, monster_amount, drop_rate, beginZone, 
                         redKnightZone, ruunCastleZone
                  FROM mapids 
                  WHERE locationname LIKE ? OR desc_kr LIKE ? OR mapid LIKE ?
                  ORDER BY 
                    CASE 
                      WHEN locationname LIKE ? THEN 1
                      WHEN desc_kr LIKE ? THEN 2
                      ELSE 3
                    END,
                    mapid ASC
                  LIMIT ? OFFSET ?";
        
        $maps = $this->db->fetchAll($query, [
            $searchPattern, $searchPattern, $searchPattern,
            $searchPattern, $searchPattern,
            $this->itemsPerPage, $offset
        ]);
        
        return [
            'data' => $maps,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'items_per_page' => $this->itemsPerPage
        ];
    }
    
    /**
     * Filter maps based on criteria
     */
    public function filterMaps($filters, $page = 1) {
        $offset = ($page - 1) * $this->itemsPerPage;
        $whereConditions = [];
        $params = [];
        
        // Build WHERE conditions based on filters
        if (!empty($filters['underwater'])) {
            $whereConditions[] = "underwater = ?";
            $params[] = ($filters['underwater'] === 'yes') ? 1 : 0;
        }
        
        if (!empty($filters['markable'])) {
            $whereConditions[] = "markable = ?";
            $params[] = ($filters['markable'] === 'yes') ? 1 : 0;
        }
        
        if (!empty($filters['teleportable'])) {
            $whereConditions[] = "teleportable = ?";
            $params[] = ($filters['teleportable'] === 'yes') ? 1 : 0;
        }
        
        if (!empty($filters['dungeon'])) {
            $whereConditions[] = "dungeon = ?";
            $params[] = ($filters['dungeon'] === 'yes') ? 1 : 0;
        }
        
        if (!empty($filters['map_type'])) {
            // Filter based on map characteristics instead of separate table
            switch ($filters['map_type']) {
                case 'DUNGEON':
                    $whereConditions[] = "dungeon = 1";
                    break;
                case 'UNDERWATER':
                    $whereConditions[] = "underwater = 1";
                    break;
                case 'SPECIAL':
                    $whereConditions[] = "(beginZone = 1 OR redKnightZone = 1 OR ruunCastleZone = 1)";
                    break;
                case 'FIELD':
                    $whereConditions[] = "dungeon = 0 AND underwater = 0 AND beginZone = 0 AND redKnightZone = 0 AND ruunCastleZone = 0";
                    break;
            }
        }
        
        $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
        
        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM mapids {$whereClause}";
        $totalResult = $this->db->fetchAll($countQuery, $params);
        $totalRecords = $totalResult[0]['total'];
        $totalPages = ceil($totalRecords / $this->itemsPerPage);
        
        // Get paginated results
        $query = "SELECT mapid, locationname, desc_kr, pngId, underwater, markable, 
                         teleportable, dungeon, monster_amount, drop_rate, beginZone, 
                         redKnightZone, ruunCastleZone
                  FROM mapids 
                  {$whereClause}
                  ORDER BY mapid ASC 
                  LIMIT ? OFFSET ?";
        
        $params[] = $this->itemsPerPage;
        $params[] = $offset;
        
        $maps = $this->db->fetchAll($query, $params);
        
        return [
            'data' => $maps,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'items_per_page' => $this->itemsPerPage
        ];
    }
    
    /**
     * Get a single map by ID
     */
    public function getMapById($mapId) {
        $query = "SELECT * FROM mapids WHERE mapid = ?";
        $result = $this->db->fetchAll($query, [$mapId]);
        
        return !empty($result) ? $result[0] : null;
    }
    
    /**
     * Get recent maps (for dashboard/homepage)
     */
    public function getRecentMaps($limit = 10) {
        $query = "SELECT mapid, locationname, desc_kr, pngId, dungeon
                  FROM mapids 
                  ORDER BY mapid DESC 
                  LIMIT ?";
        
        return $this->db->fetchAll($query, [$limit]);
    }
    
    /**
     * Get map statistics
     */
    public function getMapStats() {
        $stats = [];
        
        // Total maps
        $totalQuery = "SELECT COUNT(*) as total FROM mapids";
        $result = $this->db->fetchAll($totalQuery);
        $stats['total_maps'] = $result[0]['total'];
        
        // Dungeons vs Fields
        $dungeonQuery = "SELECT 
                            SUM(CASE WHEN dungeon = 1 THEN 1 ELSE 0 END) as dungeons,
                            SUM(CASE WHEN dungeon = 0 THEN 1 ELSE 0 END) as fields
                         FROM mapids";
        $result = $this->db->fetchAll($dungeonQuery);
        $stats['dungeons'] = $result[0]['dungeons'];
        $stats['fields'] = $result[0]['fields'];
        
        // Underwater maps
        $underwaterQuery = "SELECT COUNT(*) as underwater FROM mapids WHERE underwater = 1";
        $result = $this->db->fetchAll($underwaterQuery);
        $stats['underwater'] = $result[0]['underwater'];
        
        // Teleportable maps
        $teleportQuery = "SELECT COUNT(*) as teleportable FROM mapids WHERE teleportable = 1";
        $result = $this->db->fetchAll($teleportQuery);
        $stats['teleportable'] = $result[0]['teleportable'];
        
        return $stats;
    }
    
    /**
     * Get maps by type based on existing fields
     */
    public function getMapsByType($type, $page = 1) {
        $offset = ($page - 1) * $this->itemsPerPage;
        $whereCondition = "";
        
        switch ($type) {
            case 'DUNGEON':
                $whereCondition = "WHERE dungeon = 1";
                break;
            case 'UNDERWATER':
                $whereCondition = "WHERE underwater = 1";
                break;
            case 'SPECIAL':
                $whereCondition = "WHERE (beginZone = 1 OR redKnightZone = 1 OR ruunCastleZone = 1)";
                break;
            case 'FIELD':
                $whereCondition = "WHERE dungeon = 0 AND underwater = 0 AND beginZone = 0 AND redKnightZone = 0 AND ruunCastleZone = 0";
                break;
            default:
                $whereCondition = "";
        }
        
        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM mapids {$whereCondition}";
        $totalResult = $this->db->fetchAll($countQuery);
        $totalRecords = $totalResult[0]['total'];
        $totalPages = ceil($totalRecords / $this->itemsPerPage);
        
        // Get paginated results
        $query = "SELECT mapid, locationname, desc_kr, pngId, underwater, markable, 
                         teleportable, dungeon, monster_amount, drop_rate, beginZone, 
                         redKnightZone, ruunCastleZone
                  FROM mapids 
                  {$whereCondition}
                  ORDER BY mapid ASC 
                  LIMIT ? OFFSET ?";
        
        $maps = $this->db->fetchAll($query, [$this->itemsPerPage, $offset]);
        
        return [
            'data' => $maps,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'items_per_page' => $this->itemsPerPage
        ];
    }
    
    /**
     * Get map image URL
     */
    public function getMapImageUrl($pngId) {
        // Default image or placeholder
        $defaultIcon = '/l1jdb/assets/img/placeholders/0.png';
        
        if (empty($pngId) || $pngId == 0) {
            return $defaultIcon;
        }
        
        // Try different possible paths for map images
        $possiblePaths = [
            "/l1jdb/assets/img/maps/{$pngId}.png",
            "/l1jdb/assets/img/maps/{$pngId}.jpg",
            "/l1jdb/assets/img/maps/map_{$pngId}.png",
            "/l1jdb/assets/img/icons/{$pngId}.png"
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
                return $path;
            }
        }
        
        // Return placeholder if no image found
        return $defaultIcon;
    }
    
    /**
     * Get random featured maps for homepage
     */
    public function getFeaturedMaps($limit = 6) {
        $query = "SELECT mapid, locationname, desc_kr, pngId, dungeon, underwater
                  FROM mapids 
                  WHERE locationname IS NOT NULL AND locationname != ''
                  ORDER BY RAND() 
                  LIMIT ?";
        
        return $this->db->fetchAll($query, [$limit]);
    }
    
    /**
     * Get maps count by category
     */
    public function getMapCounts() {
        $counts = [];
        
        // Total maps
        $query = "SELECT COUNT(*) as total FROM mapids";
        $result = $this->db->fetchAll($query);
        $counts['total'] = $result[0]['total'];
        
        // Dungeons
        $query = "SELECT COUNT(*) as count FROM mapids WHERE dungeon = 1";
        $result = $this->db->fetchAll($query);
        $counts['dungeons'] = $result[0]['count'];
        
        // Underwater
        $query = "SELECT COUNT(*) as count FROM mapids WHERE underwater = 1";
        $result = $this->db->fetchAll($query);
        $counts['underwater'] = $result[0]['count'];
        
        // Special zones
        $query = "SELECT COUNT(*) as count FROM mapids WHERE beginZone = 1 OR redKnightZone = 1 OR ruunCastleZone = 1";
        $result = $this->db->fetchAll($query);
        $counts['special'] = $result[0]['count'];
        
        // Fields (everything else)
        $counts['fields'] = $counts['total'] - $counts['dungeons'] - $counts['underwater'] - $counts['special'];
        
        return $counts;
    }
}
?>