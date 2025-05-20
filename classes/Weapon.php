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
    
    // Delete a weapon with cascading delete of related records
    public function deleteWeapon($id) {
        try {
            // Start a transaction to ensure all operations complete or none do
            $this->db->beginTransaction();
            
            // Initialize deletion tracking
            $deletionReport = [
                'droplist' => 0,
                'weapon_skill' => 0,
                'weapon_skill_model' => 0,
                'weapon_damege' => 0,
                'weapon' => 0
            ];
            
            // Step 1: Count and delete from droplist
            // Count first
            $sql = "SELECT COUNT(*) as count FROM droplist WHERE itemId = ?";
            $result = $this->db->fetchOne($sql, [$id]);
            $deletionReport['droplist'] = $result ? $result['count'] : 0;
            // Then delete
            $this->db->delete('droplist', 'itemId = ?', [$id]);
            
            // Step 2: Count and delete from weapon_skill
            $sql = "SELECT COUNT(*) as count FROM weapon_skill WHERE weapon_id = ?";
            $result = $this->db->fetchOne($sql, [$id]);
            $deletionReport['weapon_skill'] = $result ? $result['count'] : 0;
            $this->db->delete('weapon_skill', 'weapon_id = ?', [$id]);
            
            // Step 3: Count and delete from weapon_skill_model
            $sql = "SELECT COUNT(*) as count FROM weapon_skill_model WHERE item_id = ?";
            $result = $this->db->fetchOne($sql, [$id]);
            $deletionReport['weapon_skill_model'] = $result ? $result['count'] : 0;
            $this->db->delete('weapon_skill_model', 'item_id = ?', [$id]);
            
            // Step 4: Count and delete from weapon_damege
            $sql = "SELECT COUNT(*) as count FROM weapon_damege WHERE item_id = ?";
            $result = $this->db->fetchOne($sql, [$id]);
            $deletionReport['weapon_damege'] = $result ? $result['count'] : 0;
            $this->db->delete('weapon_damege', 'item_id = ?', [$id]);
            
            // Step 5: Delete the weapon itself (should be 1 record)
            $result = $this->db->delete('weapon', 'item_id = ?', [$id]);
            $deletionReport['weapon'] = $result ? 1 : 0;
            
            // If weapon deletion was successful, commit the transaction
            if ($result) {
                $this->db->commit();
                return [
                    'success' => true,
                    'report' => $deletionReport
                ];
            } else {
                // If weapon deletion failed, roll back the transaction
                $this->db->rollBack();
                return [
                    'success' => false,
                    'message' => 'Weapon not found or could not be deleted.'
                ];
            }
        } catch (Exception $e) {
            // If any error occurs, roll back the transaction
            $this->db->rollBack();
            // Log the exception message
            error_log('Error deleting weapon: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
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

    // Get additional damage info for a weapon
    public function getWeaponDamage($weaponId) {
        $sql = "SELECT * FROM weapon_damege WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$weaponId]);
    }

    // Get all weapon stats
    public function getWeaponAllStats($weaponId) {
        $sql = "SELECT * FROM weapon WHERE item_id = ?";
        return $this->db->fetchOne($sql, [$weaponId]);
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
	
	// Get monsters that drop this weapon
	public function getWeaponDrops($weaponId) {
		$sql = "SELECT d.mobId, d.mobname_en, d.moblevel, d.min, d.max, 
					  d.chance, d.Enchant, n.spriteId, n.lvl, n.hp, 
					  n.is_bossmonster  
			   FROM droplist d
			   JOIN npc n ON d.mobId = n.npcid 
			   WHERE d.itemId = ? 
			   ORDER BY d.chance DESC, n.lvl DESC";
		return $this->db->fetchAll($sql, [$weaponId]);
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
}