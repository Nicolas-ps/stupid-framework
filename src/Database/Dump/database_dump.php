<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../boot.php';

$database = 'api';

$sql = "CREATE DATABASE IF NOT EXISTS `$database`;";

$GLOBALS['PDO']->query($sql);

exit("O banco de dados `{$database}` foi criando no seu servidor! Configure a constante DB_NAME em src/Config/Database.php");
