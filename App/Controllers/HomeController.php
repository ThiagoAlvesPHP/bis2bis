<?php
namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;

class HomeController
{
    private $PostModel;
    private $UserModel;
    public $title = "Página Inicial";

    public function __construct($db)
    {
        $this->PostModel = new PostModel($db);
        $this->UserModel = new UserModel($db);
    }

    /**
     * view home
     */
    public function index()
    {
        ob_start();
        include __DIR__ . '/../views/home.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
