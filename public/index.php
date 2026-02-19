<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\SmartyWrapper;
use App\Core\Router;

try {
    require_once __DIR__ . '/../routes/web.php';

    Router::dispatch();
} catch (Exception $e) {
    $smarty = new SmartyWrapper();
    $smarty->display('error.tpl', [
        'page_description' => $e->getMessage()
    ]);
}