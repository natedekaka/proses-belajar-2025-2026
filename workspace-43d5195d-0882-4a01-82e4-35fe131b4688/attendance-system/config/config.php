<?php
// Define root path
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CONTROLLER_PATH', ROOT_PATH . '/controllers');
define('MODEL_PATH', ROOT_PATH . '/models');
define('VIEW_PATH', ROOT_PATH . '/views');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Define URL base
define('BASE_URL', 'http://localhost/attendance-system');

// Database configuration
require_once CONFIG_PATH . '/database.php';

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload classes
spl_autoload_register(function ($class_name) {
    $paths = [
        MODEL_PATH . '/' . $class_name . '.php',
        CONTROLLER_PATH . '/' . $class_name . '.php',
        APP_PATH . '/' . $class_name . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Helper functions
require_once 'includes/helpers.php';

// Security functions
require_once 'includes/security.php';
?>