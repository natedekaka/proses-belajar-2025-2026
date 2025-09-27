<?php
// Helper functions

/**
 * Redirect to a specific URL
 * @param string $url
 */
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

/**
 * Format date to Indonesian format
 * @param string $date
 * @return string
 */
function formatTanggalIndo($date) {
    if ($date == null || $date == '') {
        return '-';
    }
    
    $bulan = array (
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    
    $split = explode('-', $date);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

/**
 * Format time to Indonesian format
 * @param string $time
 * @return string
 */
function formatJamIndo($time) {
    if ($time == null || $time == '') {
        return '-';
    }
    
    return date('H:i', strtotime($time));
}

/**
 * Get day name in Indonesian
 * @param string $day
 * @return string
 */
function getHariIndo($day) {
    $hari = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );
    
    return $hari[$day] ?? $day;
}

/**
 * Get status kehadiran in Indonesian
 * @param string $status
 * @return string
 */
function getStatusKehadiran($status) {
    $status_kehadiran = array(
        'hadir' => 'Hadir',
        'terlambat' => 'Terlambat',
        'tidak_hadir' => 'Tidak Hadir',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'cuti' => 'Cuti'
    );
    
    return $status_kehadiran[$status] ?? $status;
}

/**
 * Get status izin in Indonesian
 * @param string $status
 * @return string
 */
function getStatusIzin($status) {
    $status_izin = array(
        'pending' => 'Menunggu Persetujuan',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak'
    );
    
    return $status_izin[$status] ?? $status;
}

/**
 * Get jenis izin in Indonesian
 * @param string $jenis
 * @return string
 */
function getJenisIzin($jenis) {
    $jenis_izin = array(
        'dinas' => 'Izin Dinas',
        'pribadi' => 'Izin Pribadi',
        'sakit' => 'Sakit',
        'cuti' => 'Cuti'
    );
    
    return $jenis_izin[$jenis] ?? $jenis;
}

/**
 * Calculate late minutes
 * @param string $jadwal_mulai
 * @param string $waktu_masuk
 * @return int
 */
function hitungKeterlambatan($jadwal_mulai, $waktu_masuk) {
    $mulai = strtotime($jadwal_mulai);
    $masuk = strtotime($waktu_masuk);
    
    if ($masuk > $mulai) {
        $diff = $masuk - $mulai;
        return floor($diff / 60); // Return minutes
    }
    
    return 0;
}

/**
 * Check if today is holiday
 * @param string $date
 * @return bool
 */
function isHariLibur($date) {
    // Check Sunday
    if (date('N', strtotime($date)) == 7) {
        return true;
    }
    
    // Check national holidays (this should be stored in database)
    // For now, return false
    return false;
}

/**
 * Generate QR code data
 * @param int $guru_id
 * @param int $jadwal_id
 * @return string
 */
function generateQRData($guru_id, $jadwal_id) {
    $timestamp = time();
    $data = "guru_id:{$guru_id}|jadwal_id:{$jadwal_id}|timestamp:{$timestamp}";
    return base64_encode($data);
}

/**
 * Validate QR code data
 * @param string $qr_data
 * @return array|bool
 */
function validateQRData($qr_data) {
    $decoded = base64_decode($qr_data);
    $parts = explode('|', $decoded);
    
    if (count($parts) != 3) {
        return false;
    }
    
    $guru_id = explode(':', $parts[0])[1] ?? null;
    $jadwal_id = explode(':', $parts[1])[1] ?? null;
    $timestamp = explode(':', $parts[2])[1] ?? null;
    
    // Check if QR code is expired (5 minutes)
    if (time() - $timestamp > 300) {
        return false;
    }
    
    return [
        'guru_id' => $guru_id,
        'jadwal_id' => $jadwal_id,
        'timestamp' => $timestamp
    ];
}

/**
 * Create notification
 * @param int $user_id
 * @param string $message
 * @param string $type
 * @return bool
 */
function createNotification($user_id, $message, $type = 'info') {
    global $db;
    
    try {
        $stmt = $db->prepare("INSERT INTO notifications (user_id, message, type, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$user_id, $message, $type]);
        return true;
    } catch (PDOException $e) {
        error_log("Error creating notification: " . $e->getMessage());
        return false;
    }
}

/**
 * Send email notification
 * @param string $email
 * @param string $subject
 * @param string $message
 * @return bool
 */
function sendEmailNotification($email, $subject, $message) {
    // This is a placeholder for email functionality
    // In a real application, you would use PHPMailer or similar library
    error_log("Email notification to: $email, Subject: $subject, Message: $message");
    return true;
}

/**
 * Log user activity
 * @param int $user_id
 * @param string $action
 * @param string $description
 * @return bool
 */
function logActivity($user_id, $action, $description) {
    global $db;
    
    try {
        $stmt = $db->prepare("INSERT INTO activity_logs (user_id, action, description, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $user_id,
            $action,
            $description,
            $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Error logging activity: " . $e->getMessage());
        return false;
    }
}

/**
 * Get client IP address
 * @return string
 */
function getClientIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

/**
 * Sanitize input
 * @param string $input
 * @return string
 */
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

/**
 * Generate random token
 * @param int $length
 * @return string
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Format file size
 * @param int $bytes
 * @return string
 */
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return '1 byte';
    } else {
        return '0 bytes';
    }
}
?>