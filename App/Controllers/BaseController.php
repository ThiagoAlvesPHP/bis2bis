<?php

namespace App\Controllers;

class BaseController
{
    protected $post;
    protected $get;
    protected $typeImages;
    protected $pathImagePost;
    protected $pathBackups;

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
}
