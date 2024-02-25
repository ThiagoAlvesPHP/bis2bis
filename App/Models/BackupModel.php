<?php

namespace App\Models;

class BackupModel
{
    const TABLE = "backups";
    private $db;
    private $config;

    public function __construct($db, $config)
    {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Faz o dump do banco de dados e salva em um arquivo
     * @param string $path Caminho completo para o arquivo de dump
     */
    public function createDump($path)
    {
        $dbuser = $this->config['dbuser'];
        $dbpass = $this->config['dbpass'];
        $host = $this->config['host'];
        $dbname = $this->config['dbname'];
        $comando = "mysqldump -u $dbuser -p$dbpass -h $host $dbname > $path";

        system($comando, $retorno);

        return ($retorno === 0) ? true : false;
    }

    /**
     * register
     * @param array $params
     */
    public function set($params)
    {
        $fields = [];
        foreach ($params as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
        $sql = $this->db->prepare("INSERT INTO " . self::TABLE . " SET {$fields}");

        foreach ($params as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
        $sql->execute();
    }

    /**
     * list users
     */
    public function getAll()
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE . " ORDER BY id DESC");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * get find user by ID
     * @param int $id
     */
    public function find($id)
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE . " WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * destroy find post by ID
     * @param int $id
     */
    public function destroy($id)
    {
        $statement = $this->db->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
