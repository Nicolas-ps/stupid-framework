<?php

ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/boot.php';

$routes = require_once __DIR__ . '/../src/routes.php';

$path = $_SERVER['PATH_INFO'];

//if ($_SERVER['REQUEST_URI'] == '/') {
//    $root = $_SERVER['SERVER_NAME'] . ':8080/login';
//    header('Location: ' . $root, true, 200);
//    exit();
//}

if (in_array($path, array_keys($routes))) {
    $class = reset($routes[$path]);
    $method = end($routes[$path]);

    $controller = new $class();
    $controller->$method();
} else {
    if ($_SERVER['REQUEST_URI'] == '/') {
        $path = $_SERVER['REQUEST_URI'];

        $class = reset($routes[$path]);
        $method = end($routes[$path]);

        $controller = new $class();
        $controller->$method();
    }

    header('HTTP/1.1 404 Not Found');
    exit();
}



