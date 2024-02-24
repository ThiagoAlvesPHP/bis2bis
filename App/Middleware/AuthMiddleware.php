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
        // Verificar se o usuário está autenticado
        if (!isset($_SESSION['user'])) {
            // Redirecionar para a página de login ou executar ação adequada
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
