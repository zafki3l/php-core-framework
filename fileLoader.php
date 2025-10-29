<?php

require_once '../Configs/config.php';

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        throw new Exception("Cannot load class: $class ($path)");
    }
});
