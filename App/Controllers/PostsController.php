<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\UserModel;

class PostsController extends BaseController
{
    private $CategoryModel;
    private $PostModel;
    private $UserModel;
    public $title = "Posts";
    public $page = "posts";

    public function __construct($db)
    {
        parent::__construct();
        $this->CategoryModel = new CategoryModel($db);
        $this->PostModel = new PostModel($db);
        $this->UserModel = new UserModel($db);
    }

    /**
     * view post site
     */
    public function show($slug)
    {
        $find = $this->PostModel->findBySlug($slug);
        $this->title = $find['title'];
        
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
        $categories = $this->CategoryModel->getAll();

        if (!empty($del)) {
            $find = (!empty($del)) ? $this->PostModel->find($del) : false;
            if (empty($find)) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Nenhum post encontrado!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            if (file_exists($find['image'])) {
                unlink($find['image']);
            }
            $this->PostModel->destroy($del);
            $_SESSION['alert'] = [
                "status"    => false,
                "message"   => "Post deletado!",
                "class"     => "danger"
            ];
            header('Location: ' . BASE . 'admin/' . $this->page);
            exit;
        }

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
                    "message"   => "Nenhum post encontrado!",
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

            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                if (file_exists($find['image'])) {
                    unlink($find['image']);
                }
                move_uploaded_file($_FILES['image']['tmp_name'], $this->post['image']);
            }

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
            array(3 => 'category_id'),
            array(4 => 'image'),
            array(5 => 'user_id'),
            array(6 => 'is_active'),
            array(7 => 'created_at'),
        );

        $sql = "SELECT p.*, u.name as name_user , c.name as name_category
            FROM " . $this->PostModel::TABLE . " as p
            LEFT JOIN " . $this->UserModel::TABLE . " as u
            ON p.user_id = u.id
            LEFT JOIN " . $this->CategoryModel::TABLE . " as c
            ON p.category_id = c.id
            WHERE 1=1 ";

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (p.id LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.title LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.slug LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR u.name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.is_active LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR c.name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.created_at LIKE '%" . $requestData['search']['value'] . "%' )";
        }

        $totalFiltered = count($this->PostModel->customSearch($sql));

        //Ordenar o resultado
        $sql .= " ORDER BY " . implode(' AND ', $columns[$requestData['order'][0]['column']]) . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
        $data = $this->PostModel->customSearch($sql);

        $items = array();

        foreach ($data as $value) {
            $item = array();
            $actions = '<a href="' . BASE . 'admin/posts?edit=' . $value['id'] . '" class="btn btn-info"><i class="far fa-edit"></i></a> | ';
            $actions .= '<a href="' . BASE . 'admin/posts?del=' . $value['id'] . '" class="btn btn-danger delete-post"><i class="fas fa-trash-alt"></i></a>';

            $item[] = $actions;
            $item[] = $value["title"];
            $item[] = $value["slug"];
            $item[] = $value["name_category"];
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
