<?php

namespace Src\Database;

use Src\Config\Database;

class Connection
{
    /**
     * Instancia uma conexão PDO a partir das
     * credenciais fornecidas na classe constantes Database
     * @return \PDO
     */
    public static function init()
    {
        $host = Database::DB_HOST;
        $database = Database::DB_NAME;
        $user = Database::DB_USER;
        $password = Database::DB_PASSWORD;

        $dsn = "mysql:host={$host};dbname={$database}";

        return new \PDO($dsn, $user, $password);
    }
}