<?php

use Src\Controllers\HomeController;
use Src\Controllers\LoginController;

$routes = [
    '/' => [LoginController::class, 'root'],
    '/auth' => [LoginController::class, 'auth'],
    '/signup' => [LoginController::class, 'signup'],
    '/refresh-token' => [LoginController::class, 'refreshToken'],
];

return $routes;

