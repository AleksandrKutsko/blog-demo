<?php

namespace App\Services;

use App\Config\Database;
use App\Models\Post;

class PostService
{

    /**
     * Решение проблемы n+1. Получение ко всех категориями постов
     * @param array $categories
     * @param $categoryPosts
     * @return array
     */
    public static function getPostsForCategories(array $categories, $categoryPostCount = 3) :array
    {
        $categoryIds = [];
        foreach($categories as $category){
            $categoryIds[] = $category->id;
        }
        $placeholderCategoryIds = implode(',', array_fill(0, count($categoryIds), '?'));

        $db = Database::getInstance();

        $query = $db->prepare("SELECT 
                pc.category_id,
                p.*
            FROM posts p
            JOIN post_category pc ON p.id = pc.post_id
            WHERE pc.category_id IN ({$placeholderCategoryIds})
            AND (
                SELECT COUNT(*) 
                FROM posts p2
                JOIN post_category pc2 ON p2.id = pc2.post_id
                WHERE pc2.category_id = pc.category_id
                AND p2.created_at >= p.created_at
            ) <= ?
            ORDER BY p.created_at DESC;");

        $query->execute(array_merge($categoryIds, [$categoryPostCount]));
        $allPosts = $query->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($categories as &$category){
            $categoryPosts = [];

            foreach($allPosts as &$post){
                if($post['category_id'] == $category->id){
                    $categoryPosts[] = Post::prepare($post);

                    unset($post);
                }
            }

            $category->posts = $categoryPosts;
        }

        return $categories;
    }
}