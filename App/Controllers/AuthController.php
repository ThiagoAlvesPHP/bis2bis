<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    private $UserModel;
    public $title = "Login";

    public function __construct($db)
    {
        parent::__construct();
        $this->UserModel = new UserModel($db);
    }

    /***
     * view login
     */
    public function index()
    {
        if (!empty($this->post)) {
            $data = $this->auth($this->post);
            $_SESSION['alert'] = $data;
            header('Location: ' . BASE . 'login');
            exit;
        }

        ob_start();
        include __DIR__ . '/../views/login.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';

        $this->cleanAlert();
    }

    /**
     * helper login
     * @param array $creds
     */
    public function auth($creds)
    {
        if (isset($creds['email']) && empty($creds['email'])) {
            return [
                "status"    => false,
                "message"   => "E-mail precisa ser preenchido!",
                "class"     => "danger"
            ];
        }

        if (isset($creds['password']) && empty($creds['password'])) {
            return [
                "status"    => false,
                "message"   => "Senha precisa ser preenchida!",
                "class"     => "danger"
            ];
        }

        return $this->UserModel->auth($creds);
    }

    /**
     * view logout
     */
    public function logout()
    {
        if (!empty($_SESSION['user'])) {
            unset($_SESSION['user']);
            header('Location: ' . BASE);
            exit;
        }
    }
}
