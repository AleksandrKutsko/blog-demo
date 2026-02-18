<?php

namespace App\Controllers;

use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function show(int $id){
        $postsCount = CategoryService::getPostsCount($id);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $sort = isset($_GET['sort']) && $_GET['sort'] == 'views' ? 'views' : 'created_at';
        $orderBy = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'asc' : 'desc';

        $perPage = 3;
        $offset = ($page - 1) * $perPage;

        $totalPages = ceil($postsCount / $perPage);

        $category = Category::find($id);
        $posts = $category->posts($perPage, $sort, $orderBy, $offset);

        $this->smarty()->display('blog.tpl', [
            'page_title' => $category->title,
            'page_description' => $category->description,
            'posts' => $posts,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'current_sort' => $sort,
            'has_pagination' => $totalPages > 1,
            'sort' => $sort,
            'order_by' => $orderBy
        ]);
    }
}