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

$authMiddleware = new App\Middleware\AuthMiddleware($db);
$authMiddleware->getUser();

include './routes.php';
