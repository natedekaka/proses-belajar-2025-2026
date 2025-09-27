<?php
require_once 'config/config.php';

// Set security headers
securityHeaders();

// Get the requested URL
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Route the request
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$methodName = isset($url[1]) ? $url[1] : 'index';
$param = isset($url[2]) ? $url[2] : null;

// Check if controller exists
$controllerFile = CONTROLLER_PATH . '/' . $controllerName . '.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Create controller instance
    $controller = new $controllerName();
    
    // Check if method exists
    if (method_exists($controller, $methodName)) {
        // Call method with or without parameter
        if ($param !== null) {
            $controller->$methodName($param);
        } else {
            $controller->$methodName();
        }
    } else {
        // Method not found
        http_response_code(404);
        $errorController = new ErrorController();
        $errorController->notFound();
    }
} else {
    // Controller not found
    http_response_code(404);
    $errorController = new ErrorController();
    $errorController->notFound();
}
?>