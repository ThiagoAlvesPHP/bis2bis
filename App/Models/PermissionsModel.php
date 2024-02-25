<?php

namespace App\Models;

class PermissionsModel
{
    const TABLE = "permissions";
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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
     * list
     */
    public function getAll()
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE . " ORDER BY id DESC");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * list
     */
    public function getAllUser($user_id)
    {
        $statement = $this->db->prepare("SELECT p.*, m.name, m.url, m.action FROM " . self::TABLE . " as p
            LEFT JOIN " . MenusModel::TABLE . " as m
            ON p.menu_id = m.id
            WHERE p.user_id = :user_id");
        $statement->bindValue(':user_id', $user_id);
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
     * destroy by user_id
     * @param int $id
     */
    public function destroy($user_id)
    {
        $statement = $this->db->prepare("DELETE FROM " . self::TABLE . " WHERE user_id = :user_id");
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
    }
}
