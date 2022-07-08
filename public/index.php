<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/boot.php';

$routes = require_once __DIR__ . '/../src/routes.php';

$path = $_SERVER['REDIRECT_URL'];

if (in_array($path, array_keys($routes))) {
    $class = reset($routes[$path]);
    $method = end($routes[$path]);

    $controller = new $class();
    $controller->$method();
} else {
    if ($path == '/') {
        $class = reset($routes[$path]);
        $method = end($routes[$path]);

        $controller = new $class();
        $controller->$method();
    }

    header('HTTP/1.1 404 Not Found');
    exit();
}



