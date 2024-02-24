<?php
switch ($route) {
    case 'home':
        $controller = new App\Controllers\HomeController($db);
        $controller->index();
        break;
    case 'post':
        $controller = new App\Controllers\PostsController($db);
        $controller->show($_GET['slug'] ?? null);
        break;
    case 'login':
        $controller = new App\Controllers\AuthController($db);
        $controller->index();
        break;
    case 'logout':
        $controller = new App\Controllers\AuthController($db);
        $controller->logout();
        break;

        // init Admin
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
    case 'admin/users/action':
        $authMiddleware->handle();
        $controller = new App\Controllers\UsersController($db);
        $controller->action($_GET['id'] ?? null);
        break;
    case 'admin/posts':
        $authMiddleware->handle();
        $controller = new App\Controllers\PostsController($db);
        $controller->index($_GET['edit'] ?? null, $_GET['del'] ?? null);
        break;
    case 'admin/posts/action':
        $authMiddleware->handle();
        $controller = new App\Controllers\PostsController($db);
        $controller->action($_GET['id'] ?? null);
        break;
    case 'admin/posts/ajax':
        $authMiddleware->handle();
        $controller = new App\Controllers\PostsController($db);
        $controller->ajax();
        break;
        // end admin

    default:
        // Rota padrão ou manipulador de erro
        $controller = new App\Controllers\ErrorController();
        $controller->index();
        break;
}
