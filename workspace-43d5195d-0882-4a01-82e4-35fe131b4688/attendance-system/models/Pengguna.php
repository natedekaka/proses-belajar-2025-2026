<?php
class Pengguna {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Get all pengguna
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllPengguna($limit = 10, $offset = 0) {
        $query = "SELECT u.*, g.nama as guru_nama, g.nip 
                  FROM pengguna u 
                  LEFT JOIN guru g ON u.guru_id = g.id 
                  ORDER BY u.username ASC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get pengguna by ID
     * @param int $id
     * @return array|bool
     */
    public function getPenggunaById($id) {
        $query = "SELECT u.*, g.nama as guru_nama, g.nip 
                  FROM pengguna u 
                  LEFT JOIN guru g ON u.guru_id = g.id 
                  WHERE u.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get pengguna by username
     * @param string $username
     * @return array|bool
     */
    public function getPenggunaByUsername($username) {
        $query = "SELECT u.*, g.nama as guru_nama, g.nip, g.foto_profil 
                  FROM pengguna u 
                  LEFT JOIN guru g ON u.guru_id = g.id 
                  WHERE u.username = :username";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get pengguna by guru ID
     * @param int $guru_id
     * @return array|bool
     */
    public function getPenggunaByGuruId($guru_id) {
        $query = "SELECT u.*, g.nama as guru_nama, g.nip 
                  FROM pengguna u 
                  LEFT JOIN guru g ON u.guru_id = g.id 
                  WHERE u.guru_id = :guru_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create new pengguna
     * @param array $data
     * @return bool
     */
    public function createPengguna($data) {
        try {
            $query = "INSERT INTO pengguna (username, password, level_akses, guru_id) 
                      VALUES (:username, :password, :level_akses, :guru_id)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':level_akses', $data['level_akses']);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->execute();
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating pengguna: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update pengguna
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updatePengguna($id, $data) {
        try {
            $query = "UPDATE pengguna 
                      SET username = :username, level_akses = :level_akses, guru_id = :guru_id";
            
            if (isset($data['password'])) {
                $query .= ", password = :password";
            }
            
            $query .= " WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':level_akses', $data['level_akses']);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if (isset($data['password'])) {
                $stmt->bindParam(':password', $data['password']);
            }
            
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating pengguna: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete pengguna
     * @param int $id
     * @return bool
     */
    public function deletePengguna($id) {
        try {
            $query = "DELETE FROM pengguna WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting pengguna: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Authenticate user
     * @param string $username
     * @param string $password
     * @return array|bool
     */
    public function authenticate($username, $password) {
        $query = "SELECT u.*, g.nama as guru_nama, g.nip, g.foto_profil 
                  FROM pengguna u 
                  LEFT JOIN guru g ON u.guru_id = g.id 
                  WHERE u.username = :username";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && verifyPassword($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Check if username exists
     * @param string $username
     * @param int $exclude_id
     * @return bool
     */
    public function usernameExists($username, $exclude_id = 0) {
        $query = "SELECT COUNT(*) as total 
                  FROM pengguna 
                  WHERE username = :username AND id != :exclude_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':exclude_id', $exclude_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }
    
    /**
     * Get pengguna count
     * @return int
     */
    public function getPenggunaCount() {
        $query = "SELECT COUNT(*) as total FROM pengguna";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    /**
     * Get pengguna by level akses
     * @param string $level_akses
     * @return array
     */
    public function getPenggunaByLevel($level_akses) {
        $query = "SELECT u.*, g.nama as guru_nama, g.nip 
                  FROM pengguna u 
                  LEFT JOIN guru g ON u.guru_id = g.id 
                  WHERE u.level_akses = :level_akses 
                  ORDER BY u.username ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':level_akses', $level_akses);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Update last login
     * @param int $id
     * @return bool
     */
    public function updateLastLogin($id) {
        try {
            $query = "UPDATE pengguna SET last_login = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating last login: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update password
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function updatePassword($id, $password) {
        try {
            $query = "UPDATE pengguna SET password = :password WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating password: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get active users
     * @param int $minutes
     * @return array
     */
    public function getActiveUsers($minutes = 30) {
        $query = "SELECT u.*, g.nama as guru_nama, g.nip 
                  FROM pengguna u 
                  LEFT JOIN guru g ON u.guru_id = g.id 
                  WHERE u.last_login >= DATE_SUB(NOW(), INTERVAL :minutes MINUTE)
                  ORDER BY u.last_login DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':minutes', $minutes, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create admin user if not exists
     * @return bool
     */
    public function createAdminUser() {
        try {
            // Check if admin already exists
            $query = "SELECT COUNT(*) as total FROM pengguna WHERE level_akses = 'admin'";
            $stmt = $this->db->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                return true; // Admin already exists
            }
            
            // Create admin user
            $admin_data = [
                'username' => 'admin',
                'password' => hashPassword('admin123'),
                'level_akses' => 'admin',
                'guru_id' => null
            ];
            
            return $this->createPengguna($admin_data);
        } catch (PDOException $e) {
            error_log("Error creating admin user: " . $e->getMessage());
            return false;
        }
    }
}
?>