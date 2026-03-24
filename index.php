<?php
/**
 * Universal Team ERP
 * Main Entry Point & Router
 */

// Start session
session_start();

// Define paths
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}
if (!defined('APP_PATH')) {
    define('APP_PATH', BASE_PATH . '/app');
}

// Load configuration
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/config/constants.php';

// Load base classes
require_once APP_PATH . '/Controller.php';
require_once APP_PATH . '/Model.php';

// Load routes
$routes = require_once BASE_PATH . '/routes/web.php';

// Get requested route
$route = $_GET['route'] ?? '';

// Default route is dashboard
if (empty($route)) {
    $route = '';
}

// Find matching route
$found = false;
foreach ($routes as $pattern => $handler) {
    if ($pattern === $route || ($route === '' && $pattern === '/')) {
        $found = true;
        $controller_name = $handler['controller'];
        $method_name = $handler['method'];
        $is_protected = $handler['protected'] ?? true;
        
        // Check if route requires authentication
        if ($is_protected && !isset($_SESSION['user_id'])) {
            header('Location: /furniture_erp/?route=login');
            exit;
        }
        
        break;
    }
}

// If route not found, show 404
if (!$found) {
    http_response_code(404);
    require_once APP_PATH . '/views/layout/header.php';
    echo '<div class="container mt-5"><h1>404 - Page Not Found</h1><p>The route "' . htmlspecialchars($route) . '" does not exist.</p></div>';
    require_once APP_PATH . '/views/layout/footer.php';
    exit;
}

// Check if controller file exists
$controller_file = APP_PATH . '/controllers/' . $controller_name . '.php';

// If controller doesn't exist, show helpful message
if (!file_exists($controller_file)) {
    require_once APP_PATH . '/views/layout/header.php';
    ?>
    <div class="container mt-5">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">⚠️ Controller Not Found</h4>
            <p>Controller: <strong><?php echo htmlspecialchars($controller_name); ?></strong></p>
            <p>Route: <strong><?php echo htmlspecialchars($route ?: 'dashboard'); ?></strong></p>
            <hr>
            <p class="mb-0">This controller will be created in the next phase.</p>
        </div>
    </div>
    <?php
    require_once APP_PATH . '/views/layout/footer.php';
    exit;
}

// Load and instantiate controller
require_once $controller_file;
$controller = new $controller_name();

// Check if method exists
if (!method_exists($controller, $method_name)) {
    http_response_code(404);
    require_once APP_PATH . '/views/layout/header.php';
    echo '<div class="container mt-5"><h1>Error</h1><p>Method "' . htmlspecialchars($method_name) . '" not found in ' . htmlspecialchars($controller_name) . '.</p></div>';
    require_once APP_PATH . '/views/layout/footer.php';
    exit;
}

// Call controller method
$controller->$method_name();
?>
