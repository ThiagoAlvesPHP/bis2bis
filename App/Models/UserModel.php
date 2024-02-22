<?php

namespace App\Models;

class UserModel
{
    const TABLE = "users";
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $statement = $this->db->prepare("SELECT * FROM " . self::TABLE);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
