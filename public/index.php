<?php

declare(strict_types=1);

use Core\Router;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Retrieve an error message from the session
 * 
 * @param mixed $msg
 */
function error($msg)
{
    return $_SESSION['errors'][$msg];
}

require_once '../fileLoader.php';
require_once '../bootstrap/app.php';

$router = new Router();

// Determine the current request path relative to the project root
$rootPath = '/' . $rootFolder;
$path = str_replace($rootPath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Load all route definitions from the routes directory
foreach (glob(BASE_PATH . '/routes/*.php') as $filename) {
    require_once $filename;
}

// Dispatch the current HTTP request to the matched controller/action
$router->dispatch($path, $_SERVER['REQUEST_METHOD']);