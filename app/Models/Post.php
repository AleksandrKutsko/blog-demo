<?php

namespace App\Models;

class Post extends Model
{
    protected static $table = 'posts';

    public function category(){
        $sql = "SELECT c.*
            FROM categories as c
            JOIN post_category as pc
            ON c.id = pc.category_id
            WHERE pc.post_id = ?";

        $params = [$this->id];

        $query = $this->db()->prepare($sql);
        $query->execute($params);
        $parentCategory = $this->prepare($query->fetch(\PDO::FETCH_ASSOC));

        return Category::find($parentCategory->id);
    }
}