<?php


namespace Services;


use mysqli;

class QueryService
{
    /** @var mysqli $mysqli */
    private $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function insertRecord(string $query, array $params): ?int
    {
        $stmt = $this->mysqli->prepare($query);

        $typeString = '';
        foreach ($params as $param) {
            if (is_numeric($param)) {
                $typeString .= 'i';
            } else {
                $typeString .= 's';
            }
        }
        $stmt->bind_param($typeString, ...$params);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return null;
        }
    }

    public function selectRecord(string $class, string $query, array $params)
    {
        $stmt = $this->mysqli->prepare($query);

        $typeString = '';
        foreach ($params as $param) {
            if (is_numeric($param)) {
                $typeString .= 'i';
            } else {
                $typeString .= 's';
            }
        }
        $stmt->bind_param($typeString, ... $params);

        if ($stmt->execute() && $result = $stmt->get_result()) {
            return $result->fetch_object($class);
        } else {
            return null;
        }
    }

    public function selectRecords(string $class, string $query, array $params = null)
    {
        $stmt = $this->mysqli->prepare($query);

        if ($params !== null) {
            $typeString = '';
            foreach ($params as $param) {
                if (is_numeric($param)) {
                    $typeString .= 'i';
                } else {
                    $typeString .= 's';
                }
            }
            $stmt->bind_param($typeString, ... $params);
        }

        if ($stmt->execute() && $result = $stmt->get_result()) {
            $records = [];
            while ($record = $result->fetch_object($class)) {
                $records[] = $record;
            }
            return $records;
        } else {
            return [];
        }
    }

    public function deleteRecord(string $class, int $id): ?int
    {
        $stmt = $this->mysqli->prepare("DELETE FROM {$class} WHERE id = ?");

        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            return $stmt->affected_rows;
        }
        return null;
    }

    public function updateRecord(string $class, string $query, array $params): bool
    {
        $stmt = $this->mysqli->prepare($query);

        $typeString = '';
        foreach ($params as $param) {
            if (is_numeric($param)) {
                $typeString .= 'i';
            } else {
                $typeString .= 's';
            }
        }
        $stmt->bind_param($typeString, ... $params);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }

    public function beginTransaction()
    {
        $this->mysqli->begin_transaction();
    }

    public function commit()
    {
        $this->mysqli->commit();
    }

    public function rollback()
    {
        $this->mysqli->rollback();
    }
}
