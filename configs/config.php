<?php

// Path configuration
$rootFolder = basename(dirname(__DIR__));
define('PROJECT_NAME', $rootFolder);
define('BASE_PATH', dirname(__DIR__));
define('VIEW_PATH', BASE_PATH . '/app/Views/');
define('ROOT_PATH', __DIR__);

// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'bookstore_v3');