<?php

namespace Configs;

use PDO;
use PDOException;

class Database
{
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