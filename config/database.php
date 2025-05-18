<?php
require_once 'config.php';

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserializing of the instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
    
    // Get instance of the database connection
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Get raw PDO connection
    public function getConnection() {
        return $this->connection;
    }
    
    // Execute a query with parameters
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query Error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Fetch a single row
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    // Fetch all rows
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    // Get the last inserted ID
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    
    // Begin a transaction
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    // Commit a transaction
    public function commit() {
        return $this->connection->commit();
    }
    
    // Rollback a transaction
    public function rollback() {
        return $this->connection->rollBack();
    }
    
    // Count rows in a table
    public function count($table, $conditions = '', $params = []) {
        $sql = "SELECT COUNT(*) as count FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }
        
        $result = $this->fetchOne($sql, $params);
        return $result['count'];
    }
    
    // Insert a new record
    public function insert($table, $data) {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = implode(', ', array_fill(0, count($keys), '?'));
        
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        
        $this->query($sql, array_values($data));
        return $this->lastInsertId();
    }
    
    // Update an existing record
    public function update($table, $data, $conditions, $params = []) {
        $sets = [];
        foreach ($data as $key => $value) {
            $sets[] = "$key = ?";
        }
        
        $sql = "UPDATE $table SET " . implode(', ', $sets) . " WHERE $conditions";
        
        $values = array_values($data);
        foreach ($params as $param) {
            $values[] = $param;
        }
        
        return $this->query($sql, $values)->rowCount();
    }
    
    // Delete a record
    public function delete($table, $conditions, $params = []) {
        $sql = "DELETE FROM $table WHERE $conditions";
        return $this->query($sql, $params)->rowCount();
    }
    
    // Function to paginate results
    public function paginate($table, $page = 1, $perPage = ITEMS_PER_PAGE, $conditions = '', $params = [], $orderBy = '', $fields = '*') {
        // Calculate the offset
        $offset = ($page - 1) * $perPage;
        
        // Build the SQL query
        $sql = "SELECT $fields FROM $table";
        
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }
        
        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }
        
        $sql .= " LIMIT $perPage OFFSET $offset";
        
        // Get the data
        $data = $this->fetchAll($sql, $params);
        
        // Count total records for pagination
        $totalRecords = $this->count($table, $conditions, $params);
        $totalPages = ceil($totalRecords / $perPage);
        
        return [
            'data' => $data,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'per_page' => $perPage
        ];
    }
    
    // Search records
    public function search($table, $searchTerm, $columns, $page = 1, $perPage = ITEMS_PER_PAGE, $additionalConditions = '', $additionalParams = [], $orderBy = '', $fields = '*') {
        // Build search conditions
        $searchConditions = [];
        $params = [];
        
        foreach ($columns as $column) {
            $searchConditions[] = "$column LIKE ?";
            $params[] = "%$searchTerm%";
        }
        
        $searchSql = '(' . implode(' OR ', $searchConditions) . ')';
        
        if (!empty($additionalConditions)) {
            $searchSql .= " AND ($additionalConditions)";
            $params = array_merge($params, $additionalParams);
        }
        
        // Get paginated results
        return $this->paginate($table, $page, $perPage, $searchSql, $params, $orderBy, $fields);
    }
}
