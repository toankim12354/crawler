<?php

namespace Toanlt\Crawler\Models;

use PDO;
use PDOException;


class Database
{
    private PDO $conn;

    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        $dsn = "mysql:host=$host;dbname=$dbname";

        try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function insert(string $table, array $data): bool|string
    {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);

        return $this->conn->lastInsertId();
    }

    public function update(string $table, array $data, string $where = null): int
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key=:$key, ";
        }
        $set = rtrim($set, ", ");

        $query = "UPDATE $table SET $set";

        if ($where) {
            $query .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);

        return $stmt->rowCount();
    }

    public function delete(string $table, string $where): int
    {
        $query = "DELETE FROM $table WHERE $where";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function get(string $table, string $where = null): bool|array
    {
        $query = "SELECT * FROM $table";
        $data = [];

        if ($where) {
            $query .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
