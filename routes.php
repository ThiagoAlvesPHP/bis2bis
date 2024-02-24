<?php
switch ($route) {
    case 'home':
        $controller = new App\Controllers\HomeController($db);
        $controller->index();
        break;
    case 'post':
        $controller = new App\Controllers\PostsController($db);
        $controller->show($_GET['post_id'] ?? null);
        break;
    case 'admin':
        $authMiddleware->handle();
        $controller = new App\Controllers\AdminController($db);
        $controller->index();
        break;
    case 'admin/users':
        $authMiddleware->handle();
        $controller = new App\Controllers\UsersController($db);
        $controller->index();
        break;
    case 'admin/posts':
        $authMiddleware->handle();
        $controller = new App\Controllers\PostsController($db);
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
