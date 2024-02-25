<?php

namespace App\Controllers;

use App\Models\UserModel;

class BaseController
{
    protected $post;
    protected $get;
    protected $typeImages;
    protected $pathImagePost;
    protected $pathBackups;
    private $UserModel;

    public function __construct()
    {
        $this->post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $this->typeImages = [
            "image/png",
            "image/jpeg",
            "image/jpg"
        ];
        $this->pathImagePost = "App/web/images/posts/";
        $this->pathBackups = "App/web/backup/";
    }

    /**
     * clean cache alert session
     */
    public function cleanAlert()
    {
        if (!empty($_SESSION['alert'])) {
            unset($_SESSION['alert']);
        }
    }

    /**
     * data user logado
     */
    public function getUser($db)
    {
        $UserModel = new UserModel($db);
        return $UserModel->find($_SESSION['user']);
    }

    /**
     * hasPermission
     */
    public function hasPermission($data, $action)
    {
        $urlToCheck = $this->get['url'];

        foreach ($data['menus'] as $menu) {
            if ($menu['url'] == $urlToCheck && isset($menu['action']) && $menu['action'] == $action) {
                return true;
            }
        }

        return false;
    }
}
