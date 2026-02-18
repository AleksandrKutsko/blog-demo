<?php

namespace App\Services;

use App\Config\Database;

class CategoryService
{
    public static function getPostsCount($categoryId) :int
    {
        $db = Database::getInstance();

        $query = $db->prepare("
            SELECT COUNT(*) 
            FROM posts p
            JOIN post_category pc ON p.id = pc.post_id
            WHERE pc.category_id = ?
        ");
        $query->execute([$categoryId]);

        return $query->fetchColumn();
    }
}