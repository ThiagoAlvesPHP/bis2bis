<?php

namespace App\Controllers;

use App\Models\MenusModel;
use App\Models\PermissionsModel;
use App\Models\UserModel;

class UsersController extends BaseController
{
    private $MenusModel;
    private $PermissionsModel;
    private $UserModel;
    public $title = "Usuários";
    public $page = "users";
    protected $db;

    public function __construct($db)
    {
        parent::__construct();
        $this->MenusModel = new MenusModel($db);
        $this->PermissionsModel = new PermissionsModel($db);
        $this->UserModel = new UserModel($db);
        $this->db = $db;
    }

    /**
     * show
     */
    public function show()
    {
        $this->title = "Perfil";
        $find = $this->UserModel->find($_SESSION['user']);

        if (!empty($this->post['name'])) {
            $this->post['id'] = $_SESSION['user'];
            if (!empty($this->post['password'])) {
                $this->post['password'] = md5($this->post['password']);
            }

            $params = array_filter($this->post);

            $this->UserModel->update($params);
            $_SESSION['alert'] = [
                "status"    => false,
                "message"   => "Atualizado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'profile');
            exit;
        }

        ob_start();
        include __DIR__ . '/../views/user.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';

        $this->cleanAlert();
    }

    /**
     * view admin user
     */
    public function index()
    {
        if (!$this->hasPermission($this->getUser($this->db), "view")) {
            $_SESSION['alert'] = [
                "status"    => false,
                "message"   => "Você não tem permissão de acesso!",
                "class"     => "warning"
            ];
            header('Location: ' . BASE . 'admin');
            exit;
        }

        $list = $this->UserModel->getAll();
        $menus = $this->MenusModel->getAll();

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
        // update
        if (!empty($id)) {
            if (!$this->hasPermission($this->getUser($this->db), "edit")) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Você não tem permissão de acesso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            if (!empty($this->post['password'])) {
                $this->post['password'] = md5($this->post['password']);
            }
            $this->post['id'] = $id;

            if ($this->UserModel->hasEmail($this->post['email'], $id)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "E-mail já esta em uso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            $params = array_filter($this->post);
            $params['is_active'] = (isset($this->post['is_active'])) ? 1 : 0;
            unset($params['permissions']);

            $this->PermissionsModel->destroy($id);

            if (!empty($this->post['permissions'])) {
                foreach ($this->post['permissions'] as $menu_id) {
                    $this->PermissionsModel->set([
                        "user_id"   => $id,
                        "menu_id"   => $menu_id
                    ]);
                }
            }

            $this->UserModel->update($params);
            $_SESSION['alert'] = [
                "status"    => false,
                "message"   => "Atualizado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/' . $this->page);
            exit;
        }

        // register
        else {
            if (!$this->hasPermission($this->getUser($this->db), "register")) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Você não tem permissão de acesso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            if ($this->UserModel->hasEmail($this->post['email'], null)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "E-mail já esta em uso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            $this->post['password'] = md5($this->post['password']);
            $params = [
                "name"      => $this->post['name'],
                "email"     => $this->post['email'],
                "password"  => $this->post['password']
            ];

            $user_id = $this->UserModel->set($params);

            if (!empty($this->post['permissions'])) {
                foreach ($this->post['permissions'] as $menu_id) {
                    $this->PermissionsModel->set([
                        "user_id"   => $user_id,
                        "menu_id"   => $menu_id
                    ]);
                }
            }

            $_SESSION['alert'] = [
                "status"    => false,
                "message"   => "Registrado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/' . $this->page);
            exit;
        }
    }
}
