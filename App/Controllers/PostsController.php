<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;

class PostsController extends BaseController
{
    private $PostModel;
    private $UserModel;
    public $title = "Posts";
    public $page = "posts";

    public function __construct($db)
    {
        parent::__construct();
        $this->PostModel = new PostModel($db);
        $this->UserModel = new UserModel($db);
    }

    /**
     * view post site
     */
    public function show($postId)
    {
        ob_start();
        include __DIR__ . '/../views/post.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }

    /**
     * view post admin
     */
    public function index($edit = "", $del = "")
    {
        $find = (!empty($edit)) ? $this->PostModel->find($edit) : false;

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
            $find = $this->PostModel->find($id);
            $this->post['id'] = $id;

            if (empty($find)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Nenhum post encotrado!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page . "?edit=" . $id);
                exit;
            }

            if ($this->PostModel->hasSlug($this->post['slug'], $id)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Slug já esta em uso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page . "?edit=" . $id);
                exit;
            }

            echo "<pre>";

            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                if (!in_array($_FILES['image']['type'], $this->typeImages)) {
                    $_SESSION['alert'] = [
                        "status"    => false,
                        "message"   => "Formato de imagem inválido!",
                        "class"     => "warning"
                    ];
                    header('Location: ' . BASE . 'admin/' . $this->page . "?edit=" . $id);
                    exit;
                }

                $extension = explode("/", $this->typeImages[array_search($_FILES['image']['type'], $this->typeImages)])[1];
                $this->post['image'] = $this->pathImagePost . md5($_FILES['image']['tmp_name'] . time() . rand(0, 999)) . '.' . $extension;
            }

            if (file_exists($find['image'])) {
                unlink($find['image']);
            }

            move_uploaded_file($_FILES['image']['tmp_name'], $this->post['image']);

            $this->PostModel->update($this->post);
            $_SESSION['alert'] = [
                "status"    => true,
                "message"   => "Registrado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/' . $this->page);
            exit;
        } else {
            if (empty($_FILES['image'])) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Envio de imagem obrigatório!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }
            if ($this->PostModel->hasSlug($this->post['slug'], null)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Slug já esta em uso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }
            if (!in_array($_FILES['image']['type'], $this->typeImages)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Formato de imagem inválido!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }
            $this->post['user_id'] = $_SESSION['user'];

            $extension = explode("/", $this->typeImages[array_search($_FILES['image']['type'], $this->typeImages)])[1];
            $this->post['image'] = $this->pathImagePost . md5($_FILES['image']['tmp_name'] . time() . rand(0, 999)) . '.' . $extension;
            move_uploaded_file($_FILES['image']['tmp_name'], $this->post['image']);
            $this->PostModel->set($this->post);
            $_SESSION['alert'] = [
                "status"    => true,
                "message"   => "Registrado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/' . $this->page);
            exit;
        }
    }

    /**
     * view ajax
     */
    public function ajax()
    {
        $count = count($this->PostModel->getAll());

        $requestData = $_REQUEST;

        $columns = array(
            array(0 => 'id'),
            array(1 => 'title'),
            array(2 => 'slug'),
            array(3 => 'image'),
            array(4 => 'user_id'),
            array(5 => 'is_active'),
            array(5 => 'created_at'),
        );

        $sql = "SELECT p.*, u.name as name_user 
        FROM " . $this->PostModel::TABLE . " as p
        LEFT JOIN " . $this->UserModel::TABLE . " as u
        ON p.user_id = u.id
        WHERE 1=1 ";

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (p.id LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.title LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.slug LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR u.name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.is_active LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.created_at LIKE '%" . $requestData['search']['value'] . "%' )";
        }

        $totalFiltered = count($this->PostModel->customSearch($sql));

        //Ordenar o resultado
        $sql .= " ORDER BY " . implode(' AND ', $columns[$requestData['order'][0]['column']]) . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
        $data = $this->PostModel->customSearch($sql);

        $items = array();

        foreach ($data as $value) {
            $item = array();
            $actions = '<a href="' . BASE . 'admin/posts?edit=' . $value['id'] . '" class="btn btn-info"><i class="far fa-edit"></i></a>';
            $item[] = $actions;
            $item[] = $value["title"];
            $item[] = $value["slug"];
            $item[] = '<img width="30" src="' . BASE . $value["image"] . '" class="rounded mx-auto d-block" alt="' . $value['title'] . '">';
            $item[] = $value["name_user"];
            $item[] = $value["is_active"] ? "Ativo" : "Inativo";
            $item[] = $value["created_at"];
            $items[] = $item;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($count),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $items
        );

        echo json_encode($json_data);
    }
}
