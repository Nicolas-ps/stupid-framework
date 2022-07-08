<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../boot.php';
require_once __DIR__ . '/../../Config/Database.php';

$database = Src\Config\Database::DB_NAME;

$sql = "
    USE `{$database}`;
    CREATE TABLE IF NOT EXISTS `users` (
      `id` int unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
      `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 
        COLLATE=utf8mb4_unicode_ci COMMENT='Tabela de usuário registrados no sistema.';
";

$GLOBALS['PDO']->query($sql);

exit("A tabela `session` foi criado no banco de dados ");