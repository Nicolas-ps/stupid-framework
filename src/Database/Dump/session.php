<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../boot.php';
require_once __DIR__ . '/../../Config/Database.php';

$database = Src\Config\Database::DB_NAME;

$sql = "
    USE `{$database}`;
    CREATE TABLE IF NOT EXISTS `session` (
      `id` int unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int unsigned NOT NULL,
      `session_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `session_FK` (`user_id`),
      CONSTRAINT `session_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 
        COLLATE=utf8mb4_unicode_ci COMMENT='Tabela de registro de sessão de usuário';
";

$GLOBALS['PDO']->query($sql);

exit("A tabela `session` foi criada no banco de dados ");