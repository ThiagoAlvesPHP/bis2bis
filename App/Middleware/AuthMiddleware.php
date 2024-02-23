<?php

namespace App\Middleware;

use const BASE;

class AuthMiddleware
{
    public function handle()
    {
        // Verificar se o usuário está autenticado
        if (!isset($_SESSION['user'])) {
            // Redirecionar para a página de login ou executar ação adequada
            header("Location: " . BASE . "login");
            exit;
        }
    }
}
