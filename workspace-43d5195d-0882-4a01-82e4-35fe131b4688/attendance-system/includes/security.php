<?php
// Security functions

/**
 * Hash password using bcrypt
 * @param string $password
 * @return string
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify password
 * @param string $password
 * @param string $hash
 * @return bool
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Generate CSRF token
 * @return string
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 * @param string $token
 * @return bool
 */
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize output
 * @param string $output
 * @return string
 */
function sanitizeOutput($output) {
    return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
}

/**
 * Prevent SQL Injection
 * @param PDO $db
 * @param string $value
 * @return string
 */
function preventSQLInjection($db, $value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    return $value;
}

/**
 * Validate input
 * @param string $input
 * @param string $type
 * @return bool
 */
function validateInput($input, $type = 'text') {
    switch ($type) {
        case 'email':
            return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
        case 'url':
            return filter_var($input, FILTER_VALIDATE_URL) !== false;
        case 'int':
            return filter_var($input, FILTER_VALIDATE_INT) !== false;
        case 'float':
            return filter_var($input, FILTER_VALIDATE_FLOAT) !== false;
        case 'alpha':
            return ctype_alpha($input);
        case 'alphanum':
            return ctype_alnum($input);
        case 'text':
        default:
            return !empty($input) && is_string($input);
    }
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if user has specific role
 * @param string $role
 * @return bool
 */
function hasRole($role) {
    if (!isLoggedIn()) {
        return false;
    }
    
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

/**
 * Check if user is admin
 * @return bool
 */
function isAdmin() {
    return hasRole('admin');
}

/**
 * Check if user is guru
 * @return bool
 */
function isGuru() {
    return hasRole('guru');
}

/**
 * Require authentication
 * @return void
 */
function requireAuth() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Anda harus login untuk mengakses halaman ini';
        redirect('/auth/login');
    }
}

/**
 * Require admin role
 * @return void
 */
function requireAdmin() {
    requireAuth();
    if (!isAdmin()) {
        $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini';
        redirect('/dashboard');
    }
}

/**
 * Require guru role
 * @return void
 */
function requireGuru() {
    requireAuth();
    if (!isGuru()) {
        $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini';
        redirect('/dashboard');
    }
}

/**
 * Set flash message
 * @param string $type
 * @param string $message
 * @return void
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get flash message
 * @return array|null
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Validate file upload
 * @param array $file
 * @param array $allowed_types
 * @param int $max_size
 * @return bool|string
 */
function validateFileUpload($file, $allowed_types = [], $max_size = 5242880) {
    // Check if file was uploaded
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return 'File upload failed';
    }
    
    // Check file size
    if ($file['size'] > $max_size) {
        return 'File is too large';
    }
    
    // Check file type
    if (!empty($allowed_types)) {
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $file['tmp_name']);
        finfo_close($file_info);
        
        if (!in_array($mime_type, $allowed_types)) {
            return 'File type not allowed';
        }
    }
    
    return true;
}

/**
 * Move uploaded file
 * @param array $file
 * @param string $destination
 * @return bool|string
 */
function moveUploadedFile($file, $destination) {
    if (!is_dir(dirname($destination))) {
        mkdir(dirname($destination), 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return true;
    }
    
    return 'Failed to move uploaded file';
}

/**
 * Generate secure filename
 * @param string $filename
 * @return string
 */
function generateSecureFilename($filename) {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    $basename = preg_replace('/[^a-zA-Z0-9]/', '', $basename);
    return $basename . '_' . time() . '.' . $extension;
}

/**
 * Check if request is AJAX
 * @return bool
 */
function isAJAXRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Send JSON response
 * @param mixed $data
 * @param int $status_code
 * @return void
 */
function sendJSONResponse($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Send error response
 * @param string $message
 * @param int $status_code
 * @return void
 */
function sendErrorResponse($message, $status_code = 400) {
    sendJSONResponse([
        'success' => false,
        'error' => $message
    ], $status_code);
}

/**
 * Send success response
 * @param mixed $data
 * @param string $message
 * @return void
 */
function sendSuccessResponse($data = null, $message = 'Success') {
    sendJSONResponse([
        'success' => true,
        'message' => $message,
        'data' => $data
    ]);
}

/**
 * Rate limiting
 * @param string $key
 * @param int $limit
 * @param int $window
 * @return bool
 */
function rateLimit($key, $limit = 5, $window = 3600) {
    if (!isset($_SESSION['rate_limits'])) {
        $_SESSION['rate_limits'] = [];
    }
    
    if (!isset($_SESSION['rate_limits'][$key])) {
        $_SESSION['rate_limits'][$key] = [
            'count' => 0,
            'reset_time' => time() + $window
        ];
    }
    
    $rate_limit = &$_SESSION['rate_limits'][$key];
    
    // Reset if window has passed
    if (time() > $rate_limit['reset_time']) {
        $rate_limit['count'] = 0;
        $rate_limit['reset_time'] = time() + $window;
    }
    
    if ($rate_limit['count'] >= $limit) {
        return false;
    }
    
    $rate_limit['count']++;
    return true;
}

/**
 * Check login attempts
 * @param string $username
 * @return bool
 */
function checkLoginAttempts($username) {
    $key = 'login_' . md5($username);
    return rateLimit($key, 5, 300); // 5 attempts in 5 minutes
}

/**
 * Clear login attempts
 * @param string $username
 * @return void
 */
function clearLoginAttempts($username) {
    $key = 'login_' . md5($username);
    if (isset($_SESSION['rate_limits'][$key])) {
        unset($_SESSION['rate_limits'][$key]);
    }
}

/**
 * Validate date format
 * @param string $date
 * @param string $format
 * @return bool
 */
function validateDateFormat($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Validate time format
 * @param string $time
 * @param string $format
 * @return bool
 */
function validateTimeFormat($time, $format = 'H:i') {
    $d = DateTime::createFromFormat($format, $time);
    return $d && $d->format($format) === $time;
}

/**
 * XSS Protection
 * @param string $string
 * @return string
 */
function xssProtection($string) {
    return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Sanitize array
 * @param array $array
 * @return array
 */
function sanitizeArray($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = sanitizeArray($value);
        } else {
            $array[$key] = sanitizeInput($value);
        }
    }
    return $array;
}

/**
 * Get current URL
 * @return string
 */
function getCurrentURL() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    return $protocol . '://' . $host . $uri;
}

/**
 * Check HTTPS
 * @return bool
 */
function isHTTPS() {
    return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
}

/**
 * Force HTTPS
 * @return void
 */
function forceHTTPS() {
    if (!isHTTPS()) {
        $https_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: ' . $https_url);
        exit;
    }
}

/**
 * Security headers
 * @return void
 */
function securityHeaders() {
    // Prevent Clickjacking
    header('X-Frame-Options: SAMEORIGIN');
    
    // Prevent MIME-type sniffing
    header('X-Content-Type-Options: nosniff');
    
    // Prevent XSS
    header('X-XSS-Protection: 1; mode=block');
    
    // Content Security Policy (basic)
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self';");
    
    // Referrer Policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // Remove PHP version
    header('X-Powered-By: PHP');
}
?>