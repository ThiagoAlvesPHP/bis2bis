<?php
switch ($route) {
    case 'home':
        $controller = new App\Controllers\HomeController($db);
        $controller->index($_GET['name_category'] ?? null, $_GET['search'] ?? null);
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
    case 'register':
        $controller = new App\Controllers\AuthController($db);
        $controller->index();
        break;
    case 'profile':
        $authMiddleware->handleVisitor();
        $controller = new App\Controllers\UsersController($db);
        $controller->show();
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
    case 'admin/categories':
        $authMiddleware->handle();
        $controller = new App\Controllers\CategoriesController($db);
        $controller->index();
        break;
    case 'admin/categories/action':
        $authMiddleware->handle();
        $controller = new App\Controllers\CategoriesController($db);
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
    case 'admin/backups':
        $authMiddleware->handle();
        $controller = new App\Controllers\BackupsController($db, $config);
        $controller->index();
        break;
    case 'admin/backups/action':
        $authMiddleware->handle();
        $controller = new App\Controllers\BackupsController($db, $config);
        $controller->action($_GET['request'] ?? null, $_GET['del'] ?? null);
        break;
        // end admin

    default:
        // Rota padrão ou manipulador de erro
        $controller = new App\Controllers\ErrorController();
        $controller->index();
        break;
}
