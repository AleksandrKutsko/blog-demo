<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;

try {
    $db = Database::getInstance();
    echo "Подключение к базе данных успешно!<br>";
} catch (Exception $e) {
    echo "Ошибка подключения к БД: " . $e->getMessage() . "<br>";
}

// Информация о PHP
phpinfo();