<?php

declare(strict_types=1);

use Core\Router;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function error($msg)
{
    return $_SESSION['errors'][$msg];
}

require_once '../fileLoader.php';
require_once '../bootstrap/app.php';

$router = new Router();

$rootPath = '/' . $rootFolder;
$path = str_replace($rootPath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

foreach (glob(BASE_PATH . '/routes/*.php') as $filename) {
    require_once $filename;
}

$router->dispatch($path, $_SERVER['REQUEST_METHOD']);