<?php

namespace Src\Controllers;

use Src\Database\Database;
use Src\Models\User;
use Src\Utils\Sanitize;

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

        dd($user);
    }

    public function register()
    {
        require_once __DIR__ . '/../../views/login/register.php';
    }

    public function signup()
    {
        $sanitize = new Sanitize();
        $user = new User();

        $name = $sanitize->sanitizeText($_REQUEST['name']);
        $username = $sanitize->sanitizeText($_REQUEST['username']);
        $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

        $user->insert([$name, $username, $password]);
    }
}