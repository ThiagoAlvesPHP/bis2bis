<?php

namespace App\Controllers;

class AdminController
{
    public $title = "Dashboard";
    public $page = "dashboard";

    public function index()
    {
        ob_start();
        include __DIR__ . '/../views/admin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
