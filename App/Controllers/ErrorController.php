<?php
namespace App\Controllers;

class ErrorController
{
    public function index()
    {
        $title = 'Erro 404';
        ob_start();
        include __DIR__ . '/../views/404.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
