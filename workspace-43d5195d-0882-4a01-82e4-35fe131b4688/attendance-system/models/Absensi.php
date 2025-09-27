<?php
class Absensi {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Get all absensi
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllAbsensi($limit = 10, $offset = 0) {
        $query = "SELECT a.*, g.nama as guru_nama, j.mata_pelajaran, j.kelas, j.hari
                  FROM absensi a 
                  INNER JOIN guru g ON a.guru_id = g.id 
                  INNER JOIN jadwal_mengajar j ON a.jadwal_id = j.id 
                  ORDER BY a.tanggal DESC, a.waktu_masuk DESC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get absensi by ID
     * @param int $id
     * @return array|bool
     */
    public function getAbsensiById($id) {
        $query = "SELECT a.*, g.nama as guru_nama, j.mata_pelajaran, j.kelas, j.hari
                  FROM absensi a 
                  INNER JOIN guru g ON a.guru_id = g.id 
                  INNER JOIN jadwal_mengajar j ON a.jadwal_id = j.id 
                  WHERE a.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get absensi by guru ID
     * @param int $guru_id
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getAbsensiByGuruId($guru_id, $start_date = null, $end_date = null) {
        $query = "SELECT a.*, j.mata_pelajaran, j.kelas, j.hari, j.jam_mulai, j.jam_selesai
                  FROM absensi a 
                  INNER JOIN jadwal_mengajar j ON a.jadwal_id = j.id 
                  WHERE a.guru_id = :guru_id";
        
        if ($start_date && $end_date) {
            $query .= " AND a.tanggal BETWEEN :start_date AND :end_date";
        }
        
        $query .= " ORDER BY a.tanggal DESC, a.waktu_masuk DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        
        if ($start_date && $end_date) {
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get absensi by date
     * @param string $date
     * @return array
     */
    public function getAbsensiByDate($date) {
        $query = "SELECT a.*, g.nama as guru_nama, j.mata_pelajaran, j.kelas, j.hari
                  FROM absensi a 
                  INNER JOIN guru g ON a.guru_id = g.id 
                  INNER JOIN jadwal_mengajar j ON a.jadwal_id = j.id 
                  WHERE a.tanggal = :date 
                  ORDER BY a.waktu_masuk";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get absensi by date range
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getAbsensiByDateRange($start_date, $end_date) {
        $query = "SELECT a.*, g.nama as guru_nama, j.mata_pelajaran, j.kelas, j.hari
                  FROM absensi a 
                  INNER JOIN guru g ON a.guru_id = g.id 
                  INNER JOIN jadwal_mengajar j ON a.jadwal_id = j.id 
                  WHERE a.tanggal BETWEEN :start_date AND :end_date 
                  ORDER BY a.tanggal DESC, a.waktu_masuk DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create new absensi
     * @param array $data
     * @return bool
     */
    public function createAbsensi($data) {
        try {
            $query = "INSERT INTO absensi 
                      (guru_id, jadwal_id, tanggal, waktu_masuk, waktu_keluar, status_kehadiran, keterangan, dibuat_oleh, metode_absen) 
                      VALUES 
                      (:guru_id, :jadwal_id, :tanggal, :waktu_masuk, :waktu_keluar, :status_kehadiran, :keterangan, :dibuat_oleh, :metode_absen)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->bindParam(':jadwal_id', $data['jadwal_id'], PDO::PARAM_INT);
            $stmt->bindParam(':tanggal', $data['tanggal']);
            $stmt->bindParam(':waktu_masuk', $data['waktu_masai']);
            $stmt->bindParam(':waktu_keluar', $data['waktu_keluar']);
            $stmt->bindParam(':status_kehadiran', $data['status_kehadiran']);
            $stmt->bindParam(':keterangan', $data['keterangan']);
            $stmt->bindParam(':dibuat_oleh', $data['dibuat_oleh'], PDO::PARAM_INT);
            $stmt->bindParam(':metode_absen', $data['metode_absen']);
            $stmt->execute();
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating absensi: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update absensi
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateAbsensi($id, $data) {
        try {
            $query = "UPDATE absensi 
                      SET guru_id = :guru_id, jadwal_id = :jadwal_id, tanggal = :tanggal, 
                          waktu_masuk = :waktu_masuk, waktu_keluar = :waktu_keluar, 
                          status_kehadiran = :status_kehadiran, keterangan = :keterangan, 
                          dibuat_oleh = :dibuat_oleh, metode_absen = :metode_absen 
                      WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':guru_id', $data['guru_id'], PDO::PARAM_INT);
            $stmt->bindParam(':jadwal_id', $data['jadwal_id'], PDO::PARAM_INT);
            $stmt->bindParam(':tanggal', $data['tanggal']);
            $stmt->bindParam(':waktu_masuk', $data['waktu_masai']);
            $stmt->bindParam(':waktu_keluar', $data['waktu_keluar']);
            $stmt->bindParam(':status_kehadiran', $data['status_kehadiran']);
            $stmt->bindParam(':keterangan', $data['keterangan']);
            $stmt->bindParam(':dibuat_oleh', $data['dibuat_oleh'], PDO::PARAM_INT);
            $stmt->bindParam(':metode_absen', $data['metode_absen']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating absensi: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete absensi
     * @param int $id
     * @return bool
     */
    public function deleteAbsensi($id) {
        try {
            $query = "DELETE FROM absensi WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting absensi: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if absensi already exists for today
     * @param int $guru_id
     * @param int $jadwal_id
     * @param string $tanggal
     * @return bool
     */
    public function checkAbsensiExists($guru_id, $jadwal_id, $tanggal) {
        $query = "SELECT COUNT(*) as total 
                  FROM absensi 
                  WHERE guru_id = :guru_id AND jadwal_id = :jadwal_id AND tanggal = :tanggal";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':guru_id', $guru_id, PDO::PARAM_INT);
        $stmt->bindParam(':jadwal_id', $jadwal_id, PDO::PARAM_INT);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }
    
    /**
     * Get absensi count
     * @return int
     */
    public function getAbsensiCount() {
        $query = "SELECT COUNT(*) as total FROM absensi";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    /**
     * Get absensi statistics
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getAbsensiStats($start_date, $end_date) {
        $query = "SELECT 
                    status_kehadiran,
                    COUNT(*) as total
                  FROM absensi 
                  WHERE tanggal BETWEEN :start_date AND :end_date
                  GROUP BY status_kehadiran";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get guru who haven't attended today
     * @param string $date
     * @return array
     */
    public function getGuruNotAttended($date) {
        $day = date('l', strtotime($date));
        
        $query = "SELECT DISTINCT g.id, g.nama, g.nip, j.id as jadwal_id, j.mata_pelajaran, j.kelas, j.jam_mulai
                  FROM guru g
                  INNER JOIN jadwal_mengajar j ON g.id = j.guru_id
                  WHERE g.status_aktif = 1 AND j.hari = :hari
                  AND g.id NOT IN (
                      SELECT DISTINCT a.guru_id 
                      FROM absensi a 
                      WHERE a.tanggal = :tanggal
                  )
                  ORDER BY g.nama";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hari', $day);
        $stmt->bindParam(':tanggal', $date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get monthly attendance report
     * @param string $year
     * @param string $month
     * @return array
     */
    public function getMonthlyReport($year, $month) {
        $query = "SELECT 
                    g.id,
                    g.nama,
                    g.nip,
                    COUNT(a.id) as total_hari,
                    SUM(CASE WHEN a.status_kehadiran = 'hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN a.status_kehadiran = 'terlambat' THEN 1 ELSE 0 END) as terlambat,
                    SUM(CASE WHEN a.status_kehadiran = 'tidak_hadir' THEN 1 ELSE 0 END) as tidak_hadir,
                    SUM(CASE WHEN a.status_kehadiran = 'izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN a.status_kehadiran = 'sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN a.status_kehadiran = 'cuti' THEN 1 ELSE 0 END) as cuti
                  FROM guru g
                  LEFT JOIN absensi a ON g.id = a.guru_id 
                    AND MONTH(a.tanggal) = :month AND YEAR(a.tanggal) = :year
                  WHERE g.status_aktif = 1
                  GROUP BY g.id, g.nama, g.nip
                  ORDER BY g.nama";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get daily attendance summary
     * @param string $date
     * @return array
     */
    public function getDailySummary($date) {
        $query = "SELECT 
                    status_kehadiran,
                    COUNT(*) as total
                  FROM absensi 
                  WHERE tanggal = :date
                  GROUP BY status_kehadiran";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        
        $stats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stats[$row['status_kehadiran']] = $row['total'];
        }
        
        return $stats;
    }
    
    /**
     * Auto mark absence for teachers who didn't attend
     * @param string $date
     * @return int
     */
    public function autoMarkAbsence($date) {
        $day = date('l', strtotime($date));
        
        // Get teachers with schedule today who haven't attended
        $query = "SELECT DISTINCT g.id, j.id as jadwal_id
                  FROM guru g
                  INNER JOIN jadwal_mengajar j ON g.id = j.guru_id
                  WHERE g.status_aktif = 1 AND j.hari = :hari
                  AND g.id NOT IN (
                      SELECT DISTINCT a.guru_id 
                      FROM absensi a 
                      WHERE a.tanggal = :tanggal
                  )";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hari', $day);
        $stmt->bindParam(':tanggal', $date);
        $stmt->execute();
        
        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $marked = 0;
        
        foreach ($teachers as $teacher) {
            try {
                $query = "INSERT INTO absensi 
                          (guru_id, jadwal_id, tanggal, waktu_masuk, waktu_keluar, status_kehadiran, keterangan, dibuat_oleh, metode_absen) 
                          VALUES 
                          (:guru_id, :jadwal_id, :tanggal, '00:00:00', '00:00:00', 'tidak_hadir', 'Tidak hadir', 1, 'otomatis')";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':guru_id', $teacher['id'], PDO::PARAM_INT);
                $stmt->bindParam(':jadwal_id', $teacher['jadwal_id'], PDO::PARAM_INT);
                $stmt->bindParam(':tanggal', $date);
                $stmt->execute();
                
                $marked++;
            } catch (PDOException $e) {
                error_log("Error auto marking absence for teacher {$teacher['id']}: " . $e->getMessage());
            }
        }
        
        return $marked;
    }
    
    /**
     * Get attendance by status
     * @param string $status
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getAbsensiByStatus($status, $start_date, $end_date) {
        $query = "SELECT a.*, g.nama as guru_nama, j.mata_pelajaran, j.kelas, j.hari
                  FROM absensi a 
                  INNER JOIN guru g ON a.guru_id = g.id 
                  INNER JOIN jadwal_mengajar j ON a.jadwal_id = j.id 
                  WHERE a.status_kehadiran = :status 
                  AND a.tanggal BETWEEN :start_date AND :end_date 
                  ORDER BY a.tanggal DESC, a.waktu_masuk DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>