<?php

namespace App\Controllers;

use App\Models\BackupModel;

class BackupsController extends BaseController
{
    private $BackupModel;
    public $title = "Backups";
    public $page = "backups";
    protected $db;

    public function __construct($db, $config)
    {
        parent::__construct();
        $this->BackupModel = new BackupModel($db, $config);
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
        
        $list = $this->BackupModel->getAll();

        ob_start();
        include __DIR__ . '/../views/admin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';

        $this->cleanAlert();
    }

    /**
     * view action
     */
    public function action($request = "", $del = "")
    {
        // register
        if (!empty($request)) {
            if (!$this->hasPermission($this->getUser($this->db), "register")) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Você não tem permissão de acesso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            $nameFile = date('y-m-d-H-i-s') . rand(99, 999) . '.sql';
            $params = [
                "path" => $this->pathBackups . $nameFile
            ];

            if ($this->BackupModel->createDump($params['path'])) {
                $this->BackupModel->set($params);

                $_SESSION['alert'] = [
                    "status"    => true,
                    "message"   => "Backup gerado com sucesso!",
                    "class"     => "success"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            } else {
                $_SESSION['alert'] = [
                    "status"    => true,
                    "message"   => "Erro ao gerar backup!",
                    "class"     => "danger"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }
        }

        if (!empty($del)) {
            if (!$this->hasPermission($this->getUser($this->db), "destroy")) {
                $_SESSION['alert'] = [
                    "status"    => false,
                    "message"   => "Você não tem permissão de acesso!",
                    "class"     => "warning"
                ];
                header('Location: ' . BASE . 'admin/' . $this->page);
                exit;
            }

            $find = $this->BackupModel->find($del);
            var_dump($find);

            if (file_exists($find['path'])) {
                unlink($find['path']);
            }

            $this->BackupModel->destroy($del);

            $_SESSION['alert'] = [
                "status"    => true,
                "message"   => "Deletado com sucesso!",
                "class"     => "success"
            ];
            header('Location: ' . BASE . 'admin/' . $this->page);
            exit;
        }
    }
}
