<?php

namespace Src\Controllers;

use Src\Database\Database;
use Src\Models\User;
use Src\Utils\Sanitize;
use Src\Utils\Validate;

class LoginController
{
    public function index()
    {
        require_once __DIR__ . '/../../views/login/index.php';
    }

    public function auth()
    {
        $sanitize = new Sanitize();
        $user = new User();

        $username = $sanitize->sanitizeText($_REQUEST['username']);

        $user = $user->getUserByUsername($username);
    }

    public function register()
    {
    }

    public function signup()
    {
        $sanitize = new Sanitize();
        $user = new User();
        $validator = new Validate();

        $name = $sanitize->sanitizeText($_REQUEST['name']);
        $username = $validator->validateEmail($_REQUEST['username']);

        if (!$username) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'O endereço de email digitado não é válido!'
                ]
            ]);

            header('HTTP/1.1 400 Bad Request');
            exit();
        }

        if ($user->getUserByUsername($username)) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'Já existe um usuário cadastrado com esse endereço de email!'
                ]
            ]);

            header('HTTP/1.1 200 OK');
            exit();
        }

        $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

        $user = $user->insert([$name, $username, $password]);

        if ($user) {
            echo json_encode([
                'data' => [
                    'message' => 'O usuário foi registrado!'
                ],
                'success'=> true
            ]);

            header('HTTP/1.1 200 OK');
            exit();
        }
    }
}