<?php

namespace App\Models;

class MenusModel
{
    const TABLE = "menus";
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * list
     */
    public function getAll()
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE . " ORDER BY id ASC");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * list active menus
     */
    public function getAllActivesByUser($user_id)
    {
        $statement = $this->db->prepare("SELECT m.*, 
            CASE WHEN EXISTS 
            (SELECT 1 FROM permissions as p WHERE p.menu_id = m.id AND p.user_id = :user_id) 
            THEN true ELSE false END AS status 
            FROM menus as m 
            ORDER BY id ASC");
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
}
