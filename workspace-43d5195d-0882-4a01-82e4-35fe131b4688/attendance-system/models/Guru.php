<?php
class Guru {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Get all guru
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllGuru($limit = 10, $offset = 0) {
        $query = "SELECT g.*, u.username, u.level_akses 
                  FROM guru g 
                  LEFT JOIN pengguna u ON g.id = u.guru_id 
                  WHERE g.status_aktif = 1 
                  ORDER BY g.nama ASC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get guru by ID
     * @param int $id
     * @return array|bool
     */
    public function getGuruById($id) {
        $query = "SELECT g.*, u.username, u.level_akses 
                  FROM guru g 
                  LEFT JOIN pengguna u ON g.id = u.guru_id 
                  WHERE g.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get guru by NIP
     * @param string $nip
     * @return array|bool
     */
    public function getGuruByNIP($nip) {
        $query = "SELECT g.*, u.username, u.level_akses 
                  FROM guru g 
                  LEFT JOIN pengguna u ON g.id = u.guru_id 
                  WHERE g.nip = :nip";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nip', $nip);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create new guru
     * @param array $data
     * @return bool
     */
    public function createGuru($data) {
        try {
            $this->db->beginTransaction();
            
            // Insert guru data
            $query = "INSERT INTO guru (nama, nip, jabatan, status_aktif, foto_profil) 
                      VALUES (:nama, :nip, :jabatan, :status_aktif, :foto_profil)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':nip', $data['nip']);
            $stmt->bindParam(':jabatan', $data['jabatan']);
            $stmt->bindParam(':status_aktif', $data['status_aktif']);
            $stmt->bindParam(':foto_profil', $data['foto_profil']);
            $stmt->execute();
            
            $guru_id = $this->db->lastInsertId();
            
            // Create user account
            $query = "INSERT INTO pengguna (username, password, level_akses, guru_id) 
                      VALUES (:username, :password, :level_akses, :guru_id)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':level_akses', $data['level_akses']);
            $stmt->bindParam(':guru_id', $guru_id);
            $stmt->execute();
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error creating guru: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update guru
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateGuru($id, $data) {
        try {
            $this->db->beginTransaction();
            
            // Update guru data
            $query = "UPDATE guru 
                      SET nama = :nama, nip = :nip, jabatan = :jabatan, 
                          status_aktif = :status_aktif, foto_profil = :foto_profil 
                      WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':nip', $data['nip']);
            $stmt->bindParam(':jabatan', $data['jabatan']);
            $stmt->bindParam(':status_aktif', $data['status_aktif']);
            $stmt->bindParam(':foto_profil', $data['foto_profil']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Update user account if provided
            if (isset($data['username'])) {
                $query = "UPDATE pengguna 
                          SET username = :username";
                
                if (isset($data['password'])) {
                    $query .= ", password = :password";
                }
                
                $query .= " WHERE guru_id = :guru_id";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':username', $data['username']);
                $stmt->bindParam(':guru_id', $id, PDO::PARAM_INT);
                
                if (isset($data['password'])) {
                    $stmt->bindParam(':password', $data['password']);
                }
                
                $stmt->execute();
            }
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error updating guru: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete guru (soft delete)
     * @param int $id
     * @return bool
     */
    public function deleteGuru($id) {
        try {
            $query = "UPDATE guru SET status_aktif = 0 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting guru: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get guru with schedule today
     * @param string $date
     * @return array
     */
    public function getGuruWithScheduleToday($date) {
        $day = date('l', strtotime($date));
        
        $query = "SELECT DISTINCT g.*, j.hari, j.jam_mulai, j.jam_selesai, 
                         j.mata_pelajaran, j.kelas, j.semester, j.tahun_ajaran
                  FROM guru g
                  INNER JOIN jadwal_mengajar j ON g.id = j.guru_id
                  WHERE g.status_aktif = 1 AND j.hari = :hari
                  ORDER BY g.nama, j.jam_mulai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hari', $day);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get guru count
     * @return int
     */
    public function getGuruCount() {
        $query = "SELECT COUNT(*) as total FROM guru WHERE status_aktif = 1";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    /**
     * Search guru
     * @param string $keyword
     * @return array
     */
    public function searchGuru($keyword) {
        $query = "SELECT g.*, u.username, u.level_akses 
                  FROM guru g 
                  LEFT JOIN pengguna u ON g.id = u.guru_id 
                  WHERE g.status_aktif = 1 AND 
                        (g.nama LIKE :keyword OR g.nip LIKE :keyword OR g.jabatan LIKE :keyword)
                  ORDER BY g.nama ASC";
        
        $stmt = $this->db->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get guru by user ID
     * @param int $user_id
     * @return array|bool
     */
    public function getGuruByUserId($user_id) {
        $query = "SELECT g.*, u.id as user_id, u.username, u.level_akses 
                  FROM guru g 
                  INNER JOIN pengguna u ON g.id = u.guru_id 
                  WHERE u.id = :user_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get guru attendance statistics
     * @param int $guru_id
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getGuruAttendanceStats($guru_id, $start_date, $end_date) {
        $query = "SELECT 
                    status_kehadiran,
                    COUNT(*) as total,
                    SUM(CASE WHEN status_kehadiran = 'hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN status_kehadiran = 'terlambat' THEN 1 ELSE 0 END) as terlambat,
                    SUM(CASE WHEN status_kehadiran = 'tidak_hadir' THEN 1 ELSE 0 END) as tidak_hadir,
                    SUM(CASE WHEN status_kehadiran = 'izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN status_kehadiran = 'sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN status_kehadiran = 'cuti' THEN 1 ELSE 0 END) as cuti
                  FROM absensi 
                  WHERE guru_id = :guru_id AND tanggal BETWEEN :start_date AND :end_date
                  GROUP BY status_kehadiran";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>