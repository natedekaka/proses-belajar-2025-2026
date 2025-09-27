<?php
class IzinController {
    private $izinModel;
    private $guruModel;
    
    public function __construct() {
        $this->izinModel = new Izin();
        $this->guruModel = new Guru();
    }
    
    public function index() {
        requireAdmin();
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $data = [
            'title' => 'Data Izin',
            'izin_list' => $this->izinModel->getAllIzin($limit, $offset),
            'total_izin' => $this->izinModel->getIzinCount(),
            'current_page' => $page,
            'total_pages' => ceil($this->izinModel->getIzinCount() / $limit)
        ];
        
        $this->loadView('admin/izin/index', $data);
    }
    
    public function add() {
        requireGuru();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processAdd();
        } else {
            $this->showAddForm();
        }
    }
    
    private function showAddForm() {
        $data = [
            'title' => 'Ajukan Izin',
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('guru/izin/add', $data);
    }
    
    private function processAdd() {
        requireGuru();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/izin/add');
        }
        
        $guru_id = $_SESSION['guru_id'];
        $tanggal_mulai = sanitizeInput($_POST['tanggal_mulai']);
        $tanggal_selesai = sanitizeInput($_POST['tanggal_selesai']);
        $jenis_izin = sanitizeInput($_POST['jenis_izin']);
        $alasan = sanitizeInput($_POST['alasan']);
        
        // Validate input
        if (empty($tanggal_mulai) || empty($tanggal_selesai) || empty($jenis_izin) || empty($alasan)) {
            $_SESSION['error'] = 'Semua field harus diisi';
            redirect('/izin/add');
        }
        
        // Validate date format
        if (!validateDateFormat($tanggal_mulai) || !validateDateFormat($tanggal_selesai)) {
            $_SESSION['error'] = 'Format tanggal tidak valid';
            redirect('/izin/add');
        }
        
        // Check if tanggal_mulai is before tanggal_selesai
        if (strtotime($tanggal_mulai) > strtotime($tanggal_selesai)) {
            $_SESSION['error'] = 'Tanggal mulai harus sebelum tanggal selesai';
            redirect('/izin/add');
        }
        
        // Check date overlap
        if ($this->izinModel->checkDateOverlap($guru_id, $tanggal_mulai, $tanggal_selesai)) {
            $_SESSION['error'] = 'Tanggal izin bentrok dengan izin lain';
            redirect('/izin/add');
        }
        
        // Handle file upload
        $file_bukti = '';
        if (isset($_FILES['file_bukti']) && $_FILES['file_bukti']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            $validation = validateFileUpload($_FILES['file_bukti'], $allowed_types, $max_size);
            
            if ($validation === true) {
                $upload_dir = PUBLIC_PATH . '/uploads/izin/';
                $filename = generateSecureFilename($_FILES['file_bukti']['name']);
                $destination = $upload_dir . $filename;
                
                if (moveUploadedFile($_FILES['file_bukti'], $destination)) {
                    $file_bukti = $filename;
                } else {
                    $_SESSION['error'] = 'Gagal mengupload file bukti';
                    redirect('/izin/add');
                }
            } else {
                $_SESSION['error'] = $validation;
                redirect('/izin/add');
            }
        }
        
        // Prepare data
        $izin_data = [
            'guru_id' => $guru_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'jenis_izin' => $jenis_izin,
            'alasan' => $alasan,
            'status_approval' => 'pending',
            'file_bukti' => $file_bukti
        ];
        
        // Create izin
        if ($this->izinModel->createIzin($izin_data)) {
            $_SESSION['success'] = 'Izin berhasil diajukan';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'add_izin', 'Mengajukan izin: ' . $jenis_izin);
            
            redirect('/izin');
        } else {
            $_SESSION['error'] = 'Gagal mengajukan izin';
            redirect('/izin/add');
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
        $izin = $this->izinModel->getIzinById($id);
        $guru_list = $this->guruModel->getAllGuru();
        
        if (!$izin) {
            $_SESSION['error'] = 'Izin tidak ditemukan';
            redirect('/izin');
        }
        
        $data = [
            'title' => 'Edit Izin',
            'izin' => $izin,
            'guru_list' => $guru_list,
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('admin/izin/edit', $data);
    }
    
    private function processEdit($id) {
        requireAdmin();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/izin/edit/' . $id);
        }
        
        $guru_id = (int)$_POST['guru_id'];
        $tanggal_mulai = sanitizeInput($_POST['tanggal_mulai']);
        $tanggal_selesai = sanitizeInput($_POST['tanggal_selesai']);
        $jenis_izin = sanitizeInput($_POST['jenis_izin']);
        $alasan = sanitizeInput($_POST['alasan']);
        $status_approval = sanitizeInput($_POST['status_approval']);
        
        // Validate input
        if (empty($guru_id) || empty($tanggal_mulai) || empty($tanggal_selesai) || 
            empty($jenis_izin) || empty($alasan) || empty($status_approval)) {
            $_SESSION['error'] = 'Semua field harus diisi';
            redirect('/izin/edit/' . $id);
        }
        
        // Validate date format
        if (!validateDateFormat($tanggal_mulai) || !validateDateFormat($tanggal_selesai)) {
            $_SESSION['error'] = 'Format tanggal tidak valid';
            redirect('/izin/edit/' . $id);
        }
        
        // Check if tanggal_mulai is before tanggal_selesai
        if (strtotime($tanggal_mulai) > strtotime($tanggal_selesai)) {
            $_SESSION['error'] = 'Tanggal mulai harus sebelum tanggal selesai';
            redirect('/izin/edit/' . $id);
        }
        
        // Handle file upload
        $file_bukti = '';
        if (isset($_FILES['file_bukti']) && $_FILES['file_bukti']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            $validation = validateFileUpload($_FILES['file_bukti'], $allowed_types, $max_size);
            
            if ($validation === true) {
                $upload_dir = PUBLIC_PATH . '/uploads/izin/';
                $filename = generateSecureFilename($_FILES['file_bukti']['name']);
                $destination = $upload_dir . $filename;
                
                if (moveUploadedFile($_FILES['file_bukti'], $destination)) {
                    $file_bukti = $filename;
                } else {
                    $_SESSION['error'] = 'Gagal mengupload file bukti';
                    redirect('/izin/edit/' . $id);
                }
            } else {
                $_SESSION['error'] = $validation;
                redirect('/izin/edit/' . $id);
            }
        }
        
        // Prepare data
        $izin_data = [
            'guru_id' => $guru_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'jenis_izin' => $jenis_izin,
            'alasan' => $alasan,
            'status_approval' => $status_approval,
            'file_bukti' => $file_bukti
        ];
        
        // Update izin
        if ($this->izinModel->updateIzin($id, $izin_data)) {
            $_SESSION['success'] = 'Izin berhasil diperbarui';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'edit_izin', 'Memperbarui izin');
            
            redirect('/izin');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui izin';
            redirect('/izin/edit/' . $id);
        }
    }
    
    public function delete($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = 'Token CSRF tidak valid';
                redirect('/izin');
            }
            
            $izin = $this->izinModel->getIzinById($id);
            
            if (!$izin) {
                $_SESSION['error'] = 'Izin tidak ditemukan';
                redirect('/izin');
            }
            
            if ($this->izinModel->deleteIzin($id)) {
                $_SESSION['success'] = 'Izin berhasil dihapus';
                
                // Log activity
                logActivity($_SESSION['user_id'], 'delete_izin', 'Menghapus izin');
            } else {
                $_SESSION['error'] = 'Gagal menghapus izin';
            }
            
            redirect('/izin');
        }
    }
    
    public function view($id) {
        requireAuth();
        
        $izin = $this->izinModel->getIzinById($id);
        
        if (!$izin) {
            $_SESSION['error'] = 'Izin tidak ditemukan';
            redirect('/izin');
        }
        
        $data = [
            'title' => 'Detail Izin',
            'izin' => $izin
        ];
        
        if (isAdmin()) {
            $this->loadView('admin/izin/view', $data);
        } elseif (isGuru()) {
            // Check if guru has permission to view this izin
            if ($izin['guru_id'] != $_SESSION['guru_id']) {
                $_SESSION['error'] = 'Anda tidak memiliki akses ke izin ini';
                redirect('/izin');
            }
            $this->loadView('guru/izin/view', $data);
        }
    }
    
    public function approve($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                sendErrorResponse('Token CSRF tidak valid');
            }
            
            $izin = $this->izinModel->getIzinById($id);
            
            if (!$izin) {
                sendErrorResponse('Izin tidak ditemukan');
            }
            
            if ($this->izinModel->updateIzinStatus($id, 'approved')) {
                // Send notification to guru
                createNotification($izin['guru_id'], 'Izin Anda telah disetujui', 'success');
                
                sendSuccessResponse(null, 'Izin berhasil disetujui');
            } else {
                sendErrorResponse('Gagal menyetujui izin');
            }
        }
    }
    
    public function reject($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                sendErrorResponse('Token CSRF tidak valid');
            }
            
            $izin = $this->izinModel->getIzinById($id);
            
            if (!$izin) {
                sendErrorResponse('Izin tidak ditemukan');
            }
            
            if ($this->izinModel->updateIzinStatus($id, 'rejected')) {
                // Send notification to guru
                createNotification($izin['guru_id'], 'Izin Anda ditolak', 'error');
                
                sendSuccessResponse(null, 'Izin berhasil ditolak');
            } else {
                sendErrorResponse('Gagal menolak izin');
            }
        }
    }
    
    public function pending() {
        requireAdmin();
        
        $izin_list = $this->izinModel->getIzinByStatus('pending');
        
        $data = [
            'title' => 'Izin Menunggu Persetujuan',
            'izin_list' => $izin_list
        ];
        
        $this->loadView('admin/izin/pending', $data);
    }
    
    public function myIzin() {
        requireGuru();
        
        $guru_id = $_SESSION['guru_id'];
        $izin_list = $this->izinModel->getIzinByGuruId($guru_id);
        
        $data = [
            'title' => 'Izin Saya',
            'izin_list' => $izin_list
        ];
        
        $this->loadView('guru/izin/index', $data);
    }
    
    public function report() {
        requireAdmin();
        
        $start_date = sanitizeInput($_GET['start_date'] ?? date('Y-m-01'));
        $end_date = sanitizeInput($_GET['end_date'] ?? date('Y-m-d'));
        
        $izin_list = $this->izinModel->getIzinByDateRange($start_date, $end_date);
        $stats = $this->izinModel->getIzinStats($start_date, $end_date);
        
        $data = [
            'title' => 'Laporan Izin',
            'izin_list' => $izin_list,
            'stats' => $stats,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
        
        $this->loadView('admin/izin/report', $data);
    }
    
    public function calendar() {
        requireAuth();
        
        $data = [
            'title' => 'Kalender Izin'
        ];
        
        if (isAdmin()) {
            $izin_list = $this->izinModel->getAllIzin();
            $data['izin_list'] = $izin_list;
            $this->loadView('admin/izin/calendar', $data);
        } elseif (isGuru()) {
            $guru_id = $_SESSION['guru_id'];
            $izin_list = $this->izinModel->getIzinByGuruId($guru_id);
            $data['izin_list'] = $izin_list;
            $this->loadView('guru/izin/calendar', $data);
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