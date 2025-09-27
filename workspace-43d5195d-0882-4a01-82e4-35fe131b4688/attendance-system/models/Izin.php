<?php
class Izin {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Get all izin
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllIzin($limit = 10, $offset = 0) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  ORDER BY i.created_at DESC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get izin by ID
     * @param int $id
     * @return array|bool
     */
    public function getIzinById($id) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE i.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get izin by guru ID
     * @param int $guru_id
     * @return array
     */
    public function getIzinByGuruId($guru_id) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE i.guru_id = :guru_id 
                  ORDER BY i.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get izin by status
     * @param string $status
     * @return array
     */
    public function getIzinByStatus($status) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE i.status_approval = :status 
                  ORDER BY i.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get izin by date range
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getIzinByDateRange($start_date, $end_date) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE i.tanggal_mulai BETWEEN :start_date AND :end_date 
                  ORDER BY i.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create new izin
     * @param array $data
     * @return bool
     */
    public function createIzin($data) {
        try {
            $query = "INSERT INTO izin 
                      (guru_id, tanggal_mulai, tanggal_selesai, jenis_izin, alasan, status_approval, file_bukti) 
                      VALUES 
                      (:guru_id, :tanggal_mulai, :tanggal_selesai, :jenis_izin, :alasan, :status_approval, :file_bukti)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->bindParam(':tanggal_mulai', $data['tanggal_mulai']);
            $stmt->bindParam(':tanggal_selesai', $data['tanggal_selesai']);
            $stmt->bindParam(':jenis_izin', $data['jenis_izin']);
            $stmt->bindParam(':alasan', $data['alasan']);
            $stmt->bindParam(':status_approval', $data['status_approval']);
            $stmt->bindParam(':file_bukti', $data['file_bukti']);
            $stmt->execute();
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating izin: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update izin
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateIzin($id, $data) {
        try {
            $query = "UPDATE izin 
                      SET guru_id = :guru_id, tanggal_mulai = :tanggal_mulai, 
                          tanggal_selesai = :tanggal_selesai, jenis_izin = :jenis_izin, 
                          alasan = :alasan, status_approval = :status_approval, file_bukti = :file_bukti 
                      WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->bindParam(':tanggal_mulai', $data['tanggal_mulai']);
            $stmt->bindParam(':tanggal_selesai', $data['tanggal_selesai']);
            $stmt->bindParam(':jenis_izin', $data['jenis_izin']);
            $stmt->bindParam(':alasan', $data['alasan']);
            $stmt->bindParam(':status_approval', $data['status_approval']);
            $stmt->bindParam(':file_bukti', $data['file_bukti']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating izin: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update izin status
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateIzinStatus($id, $status) {
        try {
            $query = "UPDATE izin SET status_approval = :status WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating izin status: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete izin
     * @param int $id
     * @return bool
     */
    public function deleteIzin($id) {
        try {
            $query = "DELETE FROM izin WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting izin: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get izin count
     * @return int
     */
    public function getIzinCount() {
        $query = "SELECT COUNT(*) as total FROM izin";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    /**
     * Get pending izin count
     * @return int
     */
    public function getPendingIzinCount() {
        $query = "SELECT COUNT(*) as total FROM izin WHERE status_approval = 'pending'";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    /**
     * Check date overlap
     * @param int $guru_id
     * @param string $tanggal_mulai
     * @param string $tanggal_selesai
     * @param int $exclude_id
     * @return bool
     */
    public function checkDateOverlap($guru_id, $tanggal_mulai, $tanggal_selesai, $exclude_id = 0) {
        $query = "SELECT COUNT(*) as total 
                  FROM izin 
                  WHERE guru_id = :guru_id AND id != :exclude_id 
                  AND ((tanggal_mulai <= :tanggal_mulai AND tanggal_selesai >= :tanggal_mulai) 
                       OR (tanggal_mulai <= :tanggal_selesai AND tanggal_selesai >= :tanggal_selesai) 
                       OR (tanggal_mulai >= :tanggal_mulai AND tanggal_selesai <= :tanggal_selesai))";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->bindParam(':tanggal_mulai', $tanggal_mulai);
        $stmt->bindParam(':tanggal_selesai', $tanggal_selesai);
        $stmt->bindParam(':exclude_id', $exclude_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }
    
    /**
     * Get izin statistics
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getIzinStats($start_date, $end_date) {
        $query = "SELECT 
                    jenis_izin,
                    COUNT(*) as total
                  FROM izin 
                  WHERE tanggal_mulai BETWEEN :start_date AND :end_date
                  GROUP BY jenis_izin";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get izin by jenis
     * @param string $jenis
     * @return array
     */
    public function getIzinByJenis($jenis) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE i.jenis_izin = :jenis 
                  ORDER BY i.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':jenis', $jenis);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get active izin for guru
     * @param int $guru_id
     * @param string $date
     * @return array
     */
    public function getActiveIzinForGuru($guru_id, $date) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE i.guru_id = :guru_id 
                  AND i.status_approval = 'approved' 
                  AND i.tanggal_mulai <= :date 
                  AND i.tanggal_selesai >= :date 
                  ORDER BY i.tanggal_mulai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get izin with file bukti
     * @return array
     */
    public function getIzinWithFileBukti() {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE i.file_bukti IS NOT NULL AND i.file_bukti != '' 
                  ORDER BY i.created_at DESC";
        
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Auto approve izin based on criteria
     * @return int
     */
    public function autoApproveIzin() {
        // This is a placeholder for auto-approval logic
        // In a real application, you might have specific criteria for auto-approval
        return 0;
    }
    
    /**
     * Get izin by month and year
     * @param string $month
     * @param string $year
     * @return array
     */
    public function getIzinByMonth($month, $year) {
        $query = "SELECT i.*, g.nama as guru_nama, g.nip 
                  FROM izin i 
                  INNER JOIN guru g ON i.guru_id = g.id 
                  WHERE MONTH(i.tanggal_mulai) = :month AND YEAR(i.tanggal_mulai) = :year 
                  ORDER BY i.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>