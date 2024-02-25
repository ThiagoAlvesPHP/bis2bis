<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    private $UserModel;
    public $title = "Dashboard";
    public $page = "dashboard";
    public $countUsers = 0;
    public $countPosts = 0;

    public function __construct($db)
    {
        parent::__construct();
        $this->countUsers = count((new UserModel($db))->getAll());
        $this->countPosts = count((new PostModel($db))->getAll());
    }

    public function index()
    {
        ob_start();
        include __DIR__ . '/../views/admin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';

        $this->cleanAlert();
    }
}
