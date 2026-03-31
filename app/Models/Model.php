<?php

namespace App\Models;

use App\Config\Database;

class Model
{
    private object $db;
    protected static string $table;
    protected static string $primaryKey = 'id';
    protected array $fillable = [];

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
     * Сохранить модель. Вставит либо обновит
     * @return bool
     */
    public function save() :bool
    {
        if($this->exists()){
            return $this->update();
        }

        return $this->insert();
    }

    /**
     * Проверяет, существует ли запись в БД
     *
     * @return bool|array
     */
    protected function exists() :bool|array
    {
        if (!isset($this->attributes[static::$primaryKey])) {
            return false;
        }

        $stmt = $this->db->prepare("SELECT 1 FROM ".static::$table." WHERE ".static::$primaryKey." = ?");
        $stmt->execute([$this->attributes[static::$primaryKey]]);

        return $stmt->fetch();
    }

    /**
     * Вставка новой записи
     *
     * @return bool
     */
    protected function insert() :bool
    {
        // Берем только fillable поля
        $data = array_intersect_key($this->attributes, array_flip($this->fillable));

        if (empty($data)) {
            return false;
        }

        $fields = array_keys($data);
        $placeholders = implode(',', array_fill(0, count($fields), '?'));
        $columns = implode(',', $fields);

        $sql = "INSERT INTO ".static::$table." ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute(array_values($data));

        if ($result) {
            $this->attributes[static::$primaryKey] = $this->db->lastInsertId();
        }

        return $result;
    }

    /**
     * Обновление существующей записи
     *
     * @return bool
     */
    protected function update()
    {
        $set = [];
        $values = [];

        $data = array_intersect_key($this->attributes, array_flip($this->fillable));

        foreach ($data as $field => $value) {
            $set[] = "{$field} = ?";
            $values[] = $value;
        }

        // Добавляем ID для WHERE
        $values[] = $this->attributes[static::$primaryKey];

        $sql = "UPDATE ".static::$table." SET " . implode(', ', $set) . " WHERE ".static::$primaryKey." = ?";
        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute($values);

        return $result;
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