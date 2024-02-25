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
    public function index($name_category = "", $search = "")
    {
        $categories = $this->CategoryModel->getAll();
        $indice_category = array_search($name_category, array_column($categories, 'name'));
        $postRand = $this->PostModel->getRand();

        if (!$name_category && !$search) {
            $posts = $this->PostModel->getAll(4);
        }
        if ($name_category) {
            $posts = $this->PostModel->getAll(4, $categories[$indice_category]['id']);
        }

        if ($search) {
            $posts = $this->PostModel->getAll(4, null, $search);
        }

        ob_start();
        include __DIR__ . '/../views/home.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
