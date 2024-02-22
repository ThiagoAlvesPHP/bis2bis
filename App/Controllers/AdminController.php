<?php
namespace App\Controllers;

class AdminController
{
    public function index()
    {
        // Lógica para a página administrativa
        $title = 'Página Administrativa';
        ob_start();
        include __DIR__ . '/../views/admin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
