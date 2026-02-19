<?php

namespace App\Controllers;

use App\Models\Category;
use App\Services\PostService;

class HomeController extends Controller
{

    /**
     * Обработчик маршрута главной
     * @return void
     */
    public function index() :void
    {
        $categories = Category::getAll();

        //Получение постов для категорий. Без проблемы n+1
        $categories = PostService::getPostsForCategories($categories);

        $this->smarty()->display('index.tpl', [
            'page_title' => 'Главная',
            'categories' => $categories
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