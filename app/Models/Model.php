<?php

namespace App\Models;

use App\Config\Database;

class Model
{
    private $db;

    protected static $table;

    protected static $primaryKey = 'id';

    public static $count;

    protected $attributes;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function db()
    {
        return $this->db;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public static function getAll()
    {
        $db = Database::getInstance();

        $query = $db->prepare("SELECT * FROM " . static::$table);
        $query->execute();
        $allResult = $query->fetchAll(\PDO::FETCH_ASSOC);

        return self::preparedFetchData($allResult);
    }

    public static function find($id)
    {
        $db = Database::getInstance();

        $query = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?");
        $query->execute([$id]);
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        return self::prepare($data);
    }

    public static function prepare($data){
        $obj = new static();

        $obj->attributes = $data;

        return $obj;
    }

    public static function preparedFetchData($fetchData){
        $preparedItems = [];

        foreach($fetchData as $item){
            $preparedItems[] = self::prepare($item);
        }

        self::$count = count($preparedItems);

        return $preparedItems;
    }
}