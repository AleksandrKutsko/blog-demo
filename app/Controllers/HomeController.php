<?php

namespace App\Controllers;

use App\Models\Category;

class HomeController extends Controller
{

    /**
     * Обработчик маршрута главной
     * @return void
     */
    public function index() :void
    {
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

    /**
     * Маршрут страницы 404
     * @return void
     */
    public function notFound() :void
    {
        http_response_code(404);

        $this->smarty()->display('error.tpl', [
            'page_title' => '404',
            'page_description' => 'Страница не найдена'
        ]);
    }
}