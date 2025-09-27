<?php
class GuruController {
    private $guruModel;
    
    public function __construct() {
        $this->guruModel = new Guru();
    }
    
    public function index() {
        requireAdmin();
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $data = [
            'title' => 'Data Guru',
            'guru_list' => $this->guruModel->getAllGuru($limit, $offset),
            'total_guru' => $this->guruModel->getGuruCount(),
            'current_page' => $page,
            'total_pages' => ceil($this->guruModel->getGuruCount() / $limit)
        ];
        
        $this->loadView('admin/guru/index', $data);
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
        $data = [
            'title' => 'Tambah Guru',
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('admin/guru/add', $data);
    }
    
    private function processAdd() {
        requireAdmin();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/guru/add');
        }
        
        $penggunaModel = new Pengguna();
        
        $nama = sanitizeInput($_POST['nama']);
        $nip = sanitizeInput($_POST['nip']);
        $jabatan = sanitizeInput($_POST['jabatan']);
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $level_akses = $_POST['level_akses'] ?? 'guru';
        
        // Validate input
        if (empty($nama) || empty($nip) || empty($username) || empty($password)) {
            $_SESSION['error'] = 'Semua field harus diisi';
            redirect('/guru/add');
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Password dan konfirmasi password tidak cocok';
            redirect('/guru/add');
        }
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password minimal 6 karakter';
            redirect('/guru/add');
        }
        
        // Check if username already exists
        if ($penggunaModel->usernameExists($username)) {
            $_SESSION['error'] = 'Username sudah digunakan';
            redirect('/guru/add');
        }
        
        // Handle file upload
        $foto_profil = '';
        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            $validation = validateFileUpload($_FILES['foto_profil'], $allowed_types, $max_size);
            
            if ($validation === true) {
                $upload_dir = PUBLIC_PATH . '/uploads/profile/';
                $filename = generateSecureFilename($_FILES['foto_profil']['name']);
                $destination = $upload_dir . $filename;
                
                if (moveUploadedFile($_FILES['foto_profil'], $destination)) {
                    $foto_profil = $filename;
                } else {
                    $_SESSION['error'] = 'Gagal mengupload foto profil';
                    redirect('/guru/add');
                }
            } else {
                $_SESSION['error'] = $validation;
                redirect('/guru/add');
            }
        }
        
        // Hash password
        $hashed_password = hashPassword($password);
        
        // Prepare data
        $guru_data = [
            'nama' => $nama,
            'nip' => $nip,
            'jabatan' => $jabatan,
            'status_aktif' => 1,
            'foto_profil' => $foto_profil,
            'username' => $username,
            'password' => $hashed_password,
            'level_akses' => $level_akses
        ];
        
        // Create guru
        if ($this->guruModel->createGuru($guru_data)) {
            $_SESSION['success'] = 'Guru berhasil ditambahkan';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'add_guru', 'Menambahkan guru: ' . $nama);
            
            redirect('/guru');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan guru';
            redirect('/guru/add');
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
        $guru = $this->guruModel->getGuruById($id);
        
        if (!$guru) {
            $_SESSION['error'] = 'Guru tidak ditemukan';
            redirect('/guru');
        }
        
        $data = [
            'title' => 'Edit Guru',
            'guru' => $guru,
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('admin/guru/edit', $data);
    }
    
    private function processEdit($id) {
        requireAdmin();
        
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/guru/edit/' . $id);
        }
        
        $penggunaModel = new Pengguna();
        
        $nama = sanitizeInput($_POST['nama']);
        $nip = sanitizeInput($_POST['nip']);
        $jabatan = sanitizeInput($_POST['jabatan']);
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'] ?? null;
        $confirm_password = $_POST['confirm_password'] ?? null;
        $level_akses = $_POST['level_akses'] ?? 'guru';
        
        // Validate input
        if (empty($nama) || empty($nip) || empty($username)) {
            $_SESSION['error'] = 'Nama, NIP, dan username harus diisi';
            redirect('/guru/edit/' . $id);
        }
        
        if ($password && $password !== $confirm_password) {
            $_SESSION['error'] = 'Password dan konfirmasi password tidak cocok';
            redirect('/guru/edit/' . $id);
        }
        
        if ($password && strlen($password) < 6) {
            $_SESSION['error'] = 'Password minimal 6 karakter';
            redirect('/guru/edit/' . $id);
        }
        
        // Check if username already exists (excluding current user)
        if ($penggunaModel->usernameExists($username, $id)) {
            $_SESSION['error'] = 'Username sudah digunakan';
            redirect('/guru/edit/' . $id);
        }
        
        // Handle file upload
        $foto_profil = '';
        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            $validation = validateFileUpload($_FILES['foto_profil'], $allowed_types, $max_size);
            
            if ($validation === true) {
                $upload_dir = PUBLIC_PATH . '/uploads/profile/';
                $filename = generateSecureFilename($_FILES['foto_profil']['name']);
                $destination = $upload_dir . $filename;
                
                if (moveUploadedFile($_FILES['foto_profil'], $destination)) {
                    $foto_profil = $filename;
                } else {
                    $_SESSION['error'] = 'Gagal mengupload foto profil';
                    redirect('/guru/edit/' . $id);
                }
            } else {
                $_SESSION['error'] = $validation;
                redirect('/guru/edit/' . $id);
            }
        }
        
        // Prepare data
        $guru_data = [
            'nama' => $nama,
            'nip' => $nip,
            'jabatan' => $jabatan,
            'status_aktif' => 1,
            'foto_profil' => $foto_profil,
            'username' => $username,
            'level_akses' => $level_akses
        ];
        
        // Hash password if provided
        if ($password) {
            $guru_data['password'] = hashPassword($password);
        }
        
        // Update guru
        if ($this->guruModel->updateGuru($id, $guru_data)) {
            $_SESSION['success'] = 'Guru berhasil diperbarui';
            
            // Log activity
            logActivity($_SESSION['user_id'], 'edit_guru', 'Memperbarui guru: ' . $nama);
            
            redirect('/guru');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui guru';
            redirect('/guru/edit/' . $id);
        }
    }
    
    public function delete($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!validateCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = 'Token CSRF tidak valid';
                redirect('/guru');
            }
            
            $guru = $this->guruModel->getGuruById($id);
            
            if (!$guru) {
                $_SESSION['error'] = 'Guru tidak ditemukan';
                redirect('/guru');
            }
            
            if ($this->guruModel->deleteGuru($id)) {
                $_SESSION['success'] = 'Guru berhasil dinonaktifkan';
                
                // Log activity
                logActivity($_SESSION['user_id'], 'delete_guru', 'Menonaktifkan guru: ' . $guru['nama']);
            } else {
                $_SESSION['error'] = 'Gagal menonaktifkan guru';
            }
            
            redirect('/guru');
        }
    }
    
    public function view($id) {
        requireAdmin();
        
        $guru = $this->guruModel->getGuruById($id);
        
        if (!$guru) {
            $_SESSION['error'] = 'Guru tidak ditemukan';
            redirect('/guru');
        }
        
        $data = [
            'title' => 'Detail Guru',
            'guru' => $guru
        ];
        
        $this->loadView('admin/guru/view', $data);
    }
    
    public function search() {
        requireAdmin();
        
        $keyword = sanitizeInput($_GET['keyword'] ?? '');
        
        if (empty($keyword)) {
            redirect('/guru');
        }
        
        $data = [
            'title' => 'Hasil Pencarian Guru',
            'guru_list' => $this->guruModel->searchGuru($keyword),
            'keyword' => $keyword
        ];
        
        $this->loadView('admin/guru/search', $data);
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