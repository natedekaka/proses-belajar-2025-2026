<?php
class JadwalMengajar {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Get all jadwal mengajar
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllJadwal($limit = 10, $offset = 0) {
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  ORDER BY j.hari, j.jam_mulai 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get jadwal by ID
     * @param int $id
     * @return array|bool
     */
    public function getJadwalById($id) {
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get jadwal by guru ID
     * @param int $guru_id
     * @return array
     */
    public function getJadwalByGuruId($guru_id) {
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.guru_id = :guru_id 
                  ORDER BY j.hari, j.jam_mulai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get jadwal by day
     * @param string $day
     * @return array
     */
    public function getJadwalByDay($day) {
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.hari = :day 
                  ORDER BY j.jam_mulai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':day', $day);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get jadwal by date range
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getJadwalByDateRange($start_date, $end_date) {
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.tanggal BETWEEN :start_date AND :end_date 
                  ORDER BY j.tanggal, j.jam_mulai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create new jadwal mengajar
     * @param array $data
     * @return bool
     */
    public function createJadwal($data) {
        try {
            $query = "INSERT INTO jadwal_mengajar 
                      (guru_id, hari, jam_mulai, jam_selesai, mata_pelajaran, kelas, semester, tahun_ajaran) 
                      VALUES 
                      (:guru_id, :hari, :jam_mulai, :jam_selesai, :mata_pelajaran, :kelas, :semester, :tahun_ajaran)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->bindParam(':hari', $data['hari']);
            $stmt->bindParam(':jam_mulai', $data['jam_mulai']);
            $stmt->bindParam(':jam_selesai', $data['jam_selesai']);
            $stmt->bindParam(':mata_pelajaran', $data['mata_pelajaran']);
            $stmt->bindParam(':kelas', $data['kelas']);
            $stmt->bindParam(':semester', $data['semester']);
            $stmt->bindParam(':tahun_ajaran', $data['tahun_ajaran']);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error creating jadwal: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update jadwal mengajar
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateJadwal($id, $data) {
        try {
            $query = "UPDATE jadwal_mengajar 
                      SET guru_id = :guru_id, hari = :hari, jam_mulai = :jam_mulai, 
                          jam_selesai = :jam_selesai, mata_pelajaran = :mata_pelajaran, 
                          kelas = :kelas, semester = :semester, tahun_ajaran = :tahun_ajaran 
                      WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->bindParam(':hari', $data['hari']);
            $stmt->bindParam(':jam_mulai', $data['jam_mulai']);
            $stmt->bindParam(':jam_selesai', $data['jam_selesai']);
            $stmt->bindParam(':mata_pelajaran', $data['mata_pelajaran']);
            $stmt->bindParam(':kelas', $data['kelas']);
            $stmt->bindParam(':semester', $data['semester']);
            $stmt->bindParam(':tahun_ajaran', $data['tahun_ajaran']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating jadwal: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete jadwal mengajar
     * @param int $id
     * @return bool
     */
    public function deleteJadwal($id) {
        try {
            $query = "DELETE FROM jadwal_mengajar WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting jadwal: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get jadwal for today
     * @param string $date
     * @return array
     */
    public function getJadwalToday($date) {
        $day = date('l', strtotime($date));
        
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.hari = :day AND g.status_aktif = 1 
                  ORDER BY j.jam_mulai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':day', $day);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get jadwal count
     * @return int
     */
    public function getJadwalCount() {
        $query = "SELECT COUNT(*) as total FROM jadwal_mengajar";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    /**
     * Check time conflict
     * @param int $guru_id
     * @param string $hari
     * @param string $jam_mulai
     * @param string $jam_selesai
     * @param int $exclude_id
     * @return bool
     */
    public function checkTimeConflict($guru_id, $hari, $jam_mulai, $jam_selesai, $exclude_id = 0) {
        $query = "SELECT COUNT(*) as total 
                  FROM jadwal_mengajar 
                  WHERE guru_id = :guru_id AND hari = :hari AND id != :exclude_id 
                  AND ((jam_mulai <= :jam_mulai AND jam_selesai > :jam_mulai) 
                       OR (jam_mulai < :jam_selesai AND jam_selesai >= :jam_selesai) 
                       OR (jam_mulai >= :jam_mulai AND jam_selesai <= :jam_selesai))";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->bindParam(':hari', $hari);
        $stmt->bindParam(':jam_mulai', $jam_mulai);
        $stmt->bindParam(':jam_selesai', $jam_selesai);
        $stmt->bindParam(':exclude_id', $exclude_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }
    
    /**
     * Get current schedule for guru
     * @param int $guru_id
     * @param string $current_time
     * @return array|bool
     */
    public function getCurrentSchedule($guru_id, $current_time) {
        $day = date('l');
        
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.guru_id = :guru_id AND j.hari = :day 
                  AND j.jam_mulai <= :current_time AND j.jam_selesai >= :current_time 
                  ORDER BY j.jam_mulai 
                  LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':current_time', $current_time);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get next schedule for guru
     * @param int $guru_id
     * @param string $current_time
     * @return array|bool
     */
    public function getNextSchedule($guru_id, $current_time) {
        $day = date('l');
        
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.guru_id = :guru_id AND j.hari = :day 
                  AND j.jam_mulai > :current_time 
                  ORDER BY j.jam_mulai 
                  LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':current_time', $current_time);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get schedule by semester and tahun ajaran
     * @param string $semester
     * @param string $tahun_ajaran
     * @return array
     */
    public function getJadwalBySemester($semester, $tahun_ajaran) {
        $query = "SELECT j.*, g.nama as guru_nama 
                  FROM jadwal_mengajar j 
                  INNER JOIN guru g ON j.guru_id = g.id 
                  WHERE j.semester = :semester AND j.tahun_ajaran = :tahun_ajaran 
                  ORDER BY j.hari, j.jam_mulai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':semester', $semester);
        $stmt->bindParam(':tahun_ajaran', $tahun_ajaran);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get unique semesters
     * @return array
     */
    public function getUniqueSemesters() {
        $query = "SELECT DISTINCT semester, tahun_ajaran 
                  FROM jadwal_mengajar 
                  ORDER BY tahun_ajaran DESC, semester DESC";
        
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>