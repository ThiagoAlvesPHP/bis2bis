<?php

namespace App\Models;

class PostModel
{
    const TABLE = "posts";

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
     * update
     * @param array $params
     */
    public function update($params)
    {
        $fields = [];
        foreach ($params as $key => $value) {
            $fields[] = "$key=:$key";
        }
        $fields = implode(', ', $fields);
        $sql = $this->db->prepare("UPDATE " . self::TABLE . " SET {$fields} WHERE id = :id");

        $sql->bindValue(":id", $params['id']);
        foreach ($params as $key => $value) {
            $sql->bindValue(":{$key}", $value);
        }
        $sql->execute();
    }

    /**
     * list posts
     */
    public function getAll()
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * get find post by ID
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
     * query custom search
     */
    public function customSearch($sql)
    {
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * verify slug
     * @param string $email
     */
    public function hasSlug($slug, $id = "")
    {
        $statement = "SELECT * FROM " . self::TABLE . " WHERE slug = :slug";
        if (!empty($id)) {
            $statement .= " AND id != :id";
        }
        $statement = $this->db->prepare($statement);
        $statement->bindValue(':slug', $slug);
        if (!empty($id)) {
            $statement->bindValue(':id', $id);
        }
        $statement->execute();
        return $statement->rowCount() ?? false;
    }
}
