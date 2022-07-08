<?php

namespace Src\Models;

class Session extends Model
{
    /**
     * @var string Nome da tabela
     */
    protected $tableName = 'session';

    /**
     * @var string[] Campos graváveis da tabela
     */
    protected $writable = [
        'user_id',
        'session_id'
    ];

    public function getSessionActiveByUser(int $id)
    {
        $pdo = $GLOBALS['PDO'];

        $sql = "select s.* from `session` s inner join users u on s.user_id = u.id where u.id = $id";

        $statement = $pdo->prepare($sql);
        $result = $statement->execute();

        if (!$result) {
            return $statement->errorInfo();
        }

        return reset($statement->fetchAll(\PDO::FETCH_OBJ));
    }

    public function getSessionBySessionId(string $session_id)
    {
        $pdo = $GLOBALS['PDO'];

        $sql = "select * from {$this->tableName} s where s.session_id = :session_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":session_id", $session_id);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);

        if (! $result) return false;

        return $result;
    }

    public function updateToken(int $id): bool|string
    {
        $pdo = $GLOBALS['PDO'];
        $token = session_create_id();

        $sql = "update `session` s set s.session_id = :token where s.user_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":id", $id);
        $result = $stmt->execute();

        if (! $result) return false;

        return $token;
    }
}