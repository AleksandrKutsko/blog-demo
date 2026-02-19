<?php

namespace App\Models;

class Category extends Model
{
    protected static string $table = 'categories';

    /**
     * Посты категории
     * @param $limit
     * @param $sort
     * @param $orderBy
     * @param $offset
     * @return array
     */
    public function posts($limit = 3, $sort = 'created_at', $orderBy = 'desc', $offset = null) :array
    {
        $availableSort = ['created_at', 'views'];
        $availableOrder = ['desc', 'asc'];

        $sort = in_array($sort, $availableSort) ? $sort : 'created_at';
        $orderBy = in_array($orderBy, $availableOrder) ? $orderBy : 'desc';

        $sql = "SELECT p.*
            FROM posts as p
            JOIN post_category as pc
            ON p.id = pc.post_id
            WHERE pc.category_id = ?
            ORDER BY p.{$sort} {$orderBy}
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