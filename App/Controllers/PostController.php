<?php

namespace App\Controllers;

class PostController
{
    public $title = "Página do Post";

    public function show($postId)
    {
        ob_start();
        include __DIR__ . '/../views/post.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
