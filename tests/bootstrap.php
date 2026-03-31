<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Загружаем тестовые настройки
$dotenv = __DIR__ . '/../.env.testing';
if (file_exists($dotenv)) {
    $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            putenv($line);
        }
    }
}

// Настройка для тестов
define('TESTING', true);

// Функция для создания тестовой БД
function createTestDatabase()
{
    try {
        $pdo = new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';charset=utf8mb4',
            getenv('DB_USER'),
            getenv('DB_PASS')
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Создаем тестовую БД если её нет
        $dbName = getenv('DB_NAME');
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}`");
        $pdo->exec("USE `{$dbName}`");

        // Создаем таблицы
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                content LONGTEXT,
                image_path VARCHAR(500),
                views INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS post_category (
                post_id INT,
                category_id INT,
                PRIMARY KEY (post_id, category_id),
                FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
            ) ENGINE=InnoDB
        ");

    } catch (PDOException $e) {
        die("Ошибка создания тестовой БД: " . $e->getMessage());
    }
}

// Создаем тестовую БД
createTestDatabase();