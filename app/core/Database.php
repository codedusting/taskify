<?php

namespace Core;


use Exception;
use PDO;
use PDOException;
use PDOStatement;

class Database
{
    protected PDO $connection;
    protected false|PDOStatement $stmt;
    protected string $queryType;

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

    public function query(string $query): static
    {
        $this->stmt = $this->connection->prepare($query);
        $this->queryType = strtolower(strtok(trim($query), " "));
        return $this;
    }

    public function execute(array $params = [])
    {
        try {
            if ($this->isInsertQuery()) {
                $params = $this->handleInsertParams($params);
            } else {
                if ($this->isUpdateQuery() || $this->isDeleteQuery()) {
                    if (!isset($params[":publicId"])) {
                        throw new Exception("Missing :publicId parameter for the operation.");
                    }
                    if (!isset($params[":table"])) {
                        throw new Exception("Missing :table parameter for the operation.");
                    }
                    $this->validatePublicIdExists($params[":publicId"], $params[":table"]);
                    unset($params[":table"]);
                }
            }
//            dd($this->queryType);
//            dd($this->stmt);
//            dd($params);
            $this->stmt->execute($params);
        } catch (PDOException|Exception $e) {
            error_log("Error executing query: ".$e->getMessage()." | file: ".__FILE__." | line: 43");
            if ($this->isSelectQuery()) {
                return;
            }
            return ["error" => $e->getMessage()];
        }
        return $this;
    }

    public function isInsertQuery(): bool
    {
        return $this->queryType === "insert";
    }

    /**
     * @throws Exception
     */
    private function handleInsertParams(array $params): array
    {
        if (!isset($params[":publicId"])) {
            $params[":publicId"] = NanoIdGenerator::generateUniqueId(function ($id) {
                return $this->isUniquePublicId($id);
            });
        }
        return $params;
    }

    private function isUniquePublicId(string $id, $table = "tasks", $column = "public_id"): bool
    {
        $query = sprintf(
            "SELECT COUNT(*) FROM %s WHERE %s = :publicId",
            preg_replace('/[^a-zA-Z0-9_]/', '', $table),
            preg_replace('/[^a-zA-Z0-9_]/', '', $column),
        );
        $stmt = $this->connection->prepare($query);
        $stmt->execute([":publicId" => $id]);
        return $stmt->fetchColumn() == 0;
    }

    public function isUpdateQuery(): bool
    {
        return $this->queryType === "update";
    }

    public function isDeleteQuery(): bool
    {
        return $this->queryType === "delete";
    }

    /**
     * @throws Exception
     */
    private function validatePublicIdExists(string $publicId, string $table, string $column = "public_id"): void
    {
        if (!$this->isUniquePublicId($publicId, $table, $column)) {
            return;
        }
        throw new Exception("Public Id '$publicId' does not exist in the table '$table'.");
    }

    public function isSelectQuery(): bool
    {
        return $this->queryType === "select";
    }

    public function fetchAll(): array
    {
        return $this->stmt->fetchAll();
    }
}