<?php
use App\Core\Router;

Router::get('/404', 'HomeController@notFound', 'not-found');
Router::get('/', 'HomeController@index', 'main-page');
Router::get('/category/{id}/posts', 'CategoryController@show', 'category-show');
Router::get('/post/{id}', 'PostController@show', 'post-show');