<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public $title = "Dashboard";
    public $page = "dashboard";

    public function __construct()
    {
        parent::__construct();
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
