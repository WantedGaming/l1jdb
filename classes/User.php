<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Check if user credentials are valid
    public function login($username, $password) {
        // Get user from database
        $sql = "SELECT login, password, access_level FROM accounts WHERE login = ?";
        $user = $this->db->fetchOne($sql, [$username]);
        
        // Check if user exists and has admin access
        if ($user && $user['access_level'] >= 1) {
            // Verify password
            if ($password === $user['password']) {
                // Start session if not already started
                if (session_status() == PHP_SESSION_NONE) {
                    init_session();
                }
                
                // Store user info in session
                $_SESSION['user'] = [
                    'login' => $user['login'],
                    'access_level' => $user['access_level']
                ];
                
                // Log activity
                $this->logActivity($user['login'], 'login', 'User logged in');
                
                return true;
            }
        }
        
        return false;
    }
    
    // Log user out
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            init_session();
        }
        
        // Log activity before destroying session
        if (isset($_SESSION['user'])) {
            $this->logActivity($_SESSION['user']['login'], 'logout', 'User logged out');
        }
        
        // Destroy session
        session_unset();
        session_destroy();
        
        return true;
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            init_session();
        }
        
        return isset($_SESSION['user']);
    }
    
    // Check if user is admin
    public function isAdmin() {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        return $_SESSION['user']['access_level'] >= 1;
    }
    
    // Get current user info
    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        $login = $_SESSION['user']['login'];
        
        $sql = "SELECT login, access_level, lastactive FROM accounts WHERE login = ?";
        return $this->db->fetchOne($sql, [$login]);
    }
    
    // Log admin activity
    public function logActivity($username, $activityType, $description, $entityType = null, $entityId = null) {
        // Handle null username by using session data or fallback
        if ($username === null) {
            if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
                $username = $_SESSION['user']['login'];
            } else {
                $username = 'system'; // Fallback value
            }
        }
        
        $data = [
            'admin_username' => $username,
            'activity_type' => $activityType,
            'description' => $description,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // Create admin_activity table if it doesn't exist
        $this->createActivityTableIfNotExists();
        
        // Insert activity log
        $this->db->insert('admin_activity', $data);
    }
    
    // Get admin activity logs
    public function getActivityLogs($page = 1, $perPage = ITEMS_PER_PAGE, $username = null) {
        $conditions = '';
        $params = [];
        
        if ($username) {
            $conditions = 'admin_username = ?';
            $params = [$username];
        }
        
        return $this->db->paginate('admin_activity', $page, $perPage, $conditions, $params, 'timestamp DESC');
    }
    
    // Create admin_activity table if it doesn't exist
    private function createActivityTableIfNotExists() {
        $sql = "
        CREATE TABLE IF NOT EXISTS admin_activity (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_username VARCHAR(50) NOT NULL,
            activity_type VARCHAR(20) NOT NULL,
            description TEXT NOT NULL,
            entity_type VARCHAR(50) NULL,
            entity_id INT NULL,
            ip_address VARCHAR(45) NOT NULL,
            user_agent TEXT NOT NULL,
            timestamp DATETIME NOT NULL
        )
        ";
        
        $this->db->query($sql);
    }
    
    // Update user's last active timestamp
    public function updateLastActive($username) {
        $data = ['lastactive' => date('Y-m-d H:i:s')];
        $this->db->update('accounts', $data, 'login = ?', [$username]);
    }
    
    // Get all admins
    public function getAllAdmins() {
        $sql = "SELECT login, access_level, lastactive FROM accounts WHERE access_level >= 1";
        return $this->db->fetchAll($sql);
    }
}