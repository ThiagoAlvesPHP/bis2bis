<?php

namespace App\Controllers;

class PostsController
{
    public $title = "Posts";
    public $page = "posts";

    public function show($postId)
    {
        ob_start();
        include __DIR__ . '/../views/post.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }

    public function index()
    {
        ob_start();
        include __DIR__ . '/../views/admin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/template.php';
    }
}
