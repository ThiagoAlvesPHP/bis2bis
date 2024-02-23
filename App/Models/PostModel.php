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
     * list all posts
     */
    public function getAll()
    {
        // Aqui você poderia realizar uma consulta ao banco de dados
        // e retornar os dados dos posts
        return [
            ['id' => 1, 'title' => 'Post 1', 'content' => 'Conteúdo do Post 1'],
            ['id' => 2, 'title' => 'Post 2', 'content' => 'Conteúdo do Post 2'],
            // Outros posts aqui...
        ];
    }
}
