<?php

use Src\Database\Connection;

$GLOBALS['PDO'] = Connection::init();
