<?php

namespace App\Middleware;

use App\Models\UserModel;
use const BASE;

class AuthMiddleware
{
    private $UserModel;

    public function __construct($db)
    {
        $this->UserModel = new UserModel($db);
    }

    public function handle()
    {
        // verifica se usuario esta logado
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE . "login");
            exit;
        }

        // verifica o tipo de usuario
        if (!empty($_SESSION['user_data']) && !$_SESSION['user_data']['master']) {
            header("Location: " . BASE);
            exit;
        }
    }

    public function handleVisitor()
    {
        // verifica se usuario esta logado
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE . "login");
            exit;
        }
    }

    /**
     * get user
     */
    public function getUser()
    {
        $_SESSION['user_data'] = (!empty($_SESSION['user'])) ? $this->UserModel->find($_SESSION['user']) : false;
    }
}
