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
    public function getAll($limit = "", $category_id = "", $search = "")
    {
        $statement = "SELECT p.*, u.name as user_name, c.name as name_category FROM " . self::TABLE . " as p LEFT JOIN " . UserModel::TABLE . " as u ON p.user_id = u.id LEFT JOIN " . CategoryModel::TABLE . " as c ON p.category_id = c.id";

        if (!empty($category_id)) {
            $statement .= " WHERE p.category_id = " . $category_id;
        }

        if (!empty($search)) {
            $statement .= " WHERE p.title LIKE '%{$search}%'";
            $statement .= " || p.slug LIKE '%{$search}%'";
            $statement .= " || p.text LIKE '%{$search}%'";
            $statement .= " || c.name LIKE '%{$search}%'";
            $statement .= " || u.name LIKE '%{$search}%'";
        }

        if (!empty($limit)) {
            $statement .= " LIMIT " . $limit;
        }

        $statement = $this->db->prepare($statement);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * post rand
     */
    public function getRand()
    {
        $statement = $this->db->prepare("SELECT p.*, u.name as user_name, c.name as name_category FROM " . self::TABLE . " as p LEFT JOIN " . UserModel::TABLE . " as u ON p.user_id = u.id LEFT JOIN " . CategoryModel::TABLE . " as c ON p.category_id = c.id ORDER BY RAND() LIMIT 1");
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
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
     * get find post by slug
     * @param string $slug
     */
    public function findBySlug($slug)
    {
        $statement = $this->db->prepare("SELECT p.*, u.name as user_name, c.name as name_category FROM " . self::TABLE . " as p LEFT JOIN " . UserModel::TABLE . " as u ON p.user_id = u.id LEFT JOIN " . CategoryModel::TABLE . " as c ON p.category_id = c.id WHERE p.slug = :slug");
        $statement->bindValue(':slug', $slug);
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
