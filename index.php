<?php
include './settings.php';

// Autoload para carregar automaticamente as classes
spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . "/{$class}.php";
    if (file_exists($file)) {
        include $file;
    }
});

// Roteamento
$route = $_GET['url'] ?? 'home';
$controller = null;

$authMiddleware = new App\Middleware\AuthMiddleware();

switch ($route) {
    case 'home':
        $controller = new App\Controllers\HomeController($db);
        $controller->index();
        break;
    case 'post':
        $controller = new App\Controllers\PostController($db);
        $controller->show($_GET['post_id'] ?? null);
        break;
    case 'admin':
        $authMiddleware->handle();
        $controller = new App\Controllers\AdminController($db);
        $controller->index();
        break;
    case 'login':
        $controller = new App\Controllers\AuthController($db);
        $controller->index();
        break;
    case 'logout':
        $controller = new App\Controllers\AuthController($db);
        $controller->logout();
        break;
    default:
        // Rota padrão ou manipulador de erro
        $controller = new App\Controllers\ErrorController();
        $controller->index();
        break;
}
