<?php

namespace Core;

use Configs\Database;
use PDO;
use PDOStatement;

/**
 * Class Model
 * 
 * BaseModel that provides helper methods for all Model classes
 * Include: querying, inserting, updating, and deleting records
 */
abstract class Model
{
    /**
     * Model constructor
     * 
     * @param \Configs\Database $db
     */
    protected function __construct(protected Database $db) {}

    /**
     * Fetch all records from a query
     * @param string $sql
     * @return array
     */
    protected function getAll(string $sql): array
    {
        $conn = $this->db->connect();

        $stmt = $this->executeQuery($conn, $sql);

        $data = $this->fetchAll($stmt);

        $stmt = null;

        return $data;
    }

    /**
     * Fetch records with bound parameters
     * @param array $params
     * @param string $sql
     * @return array
     */
    protected function getByParams(array $params, string $sql): array
    {
        $conn = $this->db->connect();

        $stmt = $this->executeQuery($conn, $sql, $params);

        $data = $this->fetchAll($stmt);

        $stmt = null;

        return $data;
    }

    /**
     * Insert a record into database
     * @param string $table
     * @param array $data
     * @return bool|string
     */
    protected function insert(string $table, array $data): int
    {
        $conn = $this->db->connect();

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $this->executeQuery($conn, $sql, array_values($data));

        $id = $conn->lastInsertId();

        return $id;
    }

    /**
     * Update a record from database
     * @param string $sql
     * @param array $params
     * @return void
     */
    protected function update(string $sql, array $params) : void
    {
        $conn = $this->db->connect();

        $this->executeQuery($conn, $sql, array_values($params));
    }

    /**
     * Delete a record from database
     * @param string $sql
     * @param array $params
     * @return void
     */
    protected function delete(string $sql, array $params) : void
    {
        $conn = $this->db->connect();
        
        $this->executeQuery($conn, $sql, array_values($params));
    }

    /**
     * Execute a SQL query
     * 
     * Prevents SQL Injection by using Prepared Statements
     * 
     * @param string $sql
     * @param array $params
     * @return bool|PDOStatement
     */
    private function executeQuery(PDO $conn, string $sql, array $params = []): PDOStatement
    {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * Fetch all item into an associative array
     * @param \PDOStatement $stmt
     * @return array
     */
    private function fetchAll(PDOStatement $stmt) : array
    {
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
}
