<?php

namespace Core;

use PDOException;

class Database
{
    protected PDO $connection;

    public function __construct(string $host, string $port, string $dbname, string $user, string $password)
    {
        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->connection = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            echo (int) $e->getCode()." : ".$e->getMessage();
            die();
        }
    }
}