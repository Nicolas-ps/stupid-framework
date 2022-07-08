<?php

namespace Src\Models;

class Model
{
    protected $tableName;

    protected $writable = [];

    public function getWritables()
    {
        return $this->writable;
    }

    public function insert(array $values)
    {
        $pdo = $GLOBALS['PDO'];

        $fields = implode(',', $this->getWritables());

        $sql = "insert into `{$this->tableName}` ($fields) values (";

        foreach ($values as $value) {
            if ($value != end($values)) {
                if (!is_int($value)) {
                    $sql .= "{$value},";
                    continue;
                }

                $sql .= "'{$value}',";
            }
        }

        $sql .= "'" . end($values) . "');";

        $statement = $pdo->prepare($sql);
        $result = $statement->execute();

        if (!$result) {
            return false;
        }

        return true;
    }

    public function deleteById(int $id)
    {
        $pdo = $GLOBALS['PDO'];

        $sql = "delete from {$this->tableName} s where s.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();

        if (!$result) return false;

        return true;
    }
}