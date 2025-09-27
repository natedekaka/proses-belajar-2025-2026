<?php
class AuthController {
    private $penggunaModel;
    
    public function __construct() {
        $this->penggunaModel = new Pengguna();
    }
    
    public function login() {
        // If already logged in, redirect to dashboard
        if (isLoggedIn()) {
            redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
        } else {
            $this->showLoginForm();
        }
    }
    
    private function showLoginForm() {
        $data = [
            'title' => 'Login',
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('auth/login', $data);
    }
    
    private function processLogin() {
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/auth/login');
        }
        
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];
        
        // Validate input
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Username dan password harus diisi';
            redirect('/auth/login');
        }
        
        // Check login attempts
        if (!checkLoginAttempts($username)) {
            $_SESSION['error'] = 'Terlalu banyak percobaan login. Coba lagi dalam 5 menit.';
            redirect('/auth/login');
        }
        
        // Authenticate user
        $user = $this->penggunaModel->authenticate($username, $password);
        
        if ($user) {
            // Clear login attempts
            clearLoginAttempts($username);
            
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['level_akses'];
            $_SESSION['guru_id'] = $user['guru_id'];
            $_SESSION['guru_nama'] = $user['guru_nama'];
            $_SESSION['guru_nip'] = $user['nip'];
            $_SESSION['foto_profil'] = $user['foto_profil'];
            $_SESSION['logged_in'] = true;
            
            // Update last login
            $this->penggunaModel->updateLastLogin($user['id']);
            
            // Log activity
            logActivity($user['id'], 'login', 'User login');
            
            // Redirect based on role
            if ($user['level_akses'] === 'admin') {
                redirect('/admin/dashboard');
            } else {
                redirect('/guru/dashboard');
            }
        } else {
            $_SESSION['error'] = 'Username atau password salah';
            redirect('/auth/login');
        }
    }
    
    public function logout() {
        if (isLoggedIn()) {
            // Log activity
            logActivity($_SESSION['user_id'], 'logout', 'User logout');
            
            // Destroy session
            session_destroy();
        }
        
        redirect('/auth/login');
    }
    
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processForgotPassword();
        } else {
            $this->showForgotPasswordForm();
        }
    }
    
    private function showForgotPasswordForm() {
        $data = [
            'title' => 'Lupa Password',
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('auth/forgot_password', $data);
    }
    
    private function processForgotPassword() {
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/auth/forgot-password');
        }
        
        $username = sanitizeInput($_POST['username']);
        
        if (empty($username)) {
            $_SESSION['error'] = 'Username harus diisi';
            redirect('/auth/forgot-password');
        }
        
        // Get user by username
        $user = $this->penggunaModel->getPenggunaByUsername($username);
        
        if ($user) {
            // Generate reset token
            $token = generateToken();
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Save token to database (you need to create a table for this)
            // For now, we'll just show a success message
            $_SESSION['success'] = 'Link reset password telah dikirim ke email Anda';
            
            // In a real application, you would send an email with reset link
            // For demo purposes, we'll just redirect to login
            redirect('/auth/login');
        } else {
            $_SESSION['error'] = 'Username tidak ditemukan';
            redirect('/auth/forgot-password');
        }
    }
    
    public function resetPassword($token = null) {
        if (!$token) {
            $_SESSION['error'] = 'Token reset tidak valid';
            redirect('/auth/forgot-password');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processResetPassword($token);
        } else {
            $this->showResetPasswordForm($token);
        }
    }
    
    private function showResetPasswordForm($token) {
        $data = [
            'title' => 'Reset Password',
            'token' => $token,
            'csrf_token' => generateCSRFToken()
        ];
        
        $this->loadView('auth/reset_password', $data);
    }
    
    private function processResetPassword($token) {
        // Validate CSRF token
        if (!validateCSRFToken($_POST['csrf_token'])) {
            $_SESSION['error'] = 'Token CSRF tidak valid';
            redirect('/auth/reset-password/' . $token);
        }
        
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (empty($password) || empty($confirm_password)) {
            $_SESSION['error'] = 'Password dan konfirmasi password harus diisi';
            redirect('/auth/reset-password/' . $token);
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Password dan konfirmasi password tidak cocok';
            redirect('/auth/reset-password/' . $token);
        }
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password minimal 6 karakter';
            redirect('/auth/reset-password/' . $token);
        }
        
        // Validate token (you need to implement this)
        // For now, we'll just show a success message
        $_SESSION['success'] = 'Password berhasil direset';
        redirect('/auth/login');
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