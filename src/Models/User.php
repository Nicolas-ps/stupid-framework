<?php

namespace Src\Models;

use PDO;

class User extends Model
{
    /**
     * @var string Nome da tabela
     */
    protected $tableName = 'users';

    /**
     * @var string[] Campos graváveis da tabela
     */
    protected $writable = [
        'name',
        'username',
        'password'
    ];

    /**
     * Realiza consulta no banco por usuário com o ID fornecido
     * @param int $id
     * @return object|string
     */
    public function getUserById(int $id)
    {
        $pdo = $GLOBALS['PDO'];

        try {
            $query = $pdo->query("select username, password from users where id = '{$id}'");
            $result = $query->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $exception) {
            return json_encode([
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'traceback' => $exception->getTraceAsString(),
            ]);
        }

        return $result;
    }

    /**
     * Realiza consulta no banco por usuário com o username fornecido
     * @param string $username
     * @return object|string
     */
    public function getUserByUsername(string $username)
    {
        $pdo = $GLOBALS['PDO'];

        try {
            $query = $pdo->query("select * from users where username = '{$username}'");
            $result = $query->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $exception) {
            return json_encode([
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'traceback' => $exception->getTraceAsString(),
            ]);
        }

        return reset($result);
    }

    /**
     * Realiza consulta no banco por usuário com base
     * nas cláusulas wheres fornecidas
     * @param array $whereClauses
     * @return void
     */
    public function getUser(array $whereClauses)
    {

    }
}