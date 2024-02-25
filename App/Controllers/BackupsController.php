<?php

namespace App\Controllers;

use App\Models\BackupModel;

class BackupsController extends BaseController
{
    private $BackupModel;
    public $title = "Backups";
    public $page = "backups";

    public function __construct($db, $config)
    {
        parent::__construct();
        $this->BackupModel = new BackupModel($db, $config);
    }

    /**
     * view post admin
     */
    public function index($edit = "", $del = "")
    {
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
        if (!empty($request)) {
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
