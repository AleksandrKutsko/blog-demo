<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function show($id){
        $post = Post::find($id);
        $category = $post->category();
        $relatedPosts = $category->posts();

        $this->smarty()->display('article.tpl', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }
}