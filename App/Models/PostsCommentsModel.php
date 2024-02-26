<?php

namespace App\Models;

class PostsCommentsModel
{
    const TABLE = "posts_comments";
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
        $statement = $this->db->prepare("INSERT INTO " . self::TABLE . " SET {$fields}");

        foreach ($params as $key => $value) {
            $statement->bindValue(":{$key}", $value);
        }
        $statement->execute();

        return $this->db->lastInsertId();
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
     * list users
     */
    public function getAll($post_id)
    {
        $statement = $this->db->prepare("SELECT pc.*, u.name as user_name
            FROM " . self::TABLE . " as pc
            LEFT JOIN " . UserModel::TABLE . " as u
            ON pc.user_id = u.id
            WHERE post_id = :post_id
            ORDER BY id DESC");
        $statement->bindValue(':post_id', $post_id);
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * destroy find by ID
     * @param int $id
     */
    public function destroy($id)
    {
        $statement = $this->db->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

    /**
     * destroy find post by ID
     * @param int $id
     */
    public function destroyPostID($post_id)
    {
        $statement = $this->db->prepare("DELETE FROM " . self::TABLE . " WHERE post_id = :post_id");
        $statement->bindValue(':post_id', $post_id);
        $statement->execute();
    }
}
