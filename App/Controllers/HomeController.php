<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\UserModel;

class HomeController
{
    private $CategoryModel;
    private $PostModel;
    private $UserModel;
    public $title = "Bis2Bis";

    public function __construct($db)
    {
        $this->CategoryModel = new CategoryModel($db);
        $this->PostModel = new PostModel($db);
        $this->UserModel = new UserModel($db);
    }

    /**
     * view home
     */
    public function index($name_category = "")
    {
        $categories = $this->CategoryModel->getAll();
        $indice_category = array_search($name_category, array_column($categories, 'name'));

        $posts = !$name_category ? $this->PostModel->getAll(4) : $this->PostModel->getAll(4, $categories[$indice_category]['id']);
        $postRand = $this->PostModel->getRand();



        ob_start();
        include __DIR__ . '/../views/home.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
