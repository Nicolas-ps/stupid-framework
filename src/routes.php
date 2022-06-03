<?php

use Src\Controllers\LoginController;

$routes = [
    '/' => [LoginController::class, 'index'],
    '/auth' => [LoginController::class, 'auth'],
    '/register' => [LoginController::class, 'register'],
    '/signup' => [LoginController::class, 'signup']
];

return $routes;

