<?php
class HomeController {
    private $guruModel;
    private $jadwalModel;
    private $absensiModel;
    private $izinModel;
    
    public function __construct() {
        $this->guruModel = new Guru();
        $this->jadwalModel = new JadwalMengajar();
        $this->absensiModel = new Absensi();
        $this->izinModel = new Izin();
    }
    
    public function index() {
        requireAuth();
        
        $data = [];
        
        if (isAdmin()) {
            // Admin dashboard
            $data['total_guru'] = $this->guruModel->getGuruCount();
            $data['total_jadwal'] = $this->jadwalModel->getJadwalCount();
            $data['total_absensi'] = $this->absensiModel->getAbsensiCount();
            $data['pending_izin'] = $this->izinModel->getPendingIzinCount();
            
            // Get today's schedule
            $today = date('Y-m-d');
            $data['jadwal_hari_ini'] = $this->jadwalModel->getJadwalToday($today);
            
            // Get today's attendance summary
            $data['ringkasan_absensi'] = $this->absensiModel->getDailySummary($today);
            
            // Get teachers who haven't attended
            $data['guru_belum_absen'] = $this->absensiModel->getGuruNotAttended($today);
            
            // Get recent absensi
            $data['absensi_terbaru'] = $this->absensiModel->getAllAbsensi(5, 0);
            
            // Get pending izin
            $data['izin_pending'] = $this->izinModel->getIzinByStatus('pending');
            
            // Load admin dashboard view
            $this->loadView('admin/dashboard', $data);
        } elseif (isGuru()) {
            // Guru dashboard
            $guru_id = $_SESSION['guru_id'];
            
            // Get guru info
            $data['guru'] = $this->guruModel->getGuruById($guru_id);
            
            // Get today's schedule
            $today = date('Y-m-d');
            $current_time = date('H:i:s');
            
            $data['jadwal_hari_ini'] = $this->jadwalModel->getJadwalByGuruId($guru_id);
            
            // Filter today's schedule
            $data['jadwal_hari_ini'] = array_filter($data['jadwal_hari_ini'], function($jadwal) use ($today) {
                $day = date('l', strtotime($today));
                return $jadwal['hari'] == $day;
            });
            
            // Get current schedule
            $data['jadwal_sekarang'] = $this->jadwalModel->getCurrentSchedule($guru_id, $current_time);
            
            // Get next schedule
            $data['jadwal_selanjutnya'] = $this->jadwalModel->getNextSchedule($guru_id, $current_time);
            
            // Get recent absensi
            $data['absensi_terbaru'] = $this->absensiModel->getAbsensiByGuruId($guru_id, null, null, 5);
            
            // Get recent izin
            $data['izin_terbaru'] = $this->izinModel->getIzinByGuruId($guru_id);
            
            // Load guru dashboard view
            $this->loadView('guru/dashboard', $data);
        } else {
            // Unknown role
            $_SESSION['error'] = 'Role tidak dikenali';
            redirect('/auth/logout');
        }
    }
    
    public function profile() {
        requireAuth();
        
        $data = [];
        
        if (isAdmin()) {
            $user_id = $_SESSION['user_id'];
            $data['user'] = $this->guruModel->getGuruByUserId($user_id);
            
            $this->loadView('admin/profile', $data);
        } elseif (isGuru()) {
            $guru_id = $_SESSION['guru_id'];
            $data['guru'] = $this->guruModel->getGuruById($guru_id);
            
            $this->loadView('guru/profile', $data);
        }
    }
    
    public function updateProfile() {
        requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = 'Token CSRF tidak valid';
                redirect('/home/profile');
            }
            
            $user_id = $_SESSION['user_id'];
            $guru_id = $_SESSION['guru_id'];
            
            $data = [
                'nama' => sanitizeInput($_POST['nama']),
                'nip' => sanitizeInput($_POST['nip']),
                'jabatan' => sanitizeInput($_POST['jabatan'])
            ];
            
            // Handle file upload
            if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $max_size = 2 * 1024 * 1024; // 2MB
                
                $validation = validateFileUpload($_FILES['foto_profil'], $allowed_types, $max_size);
                
                if ($validation === true) {
                    $upload_dir = PUBLIC_PATH . '/uploads/profile/';
                    $filename = generateSecureFilename($_FILES['foto_profil']['name']);
                    $destination = $upload_dir . $filename;
                    
                    if (moveUploadedFile($_FILES['foto_profil'], $destination)) {
                        $data['foto_profil'] = $filename;
                    } else {
                        $_SESSION['error'] = 'Gagal mengupload foto profil';
                        redirect('/home/profile');
                    }
                } else {
                    $_SESSION['error'] = $validation;
                    redirect('/home/profile');
                }
            }
            
            // Update guru data
            if ($this->guruModel->updateGuru($guru_id, $data)) {
                $_SESSION['success'] = 'Profil berhasil diperbarui';
                
                // Log activity
                logActivity($user_id, 'update_profile', 'Memperbarui profil');
            } else {
                $_SESSION['error'] = 'Gagal memperbarui profil';
            }
            
            redirect('/home/profile');
        }
    }
    
    public function changePassword() {
        requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = 'Token CSRF tidak valid';
                redirect('/home/profile');
            }
            
            $user_id = $_SESSION['user_id'];
            
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            // Validate input
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $_SESSION['error'] = 'Semua field harus diisi';
                redirect('/home/profile');
            }
            
            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'Password baru dan konfirmasi password tidak cocok';
                redirect('/home/profile');
            }
            
            if (strlen($new_password) < 6) {
                $_SESSION['error'] = 'Password minimal 6 karakter';
                redirect('/home/profile');
            }
            
            // Get user data
            $penggunaModel = new Pengguna();
            $user = $penggunaModel->getPenggunaById($user_id);
            
            if (!$user) {
                $_SESSION['error'] = 'User tidak ditemukan';
                redirect('/home/profile');
            }
            
            // Verify current password
            if (!verifyPassword($current_password, $user['password'])) {
                $_SESSION['error'] = 'Password saat ini salah';
                redirect('/home/profile');
            }
            
            // Update password
            $hashed_password = hashPassword($new_password);
            if ($penggunaModel->updatePassword($user_id, $hashed_password)) {
                $_SESSION['success'] = 'Password berhasil diubah';
                
                // Log activity
                logActivity($user_id, 'change_password', 'Mengubah password');
            } else {
                $_SESSION['error'] = 'Gagal mengubah password';
            }
            
            redirect('/home/profile');
        }
    }
    
    public function notFound() {
        http_response_code(404);
        $this->loadView('error/404');
    }
    
    public function serverError() {
        http_response_code(500);
        $this->loadView('error/500');
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