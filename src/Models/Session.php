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

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getSessionBySessionId(string $session_id)
    {
        $pdo = $GLOBALS['PDO'];

        $sql = "select * from `session` where session_id = :session_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":session_id", $session_id);
        $result = $stmt->execute();

        if (! $result) return false;

        return true;
    }
}