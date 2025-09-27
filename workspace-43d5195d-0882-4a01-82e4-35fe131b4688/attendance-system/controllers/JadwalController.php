<?php
class JadwalController {
    private $jadwalModel;
    private $guruModel;
    
    public function __construct() {
        $this->jadwalModel = new JadwalMengajar();
        $this->guruModel = new Guru();
    }
    
    public function index() {
        requireAdmin();
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $data = [
            'title' => 'Data Jadwal Mengajar',
            'jadwal_list' => $this->jadwalModel->getAllJadwal($limit, $offset),
            'total_jadwal' => $this->jadwalModel->getJadwalCount(),
            'current_page' => $page,
            'total_pages' => ceil($this->jadwalModel->getJadwalCount() / $limit)
        ];
        
        $this->loadView('admin/jadwal/index', $data);
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
            'title' => 'Tambah Jadwal Mengajar',
            'guru_list' => $guru_list,
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('admin/jadwal/add', $data);
    }
    
    private function processAdd() {
        requireAdmin();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/jadwal/add');
        }
        
        $guru_id = (int)$_POST['guru_id'];
        $hari = sanitizeInput($_POST['hari']);
        $jam_mulai = sanitizeInput($_POST['jam_mulai']);
        $jam_selesai = sanitizeInput($_POST['jam_selesai']);
        $mata_pelajaran = sanitizeInput($_POST['mata_pelajaran']);
        $kelas = sanitizeInput($_POST['kelas']);
        $semester = sanitizeInput($_POST['semester']);
        $tahun_ajaran = sanitizeInput($_POST['tahun_ajaran']);
        
        // Validate input
        if (empty($guru_id) || empty($hari) || empty($jam_mulai) || empty($jam_selesai) || 
            empty($mata_pelajaran) || empty($kelas) || empty($semester) || empty($tahun_ajaran)) {
            $_SESSION['error'] = 'Semua field harus diisi';
            redirect('/jadwal/add');
        }
        
        // Validate time format
        if (!validateTimeFormat($jam_mulai) || !validateTimeFormat($jam_selesai)) {
            $_SESSION['error'] = 'Format jam tidak valid';
            redirect('/jadwal/add');
        }
        
        // Check if jam_mulai is before jam_selesai
        if (strtotime($jam_mulai) >= strtotime($jam_selesai)) {
            $_SESSION['error'] = 'Jam mulai harus sebelum jam selesai';
            redirect('/jadwal/add');
        }
        
        // Check time conflict
        if ($this->jadwalModel->checkTimeConflict($guru_id, $hari, $jam_mulai, $jam_selesai)) {
            $_SESSION['error'] = 'Jadwal bentrok dengan jadwal lain';
            redirect('/jadwal/add');
        }
        
        // Prepare data
        $jadwal_data = [
            'guru_id' => $guru_id,
            'hari' => $hari,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'mata_pelajaran' => $mata_pelajaran,
            'kelas' => $kelas,
            'semester' => $semester,
            'tahun_ajaran' => $tahun_ajaran
        ];
        
        // Create jadwal
        if ($this->jadwalModel->createJadwal($jadwal_data)) {
            $_SESSION['success'] = 'Jadwal mengajar berhasil ditambahkan';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'add_jadwal', 'Menambahkan jadwal mengajar');
            
            redirect('/jadwal');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan jadwal mengajar';
            redirect('/jadwal/add');
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
        $jadwal = $this->jadwalModel->getJadwalById($id);
        $guru_list = $this->guruModel->getAllGuru();
        
        if (!$jadwal) {
            $_SESSION['error'] = 'Jadwal tidak ditemukan';
            redirect('/jadwal');
        }
        
        $data = [
            'title' => 'Edit Jadwal Mengajar',
            'jadwal' => $jadwal,
            'guru_list' => $guru_list,
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('admin/jadwal/edit', $data);
    }
    
    private function processEdit($id) {
        requireAdmin();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/jadwal/edit/' . $id);
        }
        
        $guru_id = (int)$_POST['guru_id'];
        $hari = sanitizeInput($_POST['hari']);
        $jam_mulai = sanitizeInput($_POST['jam_mulai']);
        $jam_selesai = sanitizeInput($_POST['jam_selesai']);
        $mata_pelajaran = sanitizeInput($_POST['mata_pelajaran']);
        $kelas = sanitizeInput($_POST['kelas']);
        $semester = sanitizeInput($_POST['semester']);
        $tahun_ajaran = sanitizeInput($_POST['tahun_ajaran']);
        
        // Validate input
        if (empty($guru_id) || empty($hari) || empty($jam_mulai) || empty($jam_selesai) || 
            empty($mata_pelajaran) || empty($kelas) || empty($semester) || empty($tahun_ajaran)) {
            $_SESSION['error'] = 'Semua field harus diisi';
            redirect('/jadwal/edit/' . $id);
        }
        
        // Validate time format
        if (!validateTimeFormat($jam_mulai) || !validateTimeFormat($jam_selesai)) {
            $_SESSION['error'] = 'Format jam tidak valid';
            redirect('/jadwal/edit/' . $id);
        }
        
        // Check if jam_mulai is before jam_selesai
        if (strtotime($jam_mulai) >= strtotime($jam_selesai)) {
            $_SESSION['error'] = 'Jam mulai harus sebelum jam selesai';
            redirect('/jadwal/edit/' . $id);
        }
        
        // Check time conflict (excluding current jadwal)
        if ($this->jadwalModel->checkTimeConflict($guru_id, $hari, $jam_mulai, $jam_selesai, $id)) {
            $_SESSION['error'] = 'Jadwal bentrok dengan jadwal lain';
            redirect('/jadwal/edit/' . $id);
        }
        
        // Prepare data
        $jadwal_data = [
            'guru_id' => $guru_id,
            'hari' => $hari,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'mata_pelajaran' => $mata_pelajaran,
            'kelas' => $kelas,
            'semester' => $semester,
            'tahun_ajaran' => $tahun_ajaran
        ];
        
        // Update jadwal
        if ($this->jadwalModel->updateJadwal($id, $jadwal_data)) {
            $_SESSION['success'] = 'Jadwal mengajar berhasil diperbarui';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'edit_jadwal', 'Memperbarui jadwal mengajar');
            
            redirect('/jadwal');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui jadwal mengajar';
            redirect('/jadwal/edit/' . $id);
        }
    }
    
    public function delete($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = 'Token CSRF tidak valid';
                redirect('/jadwal');
            }
            
            $jadwal = $this->jadwalModel->getJadwalById($id);
            
            if (!$jadwal) {
                $_SESSION['error'] = 'Jadwal tidak ditemukan';
                redirect('/jadwal');
            }
            
            if ($this->jadwalModel->deleteJadwal($id)) {
                $_SESSION['success'] = 'Jadwal mengajar berhasil dihapus';
                
                // Log activity
                logActivity($_SESSION['user_id'], 'delete_jadwal', 'Menghapus jadwal mengajar');
            } else {
                $_SESSION['error'] = 'Gagal menghapus jadwal mengajar';
            }
            
            redirect('/jadwal');
        }
    }
    
    public function view($id) {
        requireAdmin();
        
        $jadwal = $this->jadwalModel->getJadwalById($id);
        
        if (!$jadwal) {
            $_SESSION['error'] = 'Jadwal tidak ditemukan';
            redirect('/jadwal');
        }
        
        $data = [
            'title' => 'Detail Jadwal Mengajar',
            'jadwal' => $jadwal
        ];
        
        $this->loadView('admin/jadwal/view', $data);
    }
    
    public function calendar() {
        requireAuth();
        
        $data = [
            'title' => 'Kalender Jadwal'
        ];
        
        if (isAdmin()) {
            $jadwal_list = $this->jadwalModel->getAllJadwal();
            $data['jadwal_list'] = $jadwal_list;
            $this->loadView('admin/jadwal/calendar', $data);
        } elseif (isGuru()) {
            $guru_id = $_SESSION['guru_id'];
            $jadwal_list = $this->jadwalModel->getJadwalByGuruId($guru_id);
            $data['jadwal_list'] = $jadwal_list;
            $this->loadView('guru/jadwal/calendar', $data);
        }
    }
    
    public function today() {
        requireAuth();
        
        $today = date('Y-m-d');
        $jadwal_list = $this->jadwalModel->getJadwalToday($today);
        
        $data = [
            'title' => 'Jadwal Hari Ini',
            'jadwal_list' => $jadwal_list,
            'today' => $today
        ];
        
        if (isAdmin()) {
            $this->loadView('admin/jadwal/today', $data);
        } elseif (isGuru()) {
            $guru_id = $_SESSION['guru_id'];
            $jadwal_list = array_filter($jadwal_list, function($jadwal) use ($guru_id) {
                return $jadwal['guru_id'] == $guru_id;
            });
            $data['jadwal_list'] = $jadwal_list;
            $this->loadView('guru/jadwal/today', $data);
        }
    }
    
    public function dragDrop() {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                sendErrorResponse('Token CSRF tidak valid');
            }
            
            $jadwal_id = (int)$_POST['jadwal_id'];
            $guru_id = (int)$_POST['guru_id'];
            $hari = sanitizeInput($_POST['hari']);
            $jam_mulai = sanitizeInput($_POST['jam_mulai']);
            $jam_selesai = sanitizeInput($_POST['jam_selesai']);
            
            // Validate input
            if (empty($jadwal_id) || empty($guru_id) || empty($hari) || empty($jam_mulai) || empty($jam_selesai)) {
                sendErrorResponse('Semua field harus diisi');
            }
            
            // Check time conflict
            if ($this->jadwalModel->checkTimeConflict($guru_id, $hari, $jam_mulai, $jam_selesai, $jadwal_id)) {
                sendErrorResponse('Jadwal bentrok dengan jadwal lain');
            }
            
            // Prepare data
            $jadwal_data = [
                'guru_id' => $guru_id,
                'hari' => $hari,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai
            ];
            
            // Update jadwal
            if ($this->jadwalModel->updateJadwal($jadwal_id, $jadwal_data)) {
                sendSuccessResponse(null, 'Jadwal berhasil diperbarui');
            } else {
                sendErrorResponse('Gagal memperbarui jadwal');
            }
        }
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