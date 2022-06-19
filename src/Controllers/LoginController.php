<?php

namespace Src\Controllers;

use Src\Models\User;
use Src\Session\SessionControl;
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

        if (!password_verify($_REQUEST['password'], $user->password)) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'Usuário ou senha incorretos!'
                ]
            ]);

            header('HTTP/1.1 200 OK');
            exit();
        }

        $sessionControl = new SessionControl();
        $sessionControl->startSession();
        $sessionControl->set('id', $user->id);
        $sessionControl->set('username', $user->username);
        $sessionControl->persistSession($user->id);

        echo json_encode([
            'data' => [
                'message' => 'Usuário logado!',
                'access_token' => $sessionControl->getSessionId(),
                'user_id' =>  $user->id
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

        $user = $user->insert([$name, $username, $password]);

        if (!$user) {
            echo json_encode([
                'data' => [],
                'error' => [
                    'message' => 'Ocorreu um erro ao registrar o usuário! Tente novamente!'
                ]
            ]);

            header('HTTP/1.1 200 OK');
            exit();
        }

        echo json_encode([
            'data' => [
                'message' => 'O usuário foi registrado!'
            ],
            'success'=> true
        ]);

        header('HTTP/1.1 200 OK');
        exit();
    }

    public function logout()
    {
        $userId = json_decode(file_get_contents('php://input'))->user_id;

        $sessionControl = new SessionControl();
        $sessionControl->destroySession();
    }
}