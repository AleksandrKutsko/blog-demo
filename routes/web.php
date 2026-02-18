<?php
use App\Core\Router;

Router::get('/404', 'HomeController@notFound');
Router::get('/', 'HomeController@index');
Router::get('/category/{id}', 'CategoryController@show');
Router::get('/post/{id}', 'PostController@show');