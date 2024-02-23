<?php

namespace App\Controllers;

class BaseController
{
    protected $post;
    protected $get;

    public function __construct()
    {
        $this->post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
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
