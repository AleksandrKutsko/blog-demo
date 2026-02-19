<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Обработчик страницы поста
     * @param $id
     * @return void
     */
    public function show($id) :void
    {
        $post = Post::find($id);
        $category = $post->category();
        $relatedPosts = $category->posts();

        $this->smarty()->display('article.tpl', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }
}