<?php
class AbsensiController {
    private $absensiModel;
    private $guruModel;
    private $jadwalModel;
    
    public function __construct() {
        $this->absensiModel = new Absensi();
        $this->guruModel = new Guru();
        $this->jadwalModel = new JadwalMengajar();
    }
    
    public function index() {
        requireAdmin();
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $data = [
            'title' => 'Data Absensi',
            'absensi_list' => $this->absensiModel->getAllAbsensi($limit, $offset),
            'total_absensi' => $this->absensiModel->getAbsensiCount(),
            'current_page' => $page,
            'total_pages' => ceil($this->absensiModel->getAbsensiCount() / $limit)
        ];
        
        $this->loadView('admin/absensi/index', $data);
    }
    
    public function add() {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processAdd();
        } else {
            $this->showAddForm();
        }
    }
    
    private function showAddForm() {
        $guru_list = $this->guruModel->getAllGuru();
        
        $data = [
            'title' => 'Tambah Absensi',
            'guru_list' => $guru_list,
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('admin/absensi/add', $data);
    }
    
    private function processAdd() {
        requireAdmin();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/absensi/add');
        }
        
        $guru_id = (int)$_POST['guru_id'];
        $jadwal_id = (int)$_POST['jadwal_id'];
        $tanggal = sanitizeInput($_POST['tanggal']);
        $waktu_masuk = sanitizeInput($_POST['waktu_masuk']);
        $waktu_keluar = sanitizeInput($_POST['waktu_keluar']);
        $status_kehadiran = sanitizeInput($_POST['status_kehadiran']);
        $keterangan = sanitizeInput($_POST['keterangan']);
        $metode_absen = sanitizeInput($_POST['metode_absen']);
        
        // Validate input
        if (empty($guru_id) || empty($jadwal_id) || empty($tanggal) || empty($status_kehadiran)) {
            $_SESSION['error'] = 'Field wajib harus diisi';
            redirect('/absensi/add');
        }
        
        // Validate date format
        if (!validateDateFormat($tanggal)) {
            $_SESSION['error'] = 'Format tanggal tidak valid';
            redirect('/absensi/add');
        }
        
        // Validate time format
        if (!empty($waktu_masuk) && !validateTimeFormat($waktu_masuk)) {
            $_SESSION['error'] = 'Format waktu masuk tidak valid';
            redirect('/absensi/add');
        }
        
        if (!empty($waktu_keluar) && !validateTimeFormat($waktu_keluar)) {
            $_SESSION['error'] = 'Format waktu keluar tidak valid';
            redirect('/absensi/add');
        }
        
        // Check if absensi already exists
        if ($this->absensiModel->checkAbsensiExists($guru_id, $jadwal_id, $tanggal)) {
            $_SESSION['error'] = 'Absensi untuk guru ini pada tanggal tersebut sudah ada';
            redirect('/absensi/add');
        }
        
        // Prepare data
        $absensi_data = [
            'guru_id' => $guru_id,
            'jadwal_id' => $jadwal_id,
            'tanggal' => $tanggal,
            'waktu_masai' => $waktu_masuk,
            'waktu_keluar' => $waktu_keluar,
            'status_kehadiran' => $status_kehadiran,
            'keterangan' => $keterangan,
            'dibuat_oleh' => $_SESSION['user_id'],
            'metode_absen' => $metode_absen
        ];
        
        // Create absensi
        if ($this->absensiModel->createAbsensi($absensi_data)) {
            $_SESSION['success'] = 'Absensi berhasil ditambahkan';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'add_absensi', 'Menambahkan absensi');
            
            redirect('/absensi');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan absensi';
            redirect('/absensi/add');
        }
    }
    
    public function edit($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processEdit($id);
        } else {
            $this->showEditForm($id);
        }
    }
    
    private function showEditForm($id) {
        $absensi = $this->absensiModel->getAbsensiById($id);
        $guru_list = $this->guruModel->getAllGuru();
        
        if (!$absensi) {
            $_SESSION['error'] = 'Absensi tidak ditemukan';
            redirect('/absensi');
        }
        
        $data = [
            'title' => 'Edit Absensi',
            'absensi' => $absensi,
            'guru_list' => $guru_list,
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('admin/absensi/edit', $data);
    }
    
    private function processEdit($id) {
        requireAdmin();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/absensi/edit/' . $id);
        }
        
        $guru_id = (int)$_POST['guru_id'];
        $jadwal_id = (int)$_POST['jadwal_id'];
        $tanggal = sanitizeInput($_POST['tanggal']);
        $waktu_masuk = sanitizeInput($_POST['waktu_masuk']);
        $waktu_keluar = sanitizeInput($_POST['waktu_keluar']);
        $status_kehadiran = sanitizeInput($_POST['status_kehadiran']);
        $keterangan = sanitizeInput($_POST['keterangan']);
        $metode_absen = sanitizeInput($_POST['metode_absen']);
        
        // Validate input
        if (empty($guru_id) || empty($jadwal_id) || empty($tanggal) || empty($status_kehadiran)) {
            $_SESSION['error'] = 'Field wajib harus diisi';
            redirect('/absensi/edit/' . $id);
        }
        
        // Validate date format
        if (!validateDateFormat($tanggal)) {
            $_SESSION['error'] = 'Format tanggal tidak valid';
            redirect('/absensi/edit/' . $id);
        }
        
        // Validate time format
        if (!empty($waktu_masuk) && !validateTimeFormat($waktu_masuk)) {
            $_SESSION['error'] = 'Format waktu masuk tidak valid';
            redirect('/absensi/edit/' . $id);
        }
        
        if (!empty($waktu_keluar) && !validateTimeFormat($waktu_keluar)) {
            $_SESSION['error'] = 'Format waktu keluar tidak valid';
            redirect('/absensi/edit/' . $id);
        }
        
        // Prepare data
        $absensi_data = [
            'guru_id' => $guru_id,
            'jadwal_id' => $jadwal_id,
            'tanggal' => $tanggal,
            'waktu_masai' => $waktu_masuk,
            'waktu_keluar' => $waktu_keluar,
            'status_kehadiran' => $status_kehadiran,
            'keterangan' => $keterangan,
            'dibuat_oleh' => $_SESSION['user_id'],
            'metode_absen' => $metode_absen
        ];
        
        // Update absensi
        if ($this->absensiModel->updateAbsensi($id, $absensi_data)) {
            $_SESSION['success'] = 'Absensi berhasil diperbarui';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'edit_absensi', 'Memperbarui absensi');
            
            redirect('/absensi');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui absensi';
            redirect('/absensi/edit/' . $id);
        }
    }
    
    public function delete($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = 'Token CSRF tidak valid';
                redirect('/absensi');
            }
            
            $absensi = $this->absensiModel->getAbsensiById($id);
            
            if (!$absensi) {
                $_SESSION['error'] = 'Absensi tidak ditemukan';
                redirect('/absensi');
            }
            
            if ($this->absensiModel->deleteAbsensi($id)) {
                $_SESSION['success'] = 'Absensi berhasil dihapus';
                
                // Log activity
                logActivity($_SESSION['user_id'], 'delete_absensi', 'Menghapus absensi');
            } else {
                $_SESSION['error'] = 'Gagal menghapus absensi';
            }
            
            redirect('/absensi');
        }
    }
    
    public function view($id) {
        requireAdmin();
        
        $absensi = $this->absensiModel->getAbsensiById($id);
        
        if (!$absensi) {
            $_SESSION['error'] = 'Absensi tidak ditemukan';
            redirect('/absensi');
        }
        
        $data = [
            'title' => 'Detail Absensi',
            'absensi' => $absensi
        ];
        
        $this->loadView('admin/absensi/view', $data);
    }
    
    public function today() {
        requireAdmin();
        
        $today = date('Y-m-d');
        $absensi_list = $this->absensiModel->getAbsensiByDate($today);
        
        $data = [
            'title' => 'Absensi Hari Ini',
            'absensi_list' => $absensi_list,
            'today' => $today
        ];
        
        $this->loadView('admin/absensi/today', $data);
    }
    
    public function report() {
        requireAdmin();
        
        $start_date = sanitizeInput($_GET['start_date'] ?? date('Y-m-01'));
        $end_date = sanitizeInput($_GET['end_date'] ?? date('Y-m-d'));
        
        $absensi_list = $this->absensiModel->getAbsensiByDateRange($start_date, $end_date);
        $stats = $this->absensiModel->getAbsensiStats($start_date, $end_date);
        
        $data = [
            'title' => 'Laporan Absensi',
            'absensi_list' => $absensi_list,
            'stats' => $stats,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
        
        $this->loadView('admin/absensi/report', $data);
    }
    
    public function export() {
        requireAdmin();
        
        $format = sanitizeInput($_GET['format'] ?? 'excel');
        $start_date = sanitizeInput($_GET['start_date'] ?? date('Y-m-01'));
        $end_date = sanitizeInput($_GET['end_date'] ?? date('Y-m-d'));
        
        $absensi_list = $this->absensiModel->getAbsensiByDateRange($start_date, $end_date);
        
        if ($format === 'excel') {
            $this->exportToExcel($absensi_list, $start_date, $end_date);
        } elseif ($format === 'pdf') {
            $this->exportToPDF($absensi_list, $start_date, $end_date);
        } else {
            $_SESSION['error'] = 'Format export tidak valid';
            redirect('/absensi/report');
        }
    }
    
    private function exportToExcel($absensi_list, $start_date, $end_date) {
        // Create Excel file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="absensi_' . $start_date . '_to_' . $end_date . '.xls"');
        
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Nama Guru</th>';
        echo '<th>NIP</th>';
        echo '<th>Mata Pelajaran</th>';
        echo '<th>Kelas</th>';
        echo '<th>Tanggal</th>';
        echo '<th>Waktu Masuk</th>';
        echo '<th>Waktu Keluar</th>';
        echo '<th>Status Kehadiran</th>';
        echo '<th>Keterangan</th>';
        echo '<th>Metode Absen</th>';
        echo '</tr>';
        
        $no = 1;
        foreach ($absensi_list as $absensi) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $absensi['guru_nama'] . '</td>';
            echo '<td>' . $absensi['nip'] . '</td>';
            echo '<td>' . $absensi['mata_pelajaran'] . '</td>';
            echo '<td>' . $absensi['kelas'] . '</td>';
            echo '<td>' . formatTanggalIndo($absensi['tanggal']) . '</td>';
            echo '<td>' . formatJamIndo($absensi['waktu_masuk']) . '</td>';
            echo '<td>' . formatJamIndo($absensi['waktu_keluar']) . '</td>';
            echo '<td>' . getStatusKehadiran($absensi['status_kehadiran']) . '</td>';
            echo '<td>' . $absensi['keterangan'] . '</td>';
            echo '<td>' . ucfirst($absensi['metode_absen']) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        exit;
    }
    
    private function exportToPDF($absensi_list, $start_date, $end_date) {
        // This is a placeholder for PDF export
        // In a real application, you would use a library like TCPDF or mPDF
        $_SESSION['error'] = 'Export PDF belum diimplementasikan';
        redirect('/absensi/report');
    }
    
    public function autoMark() {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                sendErrorResponse('Token CSRF tidak valid');
            }
            
            $tanggal = sanitizeInput($_POST['tanggal'] ?? date('Y-m-d'));
            
            $marked = $this->absensiModel->autoMarkAbsence($tanggal);
            
            if ($marked > 0) {
                sendSuccessResponse(['marked' => $marked], 'Berhasil menandai ' . $marked . ' guru sebagai tidak hadir');
            } else {
                sendSuccessResponse(['marked' => 0], 'Tidak ada guru yang perlu ditandai sebagai tidak hadir');
            }
        }
    }
    
    public function checkIn() {
        requireGuru();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                sendErrorResponse('Token CSRF tidak valid');
            }
            
            $guru_id = $_SESSION['guru_id'];
            $jadwal_id = (int)$_POST['jadwal_id'];
            $tanggal = date('Y-m-d');
            $waktu_masuk = date('H:i:s');
            
            // Get jadwal info
            $jadwal = $this->jadwalModel->getJadwalById($jadwal_id);
            
            if (!$jadwal || $jadwal['guru_id'] != $guru_id) {
                sendErrorResponse('Jadwal tidak valid');
            }
            
            // Check if already checked in
            if ($this->absensiModel->checkAbsensiExists($guru_id, $jadwal_id, $tanggal)) {
                sendErrorResponse('Anda sudah melakukan absensi untuk jadwal ini');
            }
            
            // Determine status
            $status_kehadiran = 'hadir';
            $keterangan = '';
            
            // Check if late
            if (strtotime($waktu_masuk) > strtotime($jadwal['jam_mulai'])) {
                $status_kehadiran = 'terlambat';
                $late_minutes = hitungKeterlambatan($jadwal['jam_mulai'], $waktu_masuk);
                $keterangan = 'Terlambat ' . $late_minutes . ' menit';
            }
            
            // Prepare data
            $absensi_data = [
                'guru_id' => $guru_id,
                'jadwal_id' => $jadwal_id,
                'tanggal' => $tanggal,
                'waktu_masai' => $waktu_masuk,
                'waktu_keluar' => '',
                'status_kehadiran' => $status_kehadiran,
                'keterangan' => $keterangan,
                'dibuat_oleh' => $_SESSION['user_id'],
                'metode_absen' => 'mandiri'
            ];
            
            // Create absensi
            if ($this->absensiModel->createAbsensi($absensi_data)) {
                sendSuccessResponse(null, 'Absensi berhasil');
            } else {
                sendErrorResponse('Gagal melakukan absensi');
            }
        }
    }
    
    public function checkOut() {
        requireGuru();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                sendErrorResponse('Token CSRF tidak valid');
            }
            
            $guru_id = $_SESSION['guru_id'];
            $jadwal_id = (int)$_POST['jadwal_id'];
            $tanggal = date('Y-m-d');
            $waktu_keluar = date('H:i:s');
            
            // Get existing absensi
            $absensi = $this->absensiModel->getAbsensiByGuruId($guru_id, $tanggal, $tanggal);
            
            $found = false;
            foreach ($absensi as $a) {
                if ($a['jadwal_id'] == $jadwal_id) {
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                sendErrorResponse('Anda belum melakukan check in');
            }
            
            // Update absensi
            $absensi_data = [
                'waktu_keluar' => $waktu_keluar
            ];
            
            if ($this->absensiModel->updateAbsensi($a['id'], $absensi_data)) {
                sendSuccessResponse(null, 'Check out berhasil');
            } else {
                sendErrorResponse('Gagal melakukan check out');
            }
        }
    }
    
    public function qrCheckIn() {
        requireGuru();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                sendErrorResponse('Token CSRF tidak valid');
            }
            
            $qr_data = sanitizeInput($_POST['qr_data']);
            
            // Validate QR data
            $qr_info = validateQRData($qr_data);
            
            if (!$qr_info) {
                sendErrorResponse('QR code tidak valid');
            }
            
            $guru_id = $_SESSION['guru_id'];
            $jadwal_id = $qr_info['jadwal_id'];
            $tanggal = date('Y-m-d');
            $waktu_masuk = date('H:i:s');
            
            // Get jadwal info
            $jadwal = $this->jadwalModel->getJadwalById($jadwal_id);
            
            if (!$jadwal || $jadwal['guru_id'] != $guru_id) {
                sendErrorResponse('Jadwal tidak valid');
            }
            
            // Check if already checked in
            if ($this->absensiModel->checkAbsensiExists($guru_id, $jadwal_id, $tanggal)) {
                sendErrorResponse('Anda sudah melakukan absensi untuk jadwal ini');
            }
            
            // Determine status
            $status_kehadiran = 'hadir';
            $keterangan = '';
            
            // Check if late
            if (strtotime($waktu_masuk) > strtotime($jadwal['jam_mulai'])) {
                $status_kehadiran = 'terlambat';
                $late_minutes = hitungKeterlambatan($jadwal['jam_mulai'], $waktu_masuk);
                $keterangan = 'Terlambat ' . $late_minutes . ' menit';
            }
            
            // Prepare data
            $absensi_data = [
                'guru_id' => $guru_id,
                'jadwal_id' => $jadwal_id,
                'tanggal' => $tanggal,
                'waktu_masai' => $waktu_masuk,
                'waktu_keluar' => '',
                'status_kehadiran' => $status_kehadiran,
                'keterangan' => $keterangan,
                'dibuat_oleh' => $_SESSION['user_id'],
                'metode_absen' => 'qr_code'
            ];
            
            // Create absensi
            if ($this->absensiModel->createAbsensi($absensi_data)) {
                sendSuccessResponse(null, 'Absensi QR code berhasil');
            } else {
                sendErrorResponse('Gagal melakukan absensi QR code');
            }
        }
    }
    
    public function history() {
        requireGuru();
        
        $guru_id = $_SESSION['guru_id'];
        $start_date = sanitizeInput($_GET['start_date'] ?? date('Y-m-01'));
        $end_date = sanitizeInput($_GET['end_date'] ?? date('Y-m-d'));
        
        $absensi_list = $this->absensiModel->getAbsensiByGuruId($guru_id, $start_date, $end_date);
        
        $data = [
            'title' => 'Riwayat Absensi',
            'absensi_list' => $absensi_list,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
        
        $this->loadView('guru/absensi/history', $data);
    }
    
    private function loadView($view, $data = []) {
        // Extract data to make variables available in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Load view file
        $view_file = VIEW_PATH . '/' . $view . '.php';
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            include VIEW_PATH . '/error/404.php';
        }
        
        // Get the buffered content
        $content = ob_get_clean();
        
        // Load layout
        include VIEW_PATH . '/layout.php';
    }
}
?>