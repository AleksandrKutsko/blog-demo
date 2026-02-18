<?php

namespace App\Models;

class Category extends Model
{
    protected static $table = 'categories';

    public function posts($limit = 3, $offset = null)
    {
        $sql = "SELECT p.*
            FROM posts as p
            JOIN post_category as pc
            ON p.id = pc.post_id
            WHERE pc.category_id = ?
            ORDER BY p.created_at DESC
            LIMIT ?";

        $params = [$this->id, $limit];

        if($offset != null){
            $sql .= " OFFSET ?";
            $params[] = $offset;
        }

        $query = $this->db()->prepare($sql);
        $query->execute($params);

        return $this->preparedFetchData($query->fetchAll(\PDO::FETCH_ASSOC));
    }
}