<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class CategoriesController extends BaseController
{
    private $CategoryModel;
    public $title = "Categorias";
    public $page = "categories";
    protected $db;

    public function __construct($db)
    {
        parent::__construct();
        $this->CategoryModel = new CategoryModel($db);
        $this->db = $db;
    }

    /**
     * view post admin
     */
    public function index($edit = "", $del = "")
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

        $list = $this->CategoryModel->getAll();

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

            $find = $this->CategoryModel->find($id);
            $this->post['id'] = $id;

            if (empty($find)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Nenhuma categoria encontrado!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            $this->CategoryModel->update($this->post);
            $_SESSION['alert'] = [
                "status"    => true,
                "message"   => "Registrado com sucesso!",
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

            $this->CategoryModel->set($this->post);
            $_SESSION['alert'] = [
                "status"    => true,
                "message"   => "Registrado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/' . $this->page);
            exit;
        }
    }
}
