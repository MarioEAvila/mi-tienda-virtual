<?php
require_once '../config/config.php';

function loadController($controller) {
    $controller = ucfirst($controller) . 'Controller';
    $file = '../controllers/' . $controller . '.php';

    if (file_exists($file)) {
        require_once $file;
        return new $controller($GLOBALS['conexion']);
    } else {
        throw new Exception("Controller not found: " . $controller);
    }
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

try {
    if ($page === 'api') {
        require_once '../public/api.php';
    } else {
        $controller = loadController($page);

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            throw new Exception("Action not found: " . $action);
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
