<?php

use Src\Controllers\HomeController;
use Src\Controllers\LoginController;

$routes = [
    '/auth' => [LoginController::class, 'auth'],
    '/signup' => [LoginController::class, 'signup'],
    '/logout' => [LoginController::class, 'logout'],
    '/home' => [HomeController::class, 'index']
];

return $routes;

