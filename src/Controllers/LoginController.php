<?php

namespace Src\Controllers;

use Src\Models\User;
use Src\Services\TokenService;
use Src\Utils\Sanitize;
use Src\Utils\Validate;

class LoginController
{
    public function auth()
    {
        if (empty($_REQUEST['username']) || empty($_REQUEST['password'])) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'Alguns campos não foram preenchidos!'
                ]
            ]);

            header('HTTP/1.1 400 Bad Request');
            exit();
        }

        $sanitize = new Sanitize();
        $user = new User();

        $username = $sanitize->sanitizeText($_REQUEST['username']);

        $user = $user->getUserByUsername($username);

        if (!$user || !password_verify($_REQUEST['password'], $user->password)) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'Usuário ou senha incorretos!'
                ]
            ]);

            header('HTTP/1.1 200 OK');
            exit();
        }

        $tokenService = new TokenService();
        $accessToken = $tokenService->generateToken($user->name, $user->username);

        echo json_encode([
            'data' => [
                'message' => 'Usuário logado!',
                'access_token' => $accessToken,
                'user_id' => $user->id
            ],
            'success' => true
        ]);

        header('HTTP/1.1 200 OK');
        exit();
    }

    public function signup()
    {
        if (empty($_REQUEST['name'] || empty($_REQUEST['username']) || empty($_REQUEST['password']))) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'Alguns campos não foram preenchidos!'
                ]
            ]);

            header('HTTP/1.1 400 Bad Request');
            exit();
        }

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

        if (!$user->insert([$name, $username, $password])) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'Ocorreu um erro ao registrar o usuário! Tente novamente!'
                ]
            ]);

            header('HTTP/1.1 200 OK');
            exit();
        }

        $user = $user->getUserByUsername($_REQUEST['username']);
        $accessToken = (new TokenService())->generateToken($user->name, $user->username);

        echo json_encode([
            'data' => [
                'message' => 'O usuário foi registrado!',
                'access_token' => $accessToken,
                'expires_in' => 1800,
                'user_id' => $user->id
            ],
            'success' => true
        ]);

        header('HTTP/1.1 200 OK');
        exit();
    }


    public function refreshToken()
    {
        $tokenService = new TokenService();
        dd($tokenService->isValid($_REQUEST['token']));
    }

    public function root()
    {
        echo json_encode([
            'app'=> 'stupid-mvc',
            'route' => 'root'
        ]);

        exit();
    }
}