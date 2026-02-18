<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index(){
        $this->smarty()->display('index.tpl', [
            'page_title' => 'Главная'
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