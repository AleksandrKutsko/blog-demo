<?php

namespace App\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::getAll();
        $categoriesPosts = [];

        foreach($categories as $category){
            $categoriesPosts[$category->id] = $category->posts();
        }

        $this->smarty()->display('index.tpl', [
            'page_title' => 'Главная',
            'categories' => $categories,
            'categoriesPosts' => $categoriesPosts
        ]);
    }

    public function notFound(){
        http_response_code(404);

        $this->smarty()->display('error.tpl', [
            'page_title' => '404',
            'page_description' => 'Страница не найдена'
        ]);
    }
}