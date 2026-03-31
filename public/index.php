<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\SmartyWrapper;
use App\Core\Router;

try {
    require_once __DIR__ . '/../routes/web.php';

    $dotenv = __DIR__ . '/../.env';
    if (file_exists($dotenv)) {
        $lines = file($dotenv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                putenv($line);
            }
        }
    }

    Router::dispatch();
} catch (Exception $e) {
    $smarty = new SmartyWrapper();
    $smarty->display('error.tpl', [
        'page_description' => $e->getMessage()
    ]);
}