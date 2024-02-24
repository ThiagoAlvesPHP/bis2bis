<?php

namespace App\Controllers;

use App\Models\UserModel;

class UsersController extends BaseController
{
    private $UserModel;
    public $title = "Usuários";
    public $page = "users";

    public function __construct($db)
    {
        parent::__construct();
        $this->UserModel = new UserModel($db);
    }

    public function index()
    {
        $list = $this->UserModel->getAll();
        ob_start();
        include __DIR__ . '/../views/admin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';

        $this->cleanAlert();
    }

    /**
     * view action
     */
    public function action($id = "")
    {
        if (!empty($id)) {
            if (!empty($this->post['password'])) {
                $this->post['password'] = md5($this->post['password']);
            }
            $this->post['id'] = $id;

            if ($this->UserModel->getEmail($this->post['email'], $id)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "E-mail já esta em uso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/users');
                exit;
            }

            $params = array_filter($this->post);
            $params['is_active'] = (isset($this->post['is_active'])) ? 1 : 0;

            $this->UserModel->update($params);
            $_SESSION['alert'] = [
                "status"    => false,
                "message"   => "Atualizado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/users');
            exit;
        } else {
            if ($this->UserModel->getEmail($this->post['email'], null)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "E-mail já esta em uso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/users');
                exit;
            }

            $this->post['password'] = md5($this->post['password']);
            $this->UserModel->set($this->post);
            $_SESSION['alert'] = [
                "status"    => false,
                "message"   => "Registrado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/users');
            exit;
        }
    }
}
