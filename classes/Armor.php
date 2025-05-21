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
    
    // Get armor by name ID
    public function getArmorByNameId($nameId) {
        $sql = "SELECT * FROM armor WHERE item_name_id = ?";
        return $this->db->fetchAll($sql, [$nameId]);
    }
    
    // Get related bin item data
    public function getBinItemData($nameId) {
        $sql = "SELECT * FROM bin_item_common WHERE name_id = ?";
        return $this->db->fetchOne($sql, [$nameId]);
    }
    
    // Check if armor has related bin data
    public function hasBinData($nameId) {
        if (!$nameId || $nameId <= 0) {
            return false;
        }
        $sql = "SELECT COUNT(*) as count FROM bin_item_common WHERE name_id = ?";
        $result = $this->db->fetchOne($sql, [$nameId]);
        return ($result && $result['count'] > 0);
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
        
        if (!empty($filters['has_bin'])) {
            $conditions[] = 'armor.item_name_id > 0';
            $conditions[] = 'EXISTS (SELECT 1 FROM bin_item_common b WHERE b.name_id = armor.item_name_id)';
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
    
    // Delete an armor with cascading delete of related records
    public function deleteArmor($id) {
        try {
            // Start a transaction
            $this->db->beginTransaction();
            
            // Initialize deletion tracking
            $deletionReport = [
                'droplist' => 0,
                'armor' => 0
            ];
            
            // Step 1: Count and delete from droplist
            $sql = "SELECT COUNT(*) as count FROM droplist WHERE itemId = ?";
            $result = $this->db->fetchOne($sql, [$id]);
            $deletionReport['droplist'] = $result ? $result['count'] : 0;
            $this->db->delete('droplist', 'itemId = ?', [$id]);
            
            // Step 2: Delete the armor itself
            $result = $this->db->delete('armor', 'item_id = ?', [$id]);
            $deletionReport['armor'] = $result ? 1 : 0;
            
            // If successful, commit transaction
            if ($result) {
                $this->db->commit();
                return [
                    'success' => true,
                    'report' => $deletionReport
                ];
            } else {
                // If failed, roll back
                $this->db->rollBack();
                return [
                    'success' => false,
                    'message' => 'Armor not found or could not be deleted.'
                ];
            }
        } catch (Exception $e) {
            // Roll back on any error
            $this->db->rollBack();
            error_log('Error deleting armor: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
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
        // For URL construction (browser access)
        $iconPath = '/assets/img/icons/' . $iconId . '.png';
        
        // For file existence check (server filesystem)
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $iconPath;
        
        // Check if icon exists
        if ($iconId > 0 && file_exists($fullPath)) {
            return SITE_URL . $iconPath;
        } else {
            return SITE_URL . '/assets/img/placeholders/0.png';
        }
    }
    
    // Get monsters that drop an armor
    public function getMonstersThatDropArmor($armorId) {
        $sql = "SELECT d.mobId, d.mobname_en, d.mobname_kr, d.moblevel, d.min, d.max, 
                      d.chance, d.Enchant, n.spriteId, n.lvl, n.hp, 
                      n.is_bossmonster  
               FROM droplist d
               JOIN npc n ON d.mobId = n.npcid 
               WHERE d.itemId = ? 
               ORDER BY d.chance DESC, n.lvl DESC";
        return $this->db->fetchAll($sql, [$armorId]);
    }
    
    // Get monster sprite URL with PNG fallback to GIF
    public function getMonsterSpriteUrl($spriteId) {
        $pngPath = '/assets/img/sprites/' . $spriteId . '.png';
        $gifPath = '/assets/img/sprites/' . $spriteId . '.gif';
        $msPath = '/assets/img/icons/ms' . $spriteId . '.png';
        
        // Check if PNG sprite exists first
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $pngPath)) {
            return SITE_URL . $pngPath;
        }
        
        // Then check if GIF sprite exists
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $gifPath)) {
            return SITE_URL . $gifPath;
        }
        
        // Finally check if ms icon exists
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/l1jdb' . $msPath)) {
            return SITE_URL . $msPath;
        }
        
        // Return placeholder if nothing exists
        return SITE_URL . '/assets/img/placeholders/monster.png';
    }
}