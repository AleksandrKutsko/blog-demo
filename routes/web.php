<?php
use App\Core\Router;

Router::get('/', 'HomeController@index', 'main-page');//index
Router::get('/404', 'HomeController@notFound', 'not-found');//404

Router::get('/category/{id}/posts', 'CategoryController@show', 'category-show');//category page

Router::get('/post/{id}', 'PostController@show', 'post-show');//post page