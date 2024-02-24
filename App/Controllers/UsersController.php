<?php

namespace App\Controllers;

class UsersController
{
    public $title = "Usuários";
    public $page = "users";

    public function index()
    {
        ob_start();
        include __DIR__ . '/../views/admin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
