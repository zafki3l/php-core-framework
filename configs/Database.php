<?php

namespace Configs;

use PDO;
use PDOException;

/**
 * Class Database
 * 
 * Handles Database Connection
 */
class Database
{
    // Handles connecting
    public function connect()
    {
        try {
            $dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE . ';charset=UTF8';
            $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);

            return $pdo;
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}