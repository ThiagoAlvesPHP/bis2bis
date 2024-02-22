<?php
namespace App\Controllers;

class PostController
{
    public function show($postId)
    {
        // Lógica para a página de post
        $title = 'Página do Post';
        ob_start();
        include __DIR__.'/../views/post.php';
        $content = ob_get_clean();
        include __DIR__.'/../views/template.php';
    }
}
