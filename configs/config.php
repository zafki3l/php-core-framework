<?php

// Path configuration
$rootFolder = basename(dirname(__DIR__));
define('PROJECT_NAME', $rootFolder);
define('BASE_PATH', dirname(__DIR__));
define('VIEW_PATH', BASE_PATH . '/app/Views/');
define('ROOT_PATH', __DIR__);

// Database configuration
define('DB_SERVER', 'YOUR_SERVER');
define('DB_USER', 'YOUR_USER');
define('DB_PASSWORD', 'YOUR_PASSWORD');
define('DB_DATABASE', 'YOUR_DB');