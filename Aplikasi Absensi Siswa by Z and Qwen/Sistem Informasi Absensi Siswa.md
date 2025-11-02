# Sistem Informasi Absensi Siswa

Saya akan membuat aplikasi Sistem Informasi Absensi Siswa yang lengkap sesuai dengan spesifikasi yang Anda berikan. Mari kita mulai dengan struktur database dan kemudian setiap file PHP yang diperlukan.

## 1. Database Structure (database.sql)

```sql
CREATE DATABASE IF NOT EXISTS db_absensi;
USE db_absensi;

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'guru') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel tahun_ajaran
CREATE TABLE tahun_ajaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tahun VARCHAR(9) NOT NULL UNIQUE,
    is_active BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel semester
CREATE TABLE semester (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tahun_ajaran_id INT NOT NULL,
    nama ENUM('Ganjil', 'Genap') NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    is_active BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tahun_ajaran_id) REFERENCES tahun_ajaran(id) ON DELETE CASCADE
);

-- Tabel kelas
CREATE TABLE kelas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(50) NOT NULL,
    wali_kelas VARCHAR(100) NOT NULL,
    semester_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (semester_id) REFERENCES semester(id) ON DELETE CASCADE
);

-- Tabel siswa
CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) NOT NULL UNIQUE,
    nisn VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    kelas_id INT NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
);

-- Tabel absensi
CREATE TABLE absensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    tanggal DATE NOT NULL,
    status ENUM('Hadir', 'Sakit', 'Izin', 'Alfa', 'Terlambat') NOT NULL,
    semester_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (semester_id) REFERENCES semester(id) ON DELETE CASCADE,
    UNIQUE KEY unique_attendance (siswa_id, tanggal)
);

-- Index untuk optimasi
CREATE INDEX idx_kelas_semester ON kelas(semester_id);
CREATE INDEX idx_siswa_kelas ON siswa(kelas_id);
CREATE INDEX idx_absensi_siswa ON absensi(siswa_id);
CREATE INDEX idx_absensi_tanggal ON absensi(tanggal);
CREATE INDEX idx_absensi_semester ON absensi(semester_id);

-- Insert data awal
-- Password admin: admin123 (hashed)
INSERT INTO users (username, password, nama, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Password guru: guru123 (hashed)
INSERT INTO users (username, password, nama, role) VALUES 
('guru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Guru Pengajar', 'guru');

-- Tambah tahun ajaran
INSERT INTO tahun_ajaran (tahun, is_active) VALUES 
('2025/2026', 1);

-- Tambah semester
INSERT INTO semester (tahun_ajaran_id, nama, tanggal_mulai, tanggal_selesai, is_active) VALUES 
(1, 'Ganjil', '2025-07-01', '2025-12-31', 1);

-- Tambah kelas
INSERT INTO kelas (nama_kelas, wali_kelas, semester_id) VALUES 
('X RPL 1', 'Budi Santoso, S.Kom', 1),
('X RPL 2', 'Ani Wijaya, S.Kom', 1),
('XI RPL 1', 'Cahyo Prabowo, S.Kom', 1),
('XI RPL 2', 'Dewi Lestari, S.Kom', 1),
('XII RPL 1', 'Eko Prasetyo, S.Kom', 1),
('XII RPL 2', 'Fitri Handayani, S.Kom', 1);

-- Tambah siswa contoh
INSERT INTO siswa (nis, nisn, nama, kelas_id, jenis_kelamin) VALUES 
('2025001', '0051234567', 'Ahmad Rizki', 1, 'L'),
('2025002', '0051234568', 'Siti Nurhaliza', 1, 'P'),
('2025003', '0051234569', 'Budi Cahyono', 1, 'L'),
('2025004', '0051234570', 'Diana Putri', 2, 'P'),
('2025005', '0051234571', 'Eko Prasetya', 2, 'L'),
('2025006', '0051234572', 'Fitri Handayani', 3, 'P'),
('2025007', '0051234573', 'Gunawan Setiawan', 3, 'L'),
('2025008', '0051234574', 'Hana Permata', 4, 'P'),
('2025009', '0051234575', 'Irfan Hakim', 5, 'L'),
('2025010', '0051234576', 'Julia Rahmawati', 5, 'P');
```

## 2. File Konfigurasi (config.php)

```php
<?php
// Start session
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_absensi');

// Base URL
define('BASE_URL', '/absensi-siswa/');

// Connect to database
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to check if user is admin
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Function to get active period (tahun ajaran + semester)
function get_active_period() {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT ta.tahun, s.nama as semester_nama, s.id as semester_id 
            FROM tahun_ajaran ta
            JOIN semester s ON ta.id = s.tahun_ajaran_id
            WHERE ta.is_active = 1 AND s.is_active = 1
            LIMIT 1
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

// Get active period and store in global variable
$active_period = get_active_period();
define('ACTIVE_SEMESTER_ID', $active_period ? $active_period['semester_id'] : 0);
define('ACTIVE_PERIOD_TEXT', $active_period ? "T.A {$active_period['tahun']} - Semester {$active_period['semester_nama']}" : "Tidak Ada Periode Aktif");

// Function to redirect
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

// Function to show notification
function show_notification($message, $type = 'success') {
    $_SESSION['notification'] = [
        'message' => $message,
        'type' => $type
    ];
}

// Function to display notification
function display_notification() {
    if (isset($_SESSION['notification'])) {
        $notification = $_SESSION['notification'];
        unset($_SESSION['notification']);
        
        $alert_class = $notification['type'] === 'success' ? 'alert-success' : 'alert-danger';
        
        echo "<div class='alert {$alert_class} alert-dismissible fade show' role='alert'>
                {$notification['message']}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}

// Function to sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Function to validate date
function validate_date($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
?>
```

## 3. File Fungsi Bantu (includes/functions.php)

```php
<?php
// Fungsi-fungsi bantu untuk aplikasi

// Fungsi untuk generate password hash
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fungsi untuk verifikasi password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Fungsi untuk format tanggal Indonesia
function format_tanggal($tanggal) {
    if (empty($tanggal)) return '-';
    
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// Fungsi untuk menghitung jumlah hari dalam rentang tanggal
function count_days($start_date, $end_date) {
    $datetime1 = new DateTime($start_date);
    $datetime2 = new DateTime($end_date);
    $interval = $datetime1->diff($datetime2);
    return $interval->days + 1;
}

// Fungsi untuk mendapatkan status absensi dengan warna
function get_status_badge($status) {
    $badges = [
        'Hadir' => '<span class="badge bg-success">Hadir</span>',
        'Sakit' => '<span class="badge bg-warning">Sakit</span>',
        'Izin' => '<span class="badge bg-info">Izin</span>',
        'Alfa' => '<span class="badge bg-danger">Alfa</span>',
        'Terlambat' => '<span class="badge bg-secondary">Terlambat</span>'
    ];
    
    return isset($badges[$status]) ? $badges[$status] : '<span class="badge bg-secondary">-</span>';
}

// Fungsi untuk export ke CSV
function export_to_csv($data, $filename, $headers) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Add BOM to fix UTF-8 in Excel
    fputs($output, "\xEF\xBB\xBF");
    
    // Add headers
    fputcsv($output, $headers);
    
    // Add data
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit();
}

// Fungsi untuk import dari CSV
function import_from_csv($file, $required_fields, $callback) {
    $imported_data = [];
    $errors = [];
    
    if (($handle = fopen($file['tmp_name'], 'r')) !== FALSE) {
        // Skip BOM if present
        if (fgets($handle, 4) !== "\xEF\xBB\xBF") {
            rewind($handle);
        }
        
        // Get headers
        $headers = fgetcsv($handle, 1000, ',');
        
        // Validate headers
        foreach ($required_fields as $field) {
            if (!in_array($field, $headers)) {
                $errors[] = "Kolom '$field' tidak ditemukan dalam file CSV";
                break;
            }
        }
        
        if (empty($errors)) {
            $row_number = 2; // Start from 2 because we already read the header
            
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $row_data = array_combine($headers, $data);
                
                // Validate required fields
                $missing_fields = [];
                foreach ($required_fields as $field) {
                    if (empty($row_data[$field])) {
                        $missing_fields[] = $field;
                    }
                }
                
                if (!empty($missing_fields)) {
                    $errors[] = "Baris $row_number: Kolom " . implode(', ', $missing_fields) . " tidak boleh kosong";
                } else {
                    // Process row using callback function
                    $result = $callback($row_data, $row_number);
                    
                    if ($result !== true) {
                        $errors[] = $result;
                    } else {
                        $imported_data[] = $row_data;
                    }
                }
                
                $row_number++;
            }
        }
        
        fclose($handle);
    } else {
        $errors[] = "Gagal membuka file CSV";
    }
    
    return [
        'data' => $imported_data,
        'errors' => $errors,
        'total_imported' => count($imported_data)
    ];
}
?>
```

## 4. Header (includes/header.php)

```php
<?php
if (!defined('BASE_URL')) exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Absensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar .nav-link {
            color: #333;
            border-radius: 0;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .sidebar .nav-link:hover:not(.active) {
            background-color: #e9ecef;
        }
        .content {
            padding: 20px;
        }
        .period-notice {
            background-color: #d1ecf1;
            border-left: 4px solid #0c5460;
            padding: 10px 15px;
            margin-bottom: 20px;
        }
        .period-notice.warning {
            background-color: #f8d7da;
            border-left-color: #721c24;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .attendance-card {
            transition: transform 0.2s;
        }
        .attendance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .attendance-status {
            cursor: pointer;
        }
        .attendance-status input[type="radio"] {
            display: none;
        }
        .attendance-status input[type="radio"]:checked + label {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
        .print-only {
            display: none;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-center">Absensi Siswa</h4>
                </div>
                <nav class="nav flex-column">
                    <a href="<?php echo BASE_URL; ?>dashboard/" class="nav-link">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="<?php echo BASE_URL; ?>absen/" class="nav-link">
                        <i class="bi bi-calendar-check me-2"></i> Input Absensi
                    </a>
                    <a href="<?php echo BASE_URL; ?>rekap/" class="nav-link">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i> Rekapitulasi
                    </a>
                    <a href="<?php echo BASE_URL; ?>siswa/" class="nav-link">
                        <i class="bi bi-people me-2"></i> Data Siswa
                    </a>
                    <a href="<?php echo BASE_URL; ?>kelas/" class="nav-link">
                        <i class="bi bi-house-door me-2"></i> Data Kelas
                    </a>
                    <?php if (is_admin()): ?>
                    <a href="<?php echo BASE_URL; ?>tahun_ajaran/" class="nav-link">
                        <i class="bi bi-calendar-range me-2"></i> Tahun Ajaran
                    </a>
                    <a href="<?php echo BASE_URL; ?>semester/" class="nav-link">
                        <i class="bi bi-calendar-week me-2"></i> Semester
                    </a>
                    <?php endif; ?>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 content">
                <!-- Top Navigation -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3><?php echo isset($page_title) ? $page_title : 'Sistem Informasi Absensi Siswa'; ?></h3>
                    <div class="d-flex align-items-center">
                        <span class="me-3">Halo, <strong><?php echo $_SESSION['user_nama']; ?></strong></span>
                        <a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </div>
                </div>
                
                <!-- Period Notice -->
                <div class="period-notice <?php echo ACTIVE_SEMESTER_ID ? '' : 'warning'; ?>">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Periode Aktif:</strong> <?php echo ACTIVE_PERIOD_TEXT; ?>
                    <?php if (!ACTIVE_SEMESTER_ID && is_admin()): ?>
                    <a href="<?php echo BASE_URL; ?>semester/" class="btn btn-sm btn-primary ms-2">Aktifkan Semester</a>
                    <?php endif; ?>
                </div>
                
                <!-- Notification -->
                <?php display_notification(); ?>
```

## 5. Footer (includes/footer.php)

```php
<?php
if (!defined('BASE_URL')) exit('No direct script access allowed');
?>
            </div>
        </div>
    </div>
    
    <footer class="bg-light text-center p-3 mt-5 no-print">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Sistem Informasi Absensi Siswa. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Function to confirm delete
        function confirmDelete(message) {
            return confirm(message || 'Apakah Anda yakin ingin menghapus data ini?');
        }
        
        // Function to show loading
        function showLoading(element) {
            element.disabled = true;
            element.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        }
        
        // Function to reset loading
        function resetLoading(element, originalText) {
            element.disabled = false;
            element.innerHTML = originalText;
        }
        
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
```

## 6. Halaman Login (login.php)

```php
<?php
// If already logged in, redirect to dashboard
if (is_logged_in()) {
    redirect('dashboard/');
}

$page_title = 'Login';
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h4>Login Sistem Absensi</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>proses_login.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
```

## 7. Proses Login (proses_login.php)

```php
<?php
require_once 'config.php';

// If already logged in, redirect to dashboard
if (is_logged_in()) {
    redirect('dashboard/');
}

// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['user_role'] = $user['role'];
            
            show_notification('Login berhasil! Selamat datang, ' . $user['nama']);
            redirect('dashboard/');
        } else {
            show_notification('Username atau password salah!', 'danger');
            redirect('login.php');
        }
    } catch (PDOException $e) {
        show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        redirect('login.php');
    }
} else {
    redirect('login.php');
}
?>
```

## 8. Logout (logout.php)

```php
<?php
require_once 'config.php';

// Destroy session
session_unset();
session_destroy();

show_notification('Anda telah berhasil logout');
redirect('login.php');
?>
```

## 9. Halaman Utama (index.php)

```php
<?php
require_once 'config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

// If logged in, redirect to dashboard
redirect('dashboard/');
?>
```

## 10. Dashboard (dashboard/index.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

$page_title = 'Dashboard';
include '../includes/header.php';

// Get statistics
try {
    // Total siswa
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM siswa s JOIN kelas k ON s.kelas_id = k.id WHERE k.semester_id = ?");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $total_siswa = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total kelas
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM kelas WHERE semester_id = ?");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $total_kelas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total absensi hari ini
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM absensi WHERE tanggal = CURDATE() AND semester_id = ?");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $total_absensi_hari_ini = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Statistik kehadiran bulan ini
    $stmt = $pdo->prepare("
        SELECT 
            status,
            COUNT(*) as total
        FROM absensi 
        WHERE MONTH(tanggal) = MONTH(CURDATE()) 
        AND YEAR(tanggal) = YEAR(CURDATE())
        AND semester_id = ?
        GROUP BY status
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $statistik_kehadiran = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare data for chart
    $chart_labels = [];
    $chart_data = [];
    $chart_colors = [
        'Hadir' => '#28a745',
        'Sakit' => '#ffc107',
        'Izin' => '#17a2b8',
        'Alfa' => '#dc3545',
        'Terlambat' => '#6c757d'
    ];
    
    foreach ($statistik_kehadiran as $stat) {
        $chart_labels[] = $stat['status'];
        $chart_data[] = $stat['total'];
    }
    
    // Get recent attendance
    $stmt = $pdo->prepare("
        SELECT 
            a.tanggal,
            s.nama as nama_siswa,
            k.nama_kelas,
            a.status
        FROM absensi a
        JOIN siswa s ON a.siswa_id = s.id
        JOIN kelas k ON s.kelas_id = k.id
        WHERE a.semester_id = ?
        ORDER BY a.tanggal DESC, a.created_at DESC
        LIMIT 10
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $recent_attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Siswa</h5>
                <h2 class="text-primary"><?php echo $total_siswa; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Kelas</h5>
                <h2 class="text-info"><?php echo $total_kelas; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Absensi Hari Ini</h5>
                <h2 class="text-success"><?php echo $total_absensi_hari_ini; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">User Login</h5>
                <h2 class="text-warning"><?php echo $_SESSION['user_nama']; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Kehadiran Bulan Ini</h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Absensi Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_attendance)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data absensi</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($recent_attendance as $attendance): ?>
                            <tr>
                                <td><?php echo format_tanggal($attendance['tanggal']); ?></td>
                                <td><?php echo $attendance['nama_siswa']; ?></td>
                                <td><?php echo $attendance['nama_kelas']; ?></td>
                                <td><?php echo get_status_badge($attendance['status']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Attendance Chart
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [{
                data: <?php echo json_encode($chart_data); ?>,
                backgroundColor: <?php echo json_encode(array_map(function($label) use ($chart_colors) {
                    return $chart_colors[$label] ?? '#6c757d';
                }, $chart_labels)); ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: false
                }
            }
        }
    });
</script>

<?php include '../includes/footer.php'; ?>
```

## 11. Manajemen Tahun Ajaran (tahun_ajaran/index.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

$page_title = 'Manajemen Tahun Ajaran';
include '../includes/header.php';

// Get all tahun ajaran
try {
    $stmt = $pdo->query("SELECT * FROM tahun_ajaran ORDER BY tahun DESC");
    $tahun_ajaran_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $tahun_ajaran_list = [];
}
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Tahun Ajaran</h5>
        <a href="<?php echo BASE_URL; ?>tahun_ajaran/tambah.php" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Tahun Ajaran
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Ajaran</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tahun_ajaran_list)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data tahun ajaran</td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($tahun_ajaran_list as $tahun_ajaran): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $tahun_ajaran['tahun']; ?></td>
                        <td>
                            <?php if ($tahun_ajaran['is_active']): ?>
                            <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo format_tanggal($tahun_ajaran['created_at']); ?></td>
                        <td>
                            <?php if (!$tahun_ajaran['is_active']): ?>
                            <a href="<?php echo BASE_URL; ?>tahun_ajaran/aktifkan.php?id=<?php echo $tahun_ajaran['id']; ?>" 
                               class="btn btn-sm btn-success" 
                               onclick="return confirm('Apakah Anda yakin ingin mengaktifkan tahun ajaran ini?')">
                                <i class="bi bi-check-circle me-1"></i> Aktifkan
                            </a>
                            <?php else: ?>
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="bi bi-check-circle me-1"></i> Sedang Aktif
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 12. Tambah Tahun Ajaran (tahun_ajaran/tambah.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

$page_title = 'Tambah Tahun Ajaran';
include '../includes/header.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun = sanitize($_POST['tahun']);
    
    // Validate input
    if (empty($tahun)) {
        show_notification('Tahun ajaran harus diisi', 'danger');
    } else {
        try {
            // Check if tahun ajaran already exists
            $stmt = $pdo->prepare("SELECT id FROM tahun_ajaran WHERE tahun = ?");
            $stmt->execute([$tahun]);
            
            if ($stmt->fetch()) {
                show_notification('Tahun ajaran sudah ada', 'danger');
            } else {
                // Insert new tahun ajaran
                $stmt = $pdo->prepare("INSERT INTO tahun_ajaran (tahun) VALUES (?)");
                $stmt->execute([$tahun]);
                
                show_notification('Tahun ajaran berhasil ditambahkan');
                redirect('tahun_ajaran/');
            }
        } catch (PDOException $e) {
            show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Tambah Tahun Ajaran</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun Ajaran</label>
                <input type="text" class="form-control" id="tahun" name="tahun" 
                       placeholder="Contoh: 2025/2026" required>
                <div class="form-text">Format: YYYY/YYYY (contoh: 2025/2026)</div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>tahun_ajaran/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 13. Aktifkan Tahun Ajaran (tahun_ajaran/aktifkan.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Get tahun ajaran ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    show_notification('ID tahun ajaran tidak valid', 'danger');
    redirect('tahun_ajaran/');
}

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // Deactivate all tahun ajaran
    $stmt = $pdo->prepare("UPDATE tahun_ajaran SET is_active = 0");
    $stmt->execute();
    
    // Activate selected tahun ajaran
    $stmt = $pdo->prepare("UPDATE tahun_ajaran SET is_active = 1 WHERE id = ?");
    $stmt->execute([$id]);
    
    // Commit transaction
    $pdo->commit();
    
    show_notification('Tahun ajaran berhasil diaktifkan');
    redirect('tahun_ajaran/');
} catch (PDOException $e) {
    // Rollback transaction
    $pdo->rollBack();
    
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('tahun_ajaran/');
}
?>
```

## 14. Manajemen Semester (semester/index.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

$page_title = 'Manajemen Semester';
include '../includes/header.php';

// Get all semester with tahun ajaran
try {
    $stmt = $pdo->query("
        SELECT s.*, ta.tahun 
        FROM semester s
        JOIN tahun_ajaran ta ON s.tahun_ajaran_id = ta.id
        ORDER BY ta.tahun DESC, s.nama DESC
    ");
    $semester_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $semester_list = [];
}
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Semester</h5>
        <a href="<?php echo BASE_URL; ?>semester/tambah.php" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Semester
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($semester_list)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data semester</td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($semester_list as $semester): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $semester['tahun']; ?></td>
                        <td><?php echo $semester['nama']; ?></td>
                        <td><?php echo format_tanggal($semester['tanggal_mulai']); ?></td>
                        <td><?php echo format_tanggal($semester['tanggal_selesai']); ?></td>
                        <td>
                            <?php if ($semester['is_active']): ?>
                            <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$semester['is_active']): ?>
                            <a href="<?php echo BASE_URL; ?>semester/aktifkan.php?id=<?php echo $semester['id']; ?>" 
                               class="btn btn-sm btn-success" 
                               onclick="return confirm('Apakah Anda yakin ingin mengaktifkan semester ini?')">
                                <i class="bi bi-check-circle me-1"></i> Aktifkan
                            </a>
                            <?php else: ?>
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="bi bi-check-circle me-1"></i> Sedang Aktif
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 15. Tambah Semester (semester/tambah.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

$page_title = 'Tambah Semester';
include '../includes/header.php';

// Get all tahun ajaran
try {
    $stmt = $pdo->query("SELECT * FROM tahun_ajaran ORDER BY tahun DESC");
    $tahun_ajaran_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $tahun_ajaran_list = [];
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun_ajaran_id = (int)$_POST['tahun_ajaran_id'];
    $nama = sanitize($_POST['nama']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    
    // Validate input
    if (empty($tahun_ajaran_id) || empty($nama) || empty($tanggal_mulai) || empty($tanggal_selesai)) {
        show_notification('Semua field harus diisi', 'danger');
    } elseif (!validate_date($tanggal_mulai) || !validate_date($tanggal_selesai)) {
        show_notification('Format tanggal tidak valid', 'danger');
    } elseif ($tanggal_mulai >= $tanggal_selesai) {
        show_notification('Tanggal mulai harus lebih awal dari tanggal selesai', 'danger');
    } else {
        try {
            // Check if semester already exists
            $stmt = $pdo->prepare("SELECT id FROM semester WHERE tahun_ajaran_id = ? AND nama = ?");
            $stmt->execute([$tahun_ajaran_id, $nama]);
            
            if ($stmt->fetch()) {
                show_notification('Semester untuk tahun ajaran ini sudah ada', 'danger');
            } else {
                // Insert new semester
                $stmt = $pdo->prepare("
                    INSERT INTO semester (tahun_ajaran_id, nama, tanggal_mulai, tanggal_selesai) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$tahun_ajaran_id, $nama, $tanggal_mulai, $tanggal_selesai]);
                
                show_notification('Semester berhasil ditambahkan');
                redirect('semester/');
            }
        } catch (PDOException $e) {
            show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Tambah Semester</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php foreach ($tahun_ajaran_list as $tahun_ajaran): ?>
                    <option value="<?php echo $tahun_ajaran['id']; ?>"><?php echo $tahun_ajaran['tahun']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Semester</label>
                <select class="form-select" id="nama" name="nama" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>semester/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 16. Aktifkan Semester (semester/aktifkan.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Get semester ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    show_notification('ID semester tidak valid', 'danger');
    redirect('semester/');
}

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // Deactivate all semesters
    $stmt = $pdo->prepare("UPDATE semester SET is_active = 0");
    $stmt->execute();
    
    // Get tahun ajaran ID from the selected semester
    $stmt = $pdo->prepare("SELECT tahun_ajaran_id FROM semester WHERE id = ?");
    $stmt->execute([$id]);
    $semester = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($semester) {
        // Activate the selected semester
        $stmt = $pdo->prepare("UPDATE semester SET is_active = 1 WHERE id = ?");
        $stmt->execute([$id]);
        
        // Also activate the corresponding tahun ajaran
        $stmt = $pdo->prepare("UPDATE tahun_ajaran SET is_active = 1 WHERE id = ?");
        $stmt->execute([$semester['tahun_ajaran_id']]);
    }
    
    // Commit transaction
    $pdo->commit();
    
    show_notification('Semester berhasil diaktifkan');
    redirect('semester/');
} catch (PDOException $e) {
    // Rollback transaction
    $pdo->rollBack();
    
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('semester/');
}
?>
```

## 17. Manajemen Kelas (kelas/index.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

$page_title = 'Manajemen Kelas';
include '../includes/header.php';

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
}

// Get all kelas for active semester
try {
    $stmt = $pdo->prepare("
        SELECT k.*, s.nama as semester_nama, ta.tahun 
        FROM kelas k
        JOIN semester s ON k.semester_id = s.id
        JOIN tahun_ajaran ta ON s.tahun_ajaran_id = ta.id
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Kelas</h5>
        <div>
            <?php if (is_admin()): ?>
            <a href="<?php echo BASE_URL; ?>kelas/import.php" class="btn btn-warning me-2">
                <i class="bi bi-upload me-1"></i> Import CSV
            </a>
            <a href="<?php echo BASE_URL; ?>kelas/tambah.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kelas
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk mengelola data kelas.
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Semester</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kelas_list)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data kelas untuk semester ini</td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($kelas_list as $kelas): ?>
                    <?php
                    // Get jumlah siswa
                    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM siswa WHERE kelas_id = ?");
                    $stmt->execute([$kelas['id']]);
                    $jumlah_siswa = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $kelas['nama_kelas']; ?></td>
                        <td><?php echo $kelas['wali_kelas']; ?></td>
                        <td><?php echo $kelas['semester_nama']; ?> - <?php echo $kelas['tahun']; ?></td>
                        <td><?php echo $jumlah_siswa; ?> siswa</td>
                        <td>
                            <?php if (is_admin()): ?>
                            <a href="<?php echo BASE_URL; ?>kelas/edit.php?id=<?php echo $kelas['id']; ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <a href="<?php echo BASE_URL; ?>kelas/hapus.php?id=<?php echo $kelas['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo BASE_URL; ?>siswa/?kelas_id=<?php echo $kelas['id']; ?>" class="btn btn-sm btn-success">
                                <i class="bi bi-people me-1"></i> Lihat Siswa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 18. Tambah Kelas (kelas/tambah.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
    redirect('kelas/');
}

$page_title = 'Tambah Kelas';
include '../includes/header.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kelas = sanitize($_POST['nama_kelas']);
    $wali_kelas = sanitize($_POST['wali_kelas']);
    
    // Validate input
    if (empty($nama_kelas) || empty($wali_kelas)) {
        show_notification('Semua field harus diisi', 'danger');
    } else {
        try {
            // Check if kelas already exists for this semester
            $stmt = $pdo->prepare("SELECT id FROM kelas WHERE nama_kelas = ? AND semester_id = ?");
            $stmt->execute([$nama_kelas, ACTIVE_SEMESTER_ID]);
            
            if ($stmt->fetch()) {
                show_notification('Kelas dengan nama ini sudah ada untuk semester aktif', 'danger');
            } else {
                // Insert new kelas
                $stmt = $pdo->prepare("
                    INSERT INTO kelas (nama_kelas, wali_kelas, semester_id) 
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([$nama_kelas, $wali_kelas, ACTIVE_SEMESTER_ID]);
                
                show_notification('Kelas berhasil ditambahkan');
                redirect('kelas/');
            }
        } catch (PDOException $e) {
            show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Tambah Kelas</h5>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk menambah kelas.
        </div>
        <?php else: ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" 
                       placeholder="Contoh: X RPL 1" required>
            </div>
            <div class="mb-3">
                <label for="wali_kelas" class="form-label">Wali Kelas</label>
                <input type="text" class="form-control" id="wali_kelas" name="wali_kelas" 
                       placeholder="Contoh: Budi Santoso, S.Kom" required>
            </div>
            <div class="mb-3">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Kelas akan ditambahkan untuk periode: <?php echo ACTIVE_PERIOD_TEXT; ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>kelas/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 19. Edit Kelas (kelas/edit.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Get kelas ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    show_notification('ID kelas tidak valid', 'danger');
    redirect('kelas/');
}

// Get kelas data
try {
    $stmt = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
    $stmt->execute([$id]);
    $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$kelas) {
        show_notification('Kelas tidak ditemukan', 'danger');
        redirect('kelas/');
    }
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('kelas/');
}

$page_title = 'Edit Kelas';
include '../includes/header.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kelas = sanitize($_POST['nama_kelas']);
    $wali_kelas = sanitize($_POST['wali_kelas']);
    
    // Validate input
    if (empty($nama_kelas) || empty($wali_kelas)) {
        show_notification('Semua field harus diisi', 'danger');
    } else {
        try {
            // Check if kelas already exists for this semester (excluding current kelas)
            $stmt = $pdo->prepare("SELECT id FROM kelas WHERE nama_kelas = ? AND semester_id = ? AND id != ?");
            $stmt->execute([$nama_kelas, $kelas['semester_id'], $id]);
            
            if ($stmt->fetch()) {
                show_notification('Kelas dengan nama ini sudah ada untuk semester ini', 'danger');
            } else {
                // Update kelas
                $stmt = $pdo->prepare("
                    UPDATE kelas 
                    SET nama_kelas = ?, wali_kelas = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$nama_kelas, $wali_kelas, $id]);
                
                show_notification('Kelas berhasil diperbarui');
                redirect('kelas/');
            }
        } catch (PDOException $e) {
            show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Edit Kelas</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" 
                       value="<?php echo $kelas['nama_kelas']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="wali_kelas" class="form-label">Wali Kelas</label>
                <input type="text" class="form-control" id="wali_kelas" name="wali_kelas" 
                       value="<?php echo $kelas['wali_kelas']; ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>kelas/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 20. Hapus Kelas (kelas/hapus.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Get kelas ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    show_notification('ID kelas tidak valid', 'danger');
    redirect('kelas/');
}

try {
    // Check if there are students in this class
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM siswa WHERE kelas_id = ?");
    $stmt->execute([$id]);
    $jumlah_siswa = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if ($jumlah_siswa > 0) {
        show_notification('Tidak dapat menghapus kelas karena masih ada ' . $jumlah_siswa . ' siswa di dalamnya', 'danger');
        redirect('kelas/');
    } else {
        // Delete kelas
        $stmt = $pdo->prepare("DELETE FROM kelas WHERE id = ?");
        $stmt->execute([$id]);
        
        show_notification('Kelas berhasil dihapus');
        redirect('kelas/');
    }
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('kelas/');
}
?>
```

## 21. Import Kelas (kelas/import.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
    redirect('kelas/');
}

$page_title = 'Import Kelas dari CSV';
include '../includes/header.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $required_fields = ['nama_kelas', 'wali_kelas'];
    
    $callback = function($row_data, $row_number) use ($pdo) {
        try {
            // Check if kelas already exists for this semester
            $stmt = $pdo->prepare("SELECT id FROM kelas WHERE nama_kelas = ? AND semester_id = ?");
            $stmt->execute([$row_data['nama_kelas'], ACTIVE_SEMESTER_ID]);
            
            if ($stmt->fetch()) {
                return "Baris $row_number: Kelas '{$row_data['nama_kelas']}' sudah ada untuk semester aktif";
            } else {
                // Insert new kelas
                $stmt = $pdo->prepare("
                    INSERT INTO kelas (nama_kelas, wali_kelas, semester_id) 
                    VALUES (?, ?, ?)
                ");
                $stmt->execute([
                    $row_data['nama_kelas'],
                    $row_data['wali_kelas'],
                    ACTIVE_SEMESTER_ID
                ]);
                
                return true;
            }
        } catch (PDOException $e) {
            return "Baris $row_number: " . $e->getMessage();
        }
    };
    
    $result = import_from_csv($_FILES['csv_file'], $required_fields, $callback);
    
    if (empty($result['errors'])) {
        show_notification("Berhasil mengimport {$result['total_imported']} data kelas");
        redirect('kelas/');
    } else {
        foreach ($result['errors'] as $error) {
            show_notification($error, 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Import Kelas dari CSV</h5>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk import data kelas.
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Pastikan file CSV Anda memiliki kolom: <strong>nama_kelas</strong> dan <strong>wali_kelas</strong>.
            <br>Download template CSV <a href="<?php echo BASE_URL; ?>kelas/template_kelas.csv" class="alert-link">di sini</a>.
        </div>
        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="csv_file" class="form-label">Pilih File CSV</label>
                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>kelas/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-1"></i> Import
                </button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 22. Template CSV Kelas (kelas/template_kelas.csv)

```csv
nama_kelas,wali_kelas
X RPL 1,Budi Santoso, S.Kom
X RPL 2,Ani Wijaya, S.Kom
XI RPL 1,Cahyo Prabowo, S.Kom
XI RPL 2,Dewi Lestari, S.Kom
XII RPL 1,Eko Prasetyo, S.Kom
XII RPL 2,Fitri Handayani, S.Kom
```

## 23. Manajemen Siswa (siswa/index.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

$page_title = 'Manajemen Siswa';
include '../includes/header.php';

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
}

// Get filter parameters
$kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Get all kelas for filter dropdown
try {
    $stmt = $pdo->prepare("
        SELECT k.id, k.nama_kelas 
        FROM kelas k
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}

// Build query for siswa
$query = "
    SELECT s.*, k.nama_kelas 
    FROM siswa s
    JOIN kelas k ON s.kelas_id = k.id
    WHERE k.semester_id = ?
";
$params = [ACTIVE_SEMESTER_ID];

// Add kelas filter if selected
if ($kelas_id > 0) {
    $query .= " AND s.kelas_id = ?";
    $params[] = $kelas_id;
}

// Add search filter if provided
if (!empty($search)) {
    $query .= " AND (s.nis LIKE ? OR s.nisn LIKE ? OR s.nama LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
}

$query .= " ORDER BY k.nama_kelas, s.nama";

// Get siswa data
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $siswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $siswa_list = [];
}
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Daftar Siswa</h5>
        <div>
            <?php if (is_admin()): ?>
            <a href="<?php echo BASE_URL; ?>siswa/export.php" class="btn btn-success me-2">
                <i class="bi bi-download me-1"></i> Export CSV
            </a>
            <a href="<?php echo BASE_URL; ?>siswa/import.php" class="btn btn-warning me-2">
                <i class="bi bi-upload me-1"></i> Import CSV
            </a>
            <a href="<?php echo BASE_URL; ?>siswa/tambah.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Siswa
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk mengelola data siswa.
        </div>
        <?php else: ?>
        <!-- Filter Form -->
        <form method="get" class="mb-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <select class="form-select" name="kelas_id">
                        <option value="">Semua Kelas</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                        <option value="<?php echo $kelas['id']; ?>" <?php echo $kelas_id == $kelas['id'] ? 'selected' : ''; ?>>
                            <?php echo $kelas['nama_kelas']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan NIS, NISN, atau Nama" value="<?php echo $search; ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($siswa_list)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data siswa</td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($siswa_list as $siswa): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $siswa['nis']; ?></td>
                        <td><?php echo $siswa['nisn']; ?></td>
                        <td><?php echo $siswa['nama']; ?></td>
                        <td><?php echo $siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                        <td><?php echo $siswa['nama_kelas']; ?></td>
                        <td>
                            <?php if (is_admin()): ?>
                            <a href="<?php echo BASE_URL; ?>siswa/edit.php?id=<?php echo $siswa['id']; ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <a href="<?php echo BASE_URL; ?>siswa/hapus.php?id=<?php echo $siswa['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo BASE_URL; ?>absen/absensi_persiswa.php?id=<?php echo $siswa['id']; ?>" class="btn btn-sm btn-success">
                                <i class="bi bi-calendar-check me-1"></i> Absensi
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 24. Tambah Siswa (siswa/tambah.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
    redirect('siswa/');
}

$page_title = 'Tambah Siswa';
include '../includes/header.php';

// Get all kelas for active semester
try {
    $stmt = $pdo->prepare("
        SELECT k.id, k.nama_kelas 
        FROM kelas k
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = sanitize($_POST['nis']);
    $nisn = sanitize($_POST['nisn']);
    $nama = sanitize($_POST['nama']);
    $kelas_id = (int)$_POST['kelas_id'];
    $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
    
    // Validate input
    if (empty($nis) || empty($nisn) || empty($nama) || empty($kelas_id) || empty($jenis_kelamin)) {
        show_notification('Semua field harus diisi', 'danger');
    } elseif (!in_array($jenis_kelamin, ['L', 'P'])) {
        show_notification('Jenis kelamin tidak valid', 'danger');
    } else {
        try {
            // Check if NIS already exists
            $stmt = $pdo->prepare("SELECT id FROM siswa WHERE nis = ?");
            $stmt->execute([$nis]);
            
            if ($stmt->fetch()) {
                show_notification('NIS sudah digunakan', 'danger');
            } else {
                // Check if NISN already exists
                $stmt = $pdo->prepare("SELECT id FROM siswa WHERE nisn = ?");
                $stmt->execute([$nisn]);
                
                if ($stmt->fetch()) {
                    show_notification('NISN sudah digunakan', 'danger');
                } else {
                    // Insert new siswa
                    $stmt = $pdo->prepare("
                        INSERT INTO siswa (nis, nisn, nama, kelas_id, jenis_kelamin) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([$nis, $nisn, $nama, $kelas_id, $jenis_kelamin]);
                    
                    show_notification('Siswa berhasil ditambahkan');
                    redirect('siswa/');
                }
            }
        } catch (PDOException $e) {
            show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Tambah Siswa</h5>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk menambah siswa.
        </div>
        <?php elseif (empty($kelas_list)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada kelas untuk semester aktif. Silakan tambah kelas terlebih dahulu.
        </div>
        <?php else: ?>
        <form action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select class="form-select" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelas_list as $kelas): ?>
                            <option value="<?php echo $kelas['id']; ?>"><?php echo $kelas['nama_kelas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>siswa/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 25. Edit Siswa (siswa/edit.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Get siswa ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    show_notification('ID siswa tidak valid', 'danger');
    redirect('siswa/');
}

// Get siswa data
try {
    $stmt = $pdo->prepare("
        SELECT s.*, k.nama_kelas 
        FROM siswa s
        JOIN kelas k ON s.kelas_id = k.id
        WHERE s.id = ?
    ");
    $stmt->execute([$id]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$siswa) {
        show_notification('Siswa tidak ditemukan', 'danger');
        redirect('siswa/');
    }
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('siswa/');
}

// Get all kelas for active semester
try {
    $stmt = $pdo->prepare("
        SELECT k.id, k.nama_kelas 
        FROM kelas k
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}

$page_title = 'Edit Siswa';
include '../includes/header.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = sanitize($_POST['nis']);
    $nisn = sanitize($_POST['nisn']);
    $nama = sanitize($_POST['nama']);
    $kelas_id = (int)$_POST['kelas_id'];
    $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
    
    // Validate input
    if (empty($nis) || empty($nisn) || empty($nama) || empty($kelas_id) || empty($jenis_kelamin)) {
        show_notification('Semua field harus diisi', 'danger');
    } elseif (!in_array($jenis_kelamin, ['L', 'P'])) {
        show_notification('Jenis kelamin tidak valid', 'danger');
    } else {
        try {
            // Check if NIS already exists (excluding current siswa)
            $stmt = $pdo->prepare("SELECT id FROM siswa WHERE nis = ? AND id != ?");
            $stmt->execute([$nis, $id]);
            
            if ($stmt->fetch()) {
                show_notification('NIS sudah digunakan', 'danger');
            } else {
                // Check if NISN already exists (excluding current siswa)
                $stmt = $pdo->prepare("SELECT id FROM siswa WHERE nisn = ? AND id != ?");
                $stmt->execute([$nisn, $id]);
                
                if ($stmt->fetch()) {
                    show_notification('NISN sudah digunakan', 'danger');
                } else {
                    // Update siswa
                    $stmt = $pdo->prepare("
                        UPDATE siswa 
                        SET nis = ?, nisn = ?, nama = ?, kelas_id = ?, jenis_kelamin = ? 
                        WHERE id = ?
                    ");
                    $stmt->execute([$nis, $nisn, $nama, $kelas_id, $jenis_kelamin, $id]);
                    
                    show_notification('Data siswa berhasil diperbarui');
                    redirect('siswa/');
                }
            }
        } catch (PDOException $e) {
            show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Edit Siswa</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" 
                               value="<?php echo $siswa['nis']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" 
                               value="<?php echo $siswa['nisn']; ?>" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" 
                       value="<?php echo $siswa['nama']; ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select class="form-select" id="kelas_id" name="kelas_id" required>
                            <?php foreach ($kelas_list as $kelas): ?>
                            <option value="<?php echo $kelas['id']; ?>" 
                                    <?php echo $kelas['id'] == $siswa['kelas_id'] ? 'selected' : ''; ?>>
                                <?php echo $kelas['nama_kelas']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L" <?php echo $siswa['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>
                                Laki-laki
                            </option>
                            <option value="P" <?php echo $siswa['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>
                                Perempuan
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>siswa/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 26. Hapus Siswa (siswa/hapus.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Get siswa ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    show_notification('ID siswa tidak valid', 'danger');
    redirect('siswa/');
}

try {
    // Check if there are attendance records for this student
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM absensi WHERE siswa_id = ?");
    $stmt->execute([$id]);
    $jumlah_absensi = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if ($jumlah_absensi > 0) {
        show_notification('Tidak dapat menghapus siswa karena masih ada ' . $jumlah_absensi . ' record absensi', 'danger');
        redirect('siswa/');
    } else {
        // Delete siswa
        $stmt = $pdo->prepare("DELETE FROM siswa WHERE id = ?");
        $stmt->execute([$id]);
        
        show_notification('Siswa berhasil dihapus');
        redirect('siswa/');
    }
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('siswa/');
}
?>
```

## 27. Import Siswa (siswa/import.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
    redirect('siswa/');
}

$page_title = 'Import Siswa dari CSV';
include '../includes/header.php';

// Get all kelas for active semester
try {
    $stmt = $pdo->prepare("
        SELECT k.id, k.nama_kelas 
        FROM kelas k
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}

// Create kelas mapping for easier lookup
$kelas_mapping = [];
foreach ($kelas_list as $kelas) {
    $kelas_mapping[$kelas['nama_kelas']] = $kelas['id'];
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $required_fields = ['nis', 'nisn', 'nama', 'kelas', 'jenis_kelamin'];
    
    $callback = function($row_data, $row_number) use ($pdo, $kelas_mapping) {
        try {
            // Check if kelas exists
            if (!isset($kelas_mapping[$row_data['kelas']])) {
                return "Baris $row_number: Kelas '{$row_data['kelas']}' tidak ditemukan";
            }
            
            $kelas_id = $kelas_mapping[$row_data['kelas']];
            
            // Check if NIS already exists
            $stmt = $pdo->prepare("SELECT id FROM siswa WHERE nis = ?");
            $stmt->execute([$row_data['nis']]);
            
            if ($stmt->fetch()) {
                return "Baris $row_number: NIS '{$row_data['nis']}' sudah digunakan";
            } else {
                // Check if NISN already exists
                $stmt = $pdo->prepare("SELECT id FROM siswa WHERE nisn = ?");
                $stmt->execute([$row_data['nisn']]);
                
                if ($stmt->fetch()) {
                    return "Baris $row_number: NISN '{$row_data['nisn']}' sudah digunakan";
                } else {
                    // Validate jenis_kelamin
                    $jenis_kelamin = strtoupper(substr($row_data['jenis_kelamin'], 0, 1));
                    if (!in_array($jenis_kelamin, ['L', 'P'])) {
                        return "Baris $row_number: Jenis kelamin tidak valid (harus L/P)";
                    }
                    
                    // Insert new siswa
                    $stmt = $pdo->prepare("
                        INSERT INTO siswa (nis, nisn, nama, kelas_id, jenis_kelamin) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $row_data['nis'],
                        $row_data['nisn'],
                        $row_data['nama'],
                        $kelas_id,
                        $jenis_kelamin
                    ]);
                    
                    return true;
                }
            }
        } catch (PDOException $e) {
            return "Baris $row_number: " . $e->getMessage();
        }
    };
    
    $result = import_from_csv($_FILES['csv_file'], $required_fields, $callback);
    
    if (empty($result['errors'])) {
        show_notification("Berhasil mengimport {$result['total_imported']} data siswa");
        redirect('siswa/');
    } else {
        foreach ($result['errors'] as $error) {
            show_notification($error, 'danger');
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Import Siswa dari CSV</h5>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk import data siswa.
        </div>
        <?php elseif (empty($kelas_list)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada kelas untuk semester aktif. Silakan tambah kelas terlebih dahulu.
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Pastikan file CSV Anda memiliki kolom: <strong>nis, nisn, nama, kelas, jenis_kelamin</strong>.
            <br>Download template CSV <a href="<?php echo BASE_URL; ?>siswa/template_siswa.csv" class="alert-link">di sini</a>.
        </div>
        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="csv_file" class="form-label">Pilih File CSV</label>
                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>siswa/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-1"></i> Import
                </button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 28. Export Siswa (siswa/export.php)

```php
<?php
require_once '../config.php';

// If not logged in or not admin, redirect to dashboard
if (!is_logged_in() || !is_admin()) {
    redirect('dashboard/');
}

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
    redirect('siswa/');
}

try {
    // Get all siswa for active semester
    $stmt = $pdo->prepare("
        SELECT s.nis, s.nisn, s.nama, k.nama_kelas as kelas, s.jenis_kelamin
        FROM siswa s
        JOIN kelas k ON s.kelas_id = k.id
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas, s.nama
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $siswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare data for export
    $export_data = [];
    foreach ($siswa_list as $siswa) {
        $export_data[] = [
            $siswa['nis'],
            $siswa['nisn'],
            $siswa['nama'],
            $siswa['kelas'],
            $siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'
        ];
    }
    
    // Export to CSV
    $headers = ['nis', 'nisn', 'nama', 'kelas', 'jenis_kelamin'];
    $filename = 'data_siswa_' . date('Y-m-d') . '.csv';
    
    export_to_csv($export_data, $filename, $headers);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('siswa/');
}
?>
```

## 29. Template CSV Siswa (siswa/template_siswa.csv)

```csv
nis,nisn,nama,kelas,jenis_kelamin
2025001,0051234567,Ahmad Rizki,X RPL 1,L
2025002,0051234568,Siti Nurhaliza,X RPL 1,P
2025003,0051234569,Budi Cahyono,X RPL 1,L
2025004,0051234570,Diana Putri,X RPL 2,P
2025005,0051234571,Eko Prasetya,X RPL 2,L
```

## 30. Input Absensi (absen/index.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

$page_title = 'Input Absensi';
include '../includes/header.php';

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
}

// Get all kelas for active semester
try {
    $stmt = $pdo->prepare("
        SELECT k.id, k.nama_kelas 
        FROM kelas k
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}

// Set default date to today
$selected_date = date('Y-m-d');
$selected_kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;

if (isset($_GET['tanggal']) && validate_date($_GET['tanggal'])) {
    $selected_date = $_GET['tanggal'];
}
?>

<div class="card">
    <div class="card-header">
        <h5>Input Absensi Harian</h5>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk input absensi.
        </div>
        <?php elseif (empty($kelas_list)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada kelas untuk semester aktif. Silakan tambah kelas terlebih dahulu.
        </div>
        <?php else: ?>
        <form id="filterForm" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="kelas_id" class="form-label">Pilih Kelas</label>
                    <select class="form-select" id="kelas_id" name="kelas_id" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                        <option value="<?php echo $kelas['id']; ?>" <?php echo $selected_kelas_id == $kelas['id'] ? 'selected' : ''; ?>>
                            <?php echo $kelas['nama_kelas']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                           value="<?php echo $selected_date; ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>
                    <button type="button" id="saveBtn" class="btn btn-success" disabled>
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
        
        <div id="siswaContainer">
            <div class="text-center py-5">
                <p>Silakan pilih kelas dan tanggal untuk menampilkan daftar siswa</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const kelasSelect = document.getElementById('kelas_id');
    const tanggalInput = document.getElementById('tanggal');
    const siswaContainer = document.getElementById('siswaContainer');
    const saveBtn = document.getElementById('saveBtn');
    
    // Load siswa when form is submitted
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const kelasId = kelasSelect.value;
        const tanggal = tanggalInput.value;
        
        if (!kelasId || !tanggal) {
            return;
        }
        
        // Update URL without page reload
        const url = new URL(window.location);
        url.searchParams.set('kelas_id', kelasId);
        url.searchParams.set('tanggal', tanggal);
        window.history.pushState({}, '', url);
        
        // Show loading
        siswaContainer.innerHTML = '<div class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Fetch siswa data
        fetch('<?php echo BASE_URL; ?>absen/get_siswa.php?kelas_id=' + kelasId + '&tanggal=' + tanggal)
            .then(response => response.text())
            .then(data => {
                siswaContainer.innerHTML = data;
                saveBtn.disabled = false;
            })
            .catch(error => {
                siswaContainer.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan: ' + error.message + '</div>';
                saveBtn.disabled = true;
            });
    });
    
    // Save attendance data
    saveBtn.addEventListener('click', function() {
        if (this.disabled) return;
        
        const kelasId = kelasSelect.value;
        const tanggal = tanggalInput.value;
        
        if (!kelasId || !tanggal) {
            return;
        }
        
        // Collect attendance data
        const attendanceData = {};
        const attendanceElements = document.querySelectorAll('.attendance-status input[type="radio"]:checked');
        
        attendanceElements.forEach(element => {
            const siswaId = element.getAttribute('data-siswa-id');
            const status = element.value;
            attendanceData[siswaId] = status;
        });
        
        if (Object.keys(attendanceData).length === 0) {
            alert('Tidak ada data absensi yang dipilih');
            return;
        }
        
        // Show loading
        const originalText = saveBtn.innerHTML;
        showLoading(saveBtn);
        
        // Send data to server
        const formData = new FormData();
        formData.append('kelas_id', kelasId);
        formData.append('tanggal', tanggal);
        
        for (const [siswaId, status] of Object.entries(attendanceData)) {
            formData.append('attendance[' + siswaId + ']', status);
        }
        
        fetch('<?php echo BASE_URL; ?>absen/proses.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            resetLoading(saveBtn, originalText);
            
            if (data.success) {
                alert('Data absensi berhasil disimpan');
                // Reload the page to show updated data
                filterForm.dispatchEvent(new Event('submit'));
            } else {
                alert('Terjadi kesalahan: ' + data.message);
            }
        })
        .catch(error => {
            resetLoading(saveBtn, originalText);
            alert('Terjadi kesalahan: ' + error.message);
        });
    });
    
    // Auto-load if kelas_id and tanggal are in URL
    if (selected_kelas_id && selected_date) {
        filterForm.dispatchEvent(new Event('submit'));
    }
});
</script>

<?php include '../includes/footer.php'; ?>
```

## 31. Get Siswa untuk Absensi (absen/get_siswa.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

// Get parameters
$kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

// Validate parameters
if ($kelas_id <= 0 || empty($tanggal) || !validate_date($tanggal)) {
    echo '<div class="alert alert-danger">Parameter tidak valid</div>';
    exit;
}

try {
    // Get kelas info
    $stmt = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
    $stmt->execute([$kelas_id]);
    $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$kelas) {
        echo '<div class="alert alert-danger">Kelas tidak ditemukan</div>';
        exit;
    }
    
    // Get all siswa in this class
    $stmt = $pdo->prepare("
        SELECT s.*, 
               a.status as attendance_status
        FROM siswa s
        LEFT JOIN absensi a ON s.id = a.siswa_id AND a.tanggal = ?
        WHERE s.kelas_id = ?
        ORDER BY s.nama
    ");
    $stmt->execute([$tanggal, $kelas_id]);
    $siswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($siswa_list)) {
        echo '<div class="alert alert-info">Tidak ada siswa di kelas ini</div>';
        exit;
    }
    
    // Display form
    echo '<div class="mb-3">';
    echo '<h5>Kelas: ' . $kelas['nama_kelas'] . '</h5>';
    echo '<p>Tanggal: ' . format_tanggal($tanggal) . '</p>';
    echo '</div>';
    
    echo '<div class="row">';
    foreach ($siswa_list as $siswa) {
        $current_status = $siswa['attendance_status'] ?: 'Hadir';
        
        echo '<div class="col-md-6 col-lg-4 mb-3">';
        echo '<div class="card attendance-card">';
        echo '<div class="card-body">';
        echo '<h6 class="card-title">' . $siswa['nama'] . '</h6>';
        echo '<p class="card-text text-muted">NIS: ' . $siswa['nis'] . '</p>';
        
        echo '<div class="attendance-status">';
        echo '<div class="btn-group w-100" role="group">';
        
        $statuses = ['Hadir', 'Sakit', 'Izin', 'Alfa', 'Terlambat'];
        foreach ($statuses as $status) {
            $checked = $current_status === $status ? 'checked' : '';
            $color = '';
            
            switch ($status) {
                case 'Hadir': $color = 'btn-success'; break;
                case 'Sakit': $color = 'btn-warning'; break;
                case 'Izin': $color = 'btn-info'; break;
                case 'Alfa': $color = 'btn-danger'; break;
                case 'Terlambat': $color = 'btn-secondary'; break;
            }
            
            echo '<input type="radio" class="btn-check" name="attendance[' . $siswa['id'] . ']" 
                    id="attendance_' . $siswa['id'] . '_' . $status . '" 
                    value="' . $status . '" data-siswa-id="' . $siswa['id'] . '" ' . $checked . '>';
            echo '<label class="btn ' . $color . '" for="attendance_' . $siswa['id'] . '_' . $status . '">' . $status . '</label>';
        }
        
        echo '</div>';
        echo '</div>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
}
?>
```

## 32. Proses Absensi (absen/proses.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

// Set response header
header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid']);
    exit;
}

// Get and validate parameters
$kelas_id = isset($_POST['kelas_id']) ? (int)$_POST['kelas_id'] : 0;
$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
$attendance = isset($_POST['attendance']) ? $_POST['attendance'] : [];

if ($kelas_id <= 0 || empty($tanggal) || !validate_date($tanggal) || empty($attendance)) {
    echo json_encode(['success' => false, 'message' => 'Parameter tidak valid']);
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // Process each student's attendance
    foreach ($attendance as $siswa_id => $status) {
        $siswa_id = (int)$siswa_id;
        
        if ($siswa_id <= 0 || empty($status)) {
            continue;
        }
        
        // Check if attendance record already exists
        $stmt = $pdo->prepare("
            SELECT id FROM absensi 
            WHERE siswa_id = ? AND tanggal = ? AND semester_id = ?
        ");
        $stmt->execute([$siswa_id, $tanggal, ACTIVE_SEMESTER_ID]);
        $existing_record = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing_record) {
            // Update existing record
            $stmt = $pdo->prepare("
                UPDATE absensi 
                SET status = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            $stmt->execute([$status, $existing_record['id']]);
        } else {
            // Insert new record
            $stmt = $pdo->prepare("
                INSERT INTO absensi (siswa_id, tanggal, status, semester_id) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$siswa_id, $tanggal, $status, ACTIVE_SEMESTER_ID]);
        }
    }
    
    // Commit transaction
    $pdo->commit();
    
    echo json_encode(['success' => true, 'message' => 'Data absensi berhasil disimpan']);
} catch (PDOException $e) {
    // Rollback transaction
    $pdo->rollBack();
    
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}
?>
```

## 33. Absensi Per Siswa (absen/absensi_persiswa.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

// Get siswa ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    show_notification('ID siswa tidak valid', 'danger');
    redirect('siswa/');
}

// Get siswa data
try {
    $stmt = $pdo->prepare("
        SELECT s.*, k.nama_kelas 
        FROM siswa s
        JOIN kelas k ON s.kelas_id = k.id
        WHERE s.id = ?
    ");
    $stmt->execute([$id]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$siswa) {
        show_notification('Siswa tidak ditemukan', 'danger');
        redirect('siswa/');
    }
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    redirect('siswa/');
}

// Get filter parameters
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

// Validate month and year
if ($bulan < 1 || $bulan > 12) {
    $bulan = date('n');
}

if ($tahun < 2020 || $tahun > date('Y') + 1) {
    $tahun = date('Y');
}

// Get attendance data for this student
try {
    $stmt = $pdo->prepare("
        SELECT a.tanggal, a.status 
        FROM absensi a
        WHERE a.siswa_id = ? AND MONTH(a.tanggal) = ? AND YEAR(a.tanggal) = ? AND a.semester_id = ?
        ORDER BY a.tanggal DESC
    ");
    $stmt->execute([$id, $bulan, $tahun, ACTIVE_SEMESTER_ID]);
    $attendance_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get attendance statistics
    $stmt = $pdo->prepare("
        SELECT 
            status,
            COUNT(*) as total
        FROM absensi 
        WHERE siswa_id = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND semester_id = ?
        GROUP BY status
    ");
    $stmt->execute([$id, $bulan, $tahun, ACTIVE_SEMESTER_ID]);
    $attendance_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare statistics array
    $stats = [
        'Hadir' => 0,
        'Sakit' => 0,
        'Izin' => 0,
        'Alfa' => 0,
        'Terlambat' => 0
    ];
    
    foreach ($attendance_stats as $stat) {
        $stats[$stat['status']] = $stat['total'];
    }
    
    $total_days = count_days(date("$tahun-$bulan-01"), date("$tahun-$bulan-" . date('t', mktime(0, 0, 0, $bulan, 1, $tahun))));
    $total_attendance = array_sum($stats);
    
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $attendance_list = [];
    $stats = [
        'Hadir' => 0,
        'Sakit' => 0,
        'Izin' => 0,
        'Alfa' => 0,
        'Terlambat' => 0
    ];
    $total_attendance = 0;
    $total_days = 0;
}

$page_title = 'Absensi Siswa';
include '../includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h5>Data Absensi Siswa</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td><?php echo $siswa['nama']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>NIS</strong></td>
                        <td><?php echo $siswa['nis']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>NISN</strong></td>
                        <td><?php echo $siswa['nisn']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Kelas</strong></td>
                        <td><?php echo $siswa['nama_kelas']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td><?php echo $siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Periode</strong></td>
                        <td><?php echo ACTIVE_PERIOD_TEXT; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Filter Form -->
        <form method="get" class="mb-4">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <select class="form-select" name="bulan">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $bulan == $i ? 'selected' : ''; ?>>
                            <?php echo date('F', mktime(0, 0, 0, $i, 1)); ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="tahun">
                        <?php for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $tahun == $i ? 'selected' : ''; ?>>
                            <?php echo $i; ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-success"><?php echo $stats['Hadir']; ?></h5>
                        <p class="card-text">Hadir</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-warning"><?php echo $stats['Sakit']; ?></h5>
                        <p class="card-text">Sakit</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-info"><?php echo $stats['Izin']; ?></h5>
                        <p class="card-text">Izin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-danger"><?php echo $stats['Alfa']; ?></h5>
                        <p class="card-text">Alfa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-secondary"><?php echo $stats['Terlambat']; ?></h5>
                        <p class="card-text">Terlambat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?php echo $total_attendance; ?>/<?php echo $total_days; ?></h5>
                        <p class="card-text">Total</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Attendance Chart -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Grafik Kehadiran</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Persentase Kehadiran</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="percentageChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Attendance Table -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($attendance_list)): ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data absensi untuk bulan ini</td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($attendance_list as $attendance): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo format_tanggal($attendance['tanggal']); ?></td>
                        <td><?php echo get_status_badge($attendance['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            <a href="<?php echo BASE_URL; ?>siswa/" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?php echo BASE_URL; ?>rekap/cetak.php?type=siswa&id=<?php echo $id; ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>" 
               class="btn btn-primary" target="_blank">
                <i class="bi bi-printer me-1"></i> Cetak
            </a>
        </div>
    </div>
</div>

<script>
// Attendance Chart
const ctx1 = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Hadir', 'Sakit', 'Izin', 'Alfa', 'Terlambat'],
        datasets: [{
            label: 'Jumlah Kehadiran',
            data: [<?php echo $stats['Hadir']; ?>, <?php echo $stats['Sakit']; ?>, <?php echo $stats['Izin']; ?>, <?php echo $stats['Alfa']; ?>, <?php echo $stats['Terlambat']; ?>],
            backgroundColor: [
                '#28a745',
                '#ffc107',
                '#17a2b8',
                '#dc3545',
                '#6c757d'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Percentage Chart
const ctx2 = document.getElementById('percentageChart').getContext('2d');
const totalAttendance = <?php echo $total_attendance; ?>;
const percentageChart = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Hadir', 'Sakit', 'Izin', 'Alfa', 'Terlambat'],
        datasets: [{
            data: [<?php echo $stats['Hadir']; ?>, <?php echo $stats['Sakit']; ?>, <?php echo $stats['Izin']; ?>, <?php echo $stats['Alfa']; ?>, <?php echo $stats['Terlambat']; ?>],
            backgroundColor: [
                '#28a745',
                '#ffc107',
                '#17a2b8',
                '#dc3545',
                '#6c757d'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const percentage = totalAttendance > 0 ? Math.round((value / totalAttendance) * 100) : 0;
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        }
    }
});
</script>

<?php include '../includes/footer.php'; ?>
```

## 34. Rekap Kelas (rekap/kelas.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

$page_title = 'Rekapitulasi Absensi Per Kelas';
include '../includes/header.php';

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
}

// Get all kelas for active semester
try {
    $stmt = $pdo->prepare("
        SELECT k.id, k.nama_kelas 
        FROM kelas k
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}

// Get filter parameters
$kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');

// Validate dates
if (!validate_date($tanggal_awal)) {
    $tanggal_awal = date('Y-m-01');
}

if (!validate_date($tanggal_akhir)) {
    $tanggal_akhir = date('Y-m-d');
}

if ($tanggal_awal > $tanggal_akhir) {
    $temp = $tanggal_awal;
    $tanggal_awal = $tanggal_akhir;
    $tanggal_akhir = $temp;
}

// Initialize variables
$rekap_data = [];
$stats = [
    'Hadir' => 0,
    'Sakit' => 0,
    'Izin' => 0,
    'Alfa' => 0,
    'Terlambat' => 0
];

// Process form submission
if ($kelas_id > 0) {
    try {
        // Get all siswa in this class
        $stmt = $pdo->prepare("
            SELECT s.id, s.nis, s.nisn, s.nama, s.jenis_kelamin
            FROM siswa s
            WHERE s.kelas_id = ?
            ORDER BY s.nama
        ");
        $stmt->execute([$kelas_id]);
        $siswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get attendance data for each student
        foreach ($siswa_list as $siswa) {
            $stmt = $pdo->prepare("
                SELECT 
                    status,
                    COUNT(*) as total
                FROM absensi 
                WHERE siswa_id = ? AND tanggal BETWEEN ? AND ? AND semester_id = ?
                GROUP BY status
            ");
            $stmt->execute([$siswa['id'], $tanggal_awal, $tanggal_akhir, ACTIVE_SEMESTER_ID]);
            $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Initialize student stats
            $student_stats = [
                'Hadir' => 0,
                'Sakit' => 0,
                'Izin' => 0,
                'Alfa' => 0,
                'Terlambat' => 0
            ];
            
            // Fill student stats
            foreach ($attendance_data as $data) {
                $student_stats[$data['status']] = $data['total'];
            }
            
            // Calculate total attendance
            $total_attendance = array_sum($student_stats);
            
            // Add to rekap data
            $rekap_data[] = [
                'siswa' => $siswa,
                'stats' => $student_stats,
                'total' => $total_attendance
            ];
            
            // Add to overall stats
            foreach ($student_stats as $status => $count) {
                $stats[$status] += $count;
            }
        }
        
        // Get kelas info
        $stmt = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
        $stmt->execute([$kelas_id]);
        $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Rekapitulasi Absensi Per Kelas</h5>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk melihat rekapitulasi.
        </div>
        <?php elseif (empty($kelas_list)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada kelas untuk semester aktif. Silakan tambah kelas terlebih dahulu.
        </div>
        <?php else: ?>
        <!-- Filter Form -->
        <form method="get" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="kelas_id" class="form-label">Pilih Kelas</label>
                    <select class="form-select" id="kelas_id" name="kelas_id" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                        <option value="<?php echo $kelas['id']; ?>" <?php echo $kelas_id == $kelas['id'] ? 'selected' : ''; ?>>
                            <?php echo $kelas['nama_kelas']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" 
                           value="<?php echo $tanggal_awal; ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" 
                           value="<?php echo $tanggal_akhir; ?>" required>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>
                </div>
            </div>
        </form>
        
        <?php if ($kelas_id > 0 && !empty($rekap_data)): ?>
        <!-- Class Info -->
        <div class="alert alert-info">
            <h5>Rekapitulasi Absensi Kelas: <?php echo $kelas['nama_kelas']; ?></h5>
            <p>Periode: <?php echo format_tanggal($tanggal_awal); ?> - <?php echo format_tanggal($tanggal_akhir); ?></p>
        </div>
        
        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-success"><?php echo $stats['Hadir']; ?></h5>
                        <p class="card-text">Hadir</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-warning"><?php echo $stats['Sakit']; ?></h5>
                        <p class="card-text">Sakit</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-info"><?php echo $stats['Izin']; ?></h5>
                        <p class="card-text">Izin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-danger"><?php echo $stats['Alfa']; ?></h5>
                        <p class="card-text">Alfa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-secondary"><?php echo $stats['Terlambat']; ?></h5>
                        <p class="card-text">Terlambat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?php echo array_sum($stats); ?></h5>
                        <p class="card-text">Total</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Attendance Chart -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Grafik Kehadiran</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Persentase Kehadiran</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="percentageChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rekap Table -->
        <div class="table-responsive mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alfa</th>
                        <th>Terlambat</th>
                        <th>Total</th>
                        <th>% Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($rekap_data as $data): ?>
                    <?php
                    $persentase_hadir = $data['total'] > 0 ? round(($data['stats']['Hadir'] / $data['total']) * 100, 2) : 0;
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['siswa']['nis']; ?></td>
                        <td><?php echo $data['siswa']['nama']; ?></td>
                        <td><?php echo $data['siswa']['jenis_kelamin'] == 'L' ? 'L' : 'P'; ?></td>
                        <td><?php echo $data['stats']['Hadir']; ?></td>
                        <td><?php echo $data['stats']['Sakit']; ?></td>
                        <td><?php echo $data['stats']['Izin']; ?></td>
                        <td><?php echo $data['stats']['Alfa']; ?></td>
                        <td><?php echo $data['stats']['Terlambat']; ?></td>
                        <td><?php echo $data['total']; ?></td>
                        <td><?php echo $persentase_hadir; ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="<?php echo BASE_URL; ?>rekap/" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?php echo BASE_URL; ?>rekap/cetak.php?type=kelas&kelas_id=<?php echo $kelas_id; ?>&tanggal_awal=<?php echo $tanggal_awal; ?>&tanggal_akhir=<?php echo $tanggal_akhir; ?>" 
               class="btn btn-primary" target="_blank">
                <i class="bi bi-printer me-1"></i> Cetak
            </a>
        </div>
        
        <script>
        // Attendance Chart
        const ctx1 = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Hadir', 'Sakit', 'Izin', 'Alfa', 'Terlambat'],
                datasets: [{
                    label: 'Jumlah Kehadiran',
                    data: [<?php echo $stats['Hadir']; ?>, <?php echo $stats['Sakit']; ?>, <?php echo $stats['Izin']; ?>, <?php echo $stats['Alfa']; ?>, <?php echo $stats['Terlambat']; ?>],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#17a2b8',
                        '#dc3545',
                        '#6c757d'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Percentage Chart
        const ctx2 = document.getElementById('percentageChart').getContext('2d');
        const totalAttendance = <?php echo array_sum($stats); ?>;
        const percentageChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Hadir', 'Sakit', 'Izin', 'Alfa', 'Terlambat'],
                datasets: [{
                    data: [<?php echo $stats['Hadir']; ?>, <?php echo $stats['Sakit']; ?>, <?php echo $stats['Izin']; ?>, <?php echo $stats['Alfa']; ?>, <?php echo $stats['Terlambat']; ?>],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#17a2b8',
                        '#dc3545',
                        '#6c757d'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const percentage = totalAttendance > 0 ? Math.round((value / totalAttendance) * 100) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        </script>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 35. Rekap Siswa (rekap/siswa.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

$page_title = 'Rekapitulasi Absensi Per Siswa';
include '../includes/header.php';

// Check if there's an active semester
if (!ACTIVE_SEMESTER_ID) {
    show_notification('Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu.', 'danger');
}

// Get all kelas for active semester
try {
    $stmt = $pdo->prepare("
        SELECT k.id, k.nama_kelas 
        FROM kelas k
        WHERE k.semester_id = ?
        ORDER BY k.nama_kelas
    ");
    $stmt->execute([ACTIVE_SEMESTER_ID]);
    $kelas_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    $kelas_list = [];
}

// Get filter parameters
$kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

// Validate month and year
if ($bulan < 1 || $bulan > 12) {
    $bulan = date('n');
}

if ($tahun < 2020 || $tahun > date('Y') + 1) {
    $tahun = date('Y');
}

// Initialize variables
$rekap_data = [];

// Process form submission
if ($kelas_id > 0) {
    try {
        // Get all siswa in this class
        $stmt = $pdo->prepare("
            SELECT s.id, s.nis, s.nisn, s.nama, s.jenis_kelamin
            FROM siswa s
            WHERE s.kelas_id = ?
            ORDER BY s.nama
        ");
        $stmt->execute([$kelas_id]);
        $siswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get attendance data for each student
        foreach ($siswa_list as $siswa) {
            $stmt = $pdo->prepare("
                SELECT 
                    status,
                    COUNT(*) as total
                FROM absensi 
                WHERE siswa_id = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND semester_id = ?
                GROUP BY status
            ");
            $stmt->execute([$siswa['id'], $bulan, $tahun, ACTIVE_SEMESTER_ID]);
            $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Initialize student stats
            $student_stats = [
                'Hadir' => 0,
                'Sakit' => 0,
                'Izin' => 0,
                'Alfa' => 0,
                'Terlambat' => 0
            ];
            
            // Fill student stats
            foreach ($attendance_data as $data) {
                $student_stats[$data['status']] = $data['total'];
            }
            
            // Calculate total attendance and percentage
            $total_attendance = array_sum($student_stats);
            $persentase_hadir = $total_attendance > 0 ? round(($student_stats['Hadir'] / $total_attendance) * 100, 2) : 0;
            
            // Add to rekap data
            $rekap_data[] = [
                'siswa' => $siswa,
                'stats' => $student_stats,
                'total' => $total_attendance,
                'persentase_hadir' => $persentase_hadir
            ];
        }
        
        // Get kelas info
        $stmt = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
        $stmt->execute([$kelas_id]);
        $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        show_notification('Terjadi kesalahan: ' . $e->getMessage(), 'danger');
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5>Rekapitulasi Absensi Per Siswa</h5>
    </div>
    <div class="card-body">
        <?php if (!ACTIVE_SEMESTER_ID): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada semester aktif. Silakan aktifkan semester terlebih dahulu untuk melihat rekapitulasi.
        </div>
        <?php elseif (empty($kelas_list)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tidak ada kelas untuk semester aktif. Silakan tambah kelas terlebih dahulu.
        </div>
        <?php else: ?>
        <!-- Filter Form -->
        <form method="get" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="kelas_id" class="form-label">Pilih Kelas</label>
                    <select class="form-select" id="kelas_id" name="kelas_id" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas_list as $kelas): ?>
                        <option value="<?php echo $kelas['id']; ?>" <?php echo $kelas_id == $kelas['id'] ? 'selected' : ''; ?>>
                            <?php echo $kelas['nama_kelas']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select class="form-select" id="bulan" name="bulan">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $bulan == $i ? 'selected' : ''; ?>>
                            <?php echo date('F', mktime(0, 0, 0, $i, 1)); ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select class="form-select" id="tahun" name="tahun">
                        <?php for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $tahun == $i ? 'selected' : ''; ?>>
                            <?php echo $i; ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>
                </div>
            </div>
        </form>
        
        <?php if ($kelas_id > 0 && !empty($rekap_data)): ?>
        <!-- Class Info -->
        <div class="alert alert-info">
            <h5>Rekapitulasi Absensi Kelas: <?php echo $kelas['nama_kelas']; ?></h5>
            <p>Periode: <?php echo date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)); ?></p>
        </div>
        
        <!-- Rekap Table -->
        <div class="table-responsive mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alfa</th>
                        <th>Terlambat</th>
                        <th>Total</th>
                        <th>% Hadir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($rekap_data as $data): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['siswa']['nis']; ?></td>
                        <td><?php echo $data['siswa']['nama']; ?></td>
                        <td><?php echo $data['siswa']['jenis_kelamin'] == 'L' ? 'L' : 'P'; ?></td>
                        <td><?php echo $data['stats']['Hadir']; ?></td>
                        <td><?php echo $data['stats']['Sakit']; ?></td>
                        <td><?php echo $data['stats']['Izin']; ?></td>
                        <td><?php echo $data['stats']['Alfa']; ?></td>
                        <td><?php echo $data['stats']['Terlambat']; ?></td>
                        <td><?php echo $data['total']; ?></td>
                        <td><?php echo $data['persentase_hadir']; ?>%</td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>absen/absensi_persiswa.php?id=<?php echo $data['siswa']['id']; ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="<?php echo BASE_URL; ?>rekap/" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?php echo BASE_URL; ?>rekap/cetak.php?type=rekap_kelas&kelas_id=<?php echo $kelas_id; ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>" 
               class="btn btn-primary" target="_blank">
                <i class="bi bi-printer me-1"></i> Cetak
            </a>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
```

## 36. Cetak Laporan (rekap/cetak.php)

```php
<?php
require_once '../config.php';

// If not logged in, redirect to login
if (!is_logged_in()) {
    redirect('login.php');
}

// Get parameters
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Initialize variables
$data = [];
$title = '';
$subtitle = '';

switch ($type) {
    case 'kelas':
        $kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;
        $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
        $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';
        
        if ($kelas_id <= 0 || empty($tanggal_awal) || empty($tanggal_akhir)) {
            echo 'Parameter tidak valid';
            exit;
        }
        
        try {
            // Get kelas info
            $stmt = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
            $stmt->execute([$kelas_id]);
            $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$kelas) {
                echo 'Kelas tidak ditemukan';
                exit;
            }
            
            // Get all siswa in this class
            $stmt = $pdo->prepare("
                SELECT s.id, s.nis, s.nisn, s.nama, s.jenis_kelamin
                FROM siswa s
                WHERE s.kelas_id = ?
                ORDER BY s.nama
            ");
            $stmt->execute([$kelas_id]);
            $siswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Get attendance data for each student
            foreach ($siswa_list as $siswa) {
                $stmt = $pdo->prepare("
                    SELECT 
                        status,
                        COUNT(*) as total
                    FROM absensi 
                    WHERE siswa_id = ? AND tanggal BETWEEN ? AND ? AND semester_id = ?
                    GROUP BY status
                ");
                $stmt->execute([$siswa['id'], $tanggal_awal, $tanggal_akhir, ACTIVE_SEMESTER_ID]);
                $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Initialize student stats
                $student_stats = [
                    'Hadir' => 0,
                    'Sakit' => 0,
                    'Izin' => 0,
                    'Alfa' => 0,
                    'Terlambat' => 0
                ];
                
                // Fill student stats
                foreach ($attendance_data as $data) {
                    $student_stats[$data['status']] = $data['total'];
                }
                
                // Calculate total attendance and percentage
                $total_attendance = array_sum($student_stats);
                $persentase_hadir = $total_attendance > 0 ? round(($student_stats['Hadir'] / $total_attendance) * 100, 2) : 0;
                
                // Add to data
                $data[] = [
                    'siswa' => $siswa,
                    'stats' => $student_stats,
                    'total' => $total_attendance,
                    'persentase_hadir' => $persentase_hadir
                ];
            }
            
            $title = 'Rekapitulasi Absensi Kelas: ' . $kelas['nama_kelas'];
            $subtitle = 'Periode: ' . format_tanggal($tanggal_awal) . ' - ' . format_tanggal($tanggal_akhir);
            
        } catch (PDOException $e) {
            echo 'Terjadi kesalahan: ' . $e->getMessage();
            exit;
        }
        break;
        
    case 'siswa':
        $siswa_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');
        
        if ($siswa_id <= 0) {
            echo 'ID siswa tidak valid';
            exit;
        }
        
        try {
            // Get siswa data
            $stmt = $pdo->prepare("
                SELECT s.*, k.nama_kelas 
                FROM siswa s
                JOIN kelas k ON s.kelas_id = k.id
                WHERE s.id = ?
            ");
            $stmt->execute([$siswa_id]);
            $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$siswa) {
                echo 'Siswa tidak ditemukan';
                exit;
            }
            
            // Get attendance data
            $stmt = $pdo->prepare("
                SELECT a.tanggal, a.status 
                FROM absensi a
                WHERE a.siswa_id = ? AND MONTH(a.tanggal) = ? AND YEAR(a.tanggal) = ? AND a.semester_id = ?
                ORDER BY a.tanggal DESC
            ");
            $stmt->execute([$siswa_id, $bulan, $tahun, ACTIVE_SEMESTER_ID]);
            $attendance_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Get attendance statistics
            $stmt = $pdo->prepare("
                SELECT 
                    status,
                    COUNT(*) as total
                FROM absensi 
                WHERE siswa_id = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND semester_id = ?
                GROUP BY status
            ");
            $stmt->execute([$siswa_id, $bulan, $tahun, ACTIVE_SEMESTER_ID]);
            $attendance_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Prepare statistics array
            $stats = [
                'Hadir' => 0,
                'Sakit' => 0,
                'Izin' => 0,
                'Alfa' => 0,
                'Terlambat' => 0
            ];
            
            foreach ($attendance_stats as $stat) {
                $stats[$stat['status']] = $stat['total'];
            }
            
            $title = 'Rekapitulasi Absensi Siswa';
            $subtitle = $siswa['nama'] . ' - ' . $siswa['nama_kelas'] . ' (' . date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) . ')';
            
        } catch (PDOException $e) {
            echo 'Terjadi kesalahan: ' . $e->getMessage();
            exit;
        }
        break;
        
    case 'rekap_kelas':
        $kelas_id = isset($_GET['kelas_id']) ? (int)$_GET['kelas_id'] : 0;
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');
        
        if ($kelas_id <= 0) {
            echo 'ID kelas tidak valid';
            exit;
        }
        
        try {
            // Get kelas info
            $stmt = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
            $stmt->execute([$kelas_id]);
            $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$kelas) {
                echo 'Kelas tidak ditemukan';
                exit;
            }
            
            // Get all siswa in this class
            $stmt = $pdo->prepare("
                SELECT s.id, s.nis, s.nisn, s.nama, s.jenis_kelamin
                FROM siswa s
                WHERE s.kelas_id = ?
                ORDER BY s.nama
            ");
            $stmt->execute([$kelas_id]);
            $siswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Get attendance data for each student
            foreach ($siswa_list as $siswa) {
                $stmt = $pdo->prepare("
                    SELECT 
                        status,
                        COUNT(*) as total
                    FROM absensi 
                    WHERE siswa_id = ? AND MONTH(tanggal) = ? AND YEAR(tanggal) = ? AND semester_id = ?
                    GROUP BY status
                ");
                $stmt->execute([$siswa['id'], $bulan, $tahun, ACTIVE_SEMESTER_ID]);
                $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Initialize student stats
                $student_stats = [
                    'Hadir' => 0,
                    'Sakit' => 0,
                    'Izin' => 0,
                    'Alfa' => 0,
                    'Terlambat' => 0
                ];
                
                // Fill student stats
                foreach ($attendance_data as $data) {
                    $student_stats[$data['status']] = $data['total'];
                }
                
                // Calculate total attendance and percentage
                $total_attendance = array_sum($student_stats);
                $persentase_hadir = $total_attendance > 0 ? round(($student_stats['Hadir'] / $total_attendance) * 100, 2) : 0;
                
                // Add to data
                $data[] = [
                    'siswa' => $siswa,
                    'stats' => $student_stats,
                    'total' => $total_attendance,
                    'persentase_hadir' => $persentase_hadir
                ];
            }
            
            $title = 'Rekapitulasi Absensi Kelas: ' . $kelas['nama_kelas'];
            $subtitle = 'Periode: ' . date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun));
            
        } catch (PDOException $e) {
            echo 'Terjadi kesalahan: ' . $e->getMessage();
            exit;
        }
        break;
        
    default:
        echo 'Tipe laporan tidak valid';
        exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: normal;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .print-only {
            display: block;
        }
        .no-print {
            display: none;
        }
        @media print {
            body {
                padding: 10px;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISTEM INFORMASI ABSENSI SISWA</h1>
        <h2><?php echo $title; ?></h2>
        <p><?php echo $subtitle; ?></p>
        <p>Periode Aktif: <?php echo ACTIVE_PERIOD_TEXT; ?></p>
    </div>
    
    <?php if ($type === 'siswa'): ?>
    <!-- Student Info -->
    <table>
        <tr>
            <td width="150"><strong>Nama</strong></td>
            <td width="10">:</td>
            <td><?php echo $siswa['nama']; ?></td>
        </tr>
        <tr>
            <td><strong>NIS</strong></td>
            <td>:</td>
            <td><?php echo $siswa['nis']; ?></td>
        </tr>
        <tr>
            <td><strong>NISN</strong></td>
            <td>:</td>
            <td><?php echo $siswa['nisn']; ?></td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>:</td>
            <td><?php echo $siswa['nama_kelas']; ?></td>
        </tr>
        <tr>
            <td><strong>Jenis Kelamin</strong></td>
            <td>:</td>
            <td><?php echo $siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
        </tr>
    </table>
    
    <!-- Statistics -->
    <table>
        <tr>
            <th colspan="2" class="text-center">Statistik Kehadiran</th>
        </tr>
        <tr>
            <td width="150">Hadir</td>
            <td><?php echo $stats['Hadir']; ?></td>
        </tr>
        <tr>
            <td>Sakit</td>
            <td><?php echo $stats['Sakit']; ?></td>
        </tr>
        <tr>
            <td>Izin</td>
            <td><?php echo $stats['Izin']; ?></td>
        </tr>
        <tr>
            <td>Alfa</td>
            <td><?php echo $stats['Alfa']; ?></td>
        </tr>
        <tr>
            <td>Terlambat</td>
            <td><?php echo $stats['Terlambat']; ?></td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong><?php echo array_sum($stats); ?></strong></td>
        </tr>
    </table>
    
    <!-- Attendance Table -->
    <table>
        <tr>
            <th class="text-center">No</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
        <?php if (empty($attendance_list)): ?>
        <tr>
            <td colspan="3" class="text-center">Tidak ada data absensi untuk periode ini</td>
        </tr>
        <?php else: ?>
        <?php $no = 1; ?>
        <?php foreach ($attendance_list as $attendance): ?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><?php echo format_tanggal($attendance['tanggal']); ?></td>
            <td><?php echo $attendance['status']; ?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <?php else: ?>
    <!-- Class Recap Table -->
    <table>
        <tr>
            <th class="text-center">No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th class="text-center">Jenis Kelamin</th>
            <th class="text-center">Hadir</th>
            <th class="text-center">Sakit</th>
            <th class="text-center">Izin</th>
            <th class="text-center">Alfa</th>
            <th class="text-center">Terlambat</th>
            <th class="text-center">Total</th>
            <th class="text-center">% Hadir</th>
        </tr>
        <?php if (empty($data)): ?>
        <tr>
            <td colspan="11" class="text-center">Tidak ada data</td>
        </tr>
        <?php else: ?>
        <?php $no = 1; ?>
        <?php foreach ($data as $item): ?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><?php echo $item['siswa']['nis']; ?></td>
            <td><?php echo $item['siswa']['nama']; ?></td>
            <td class="text-center"><?php echo $item['siswa']['jenis_kelamin'] == 'L' ? 'L' : 'P'; ?></td>
            <td class="text-center"><?php echo $item['stats']['Hadir']; ?></td>
            <td class="text-center"><?php echo $item['stats']['Sakit']; ?></td>
            <td class="text-center"><?php echo $item['stats']['Izin']; ?></td>
            <td class="text-center"><?php echo $item['stats']['Alfa']; ?></td>
            <td class="text-center"><?php echo $item['stats']['Terlambat']; ?></td>
            <td class="text-center"><?php echo $item['total']; ?></td>
            <td class="text-center"><?php echo $item['persentase_hadir']; ?>%</td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <?php endif; ?>
    
    <div class="footer">
        <p>Dicetak pada: <?php echo date('d F Y H:i:s'); ?></p>
        <p>&copy; <?php echo date('Y'); ?> Sistem Informasi Absensi Siswa</p>
    </div>
    
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary">Cetak</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>
</body>
</html>
```

## Penjelasan Singkat Setiap File

1. **database.sql**: File SQL untuk membuat struktur database dan mengisi data awal.
2. **config.php**: File konfigurasi utama yang mengatur koneksi database, session, dan fungsi-fungsi global.
3. **includes/functions.php**: Kumpulan fungsi bantu untuk aplikasi.
4. **includes/header.php**: Template header yang digunakan di semua halaman.
5. **includes/footer.php**: Template footer yang digunakan di semua halaman.
6. **login.php**: Halaman login untuk autentikasi pengguna.
7. **proses_login.php**: Proses autentikasi login.
8. **logout.php**: Proses logout pengguna.
9. **index.php**: Halaman utama yang mengarah ke dashboard jika sudah login.
10. **dashboard/index.php**: Halaman dashboard dengan statistik.
11. **tahun_ajaran/index.php**: Halaman manajemen tahun ajaran.
12. **tahun_ajaran/tambah.php**: Form tambah tahun ajaran.
13. **tahun_ajaran/aktifkan.php**: Proses aktivasi tahun ajaran.
14. **semester/index.php**: Halaman manajemen semester.
15. **semester/tambah.php**: Form tambah semester.
16. **semester/aktifkan.php**: Proses aktivasi semester.
17. **kelas/index.php**: Halaman manajemen kelas.
18. **kelas/tambah.php**: Form tambah kelas.
19. **kelas/edit.php**: Form edit kelas.
20. **kelas/hapus.php**: Proses hapus kelas.
21. **kelas/import.php**: Form dan proses import kelas dari CSV.
22. **kelas/template_kelas.csv**: Template CSV untuk import kelas.
23. **siswa/index.php**: Halaman manajemen siswa.
24. **siswa/tambah.php**: Form tambah siswa.
25. **siswa/edit.php**: Form edit siswa.
26. **siswa/hapus.php**: Proses hapus siswa.
27. **siswa/import.php**: Form dan proses import siswa dari CSV.
28. **siswa/export.php**: Proses export data siswa ke CSV.
29. **siswa/template_siswa.csv**: Template CSV untuk import siswa.
30. **absen/index.php**: Form input absensi harian.
31. **absen/get_siswa.php**: Endpoint AJAX untuk mengambil daftar siswa per kelas.
32. **absen/proses.php**: Proses simpan/update data absensi.
33. **absen/absensi_persiswa.php**: Halaman untuk melihat/mengedit absensi per siswa.
34. **rekap/kelas.php**: Laporan rekap per kelas dengan grafik.
35. **rekap/siswa.php**: Laporan rekap per siswa.
36. **rekap/cetak.php**: Halaman cetak yang print-friendly.

Aplikasi ini telah dirancang dengan fitur-fitur lengkap sesuai dengan spesifikasi yang Anda berikan, termasuk manajemen pengguna dengan role-based access control, manajemen tahun ajaran dan semester, manajemen kelas dan siswa, input absensi harian dengan AJAX, dan rekapitulasi laporan yang komprehensif dengan grafik. Semua fitur keamanan seperti prepared statements, password hashing, dan pencegahan XSS telah diimplementasikan.