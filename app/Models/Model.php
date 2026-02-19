<?php

namespace App\Models;

use App\Config\Database;

class Model
{
    private object $db;
    protected static string $table;
    protected static string $primaryKey = 'id';

    public static int $count;

    protected array $attributes;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * PDO Connection
     * @return object|\PDO
     */
    protected function db() :object
    {
        return $this->db;
    }

    /**
     * Геттер свойств модели
     * @param $name
     * @return string|null|array
     */
    public function __get($name) :string|null|array
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value) :void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Получение всех данные модели
     * @return array
     */
    public static function getAll() :array
    {
        $db = Database::getInstance();

        $query = $db->prepare("SELECT * FROM " . static::$table);
        $query->execute();
        $allResult = $query->fetchAll(\PDO::FETCH_ASSOC);

        return self::preparedFetchData($allResult);
    }

    /**
     * Поиск модели по первичному ключу
     * @param $id
     * @return object|static
     */
    public static function find($id) :object
    {
        $db = Database::getInstance();

        $query = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?");
        $query->execute([$id]);
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if(!$data){
            throw new \Exception('Объект не найден');
        }

        return self::prepare($data);
    }

    /**
     * Возвращает объект класса (модели)
     * @param $data
     * @return object|static
     */
    public static function prepare($data) :object
    {
        $obj = new static();

        $obj->attributes = $data;

        return $obj;
    }

    /**
     * Возвращает массив объектов
     * @param $fetchData
     * @return array
     */
    public static function preparedFetchData($fetchData) :array
    {
        $preparedItems = [];

        foreach($fetchData as $item){
            $preparedItems[] = self::prepare($item);
        }

        self::$count = count($preparedItems);

        return $preparedItems;
    }
}