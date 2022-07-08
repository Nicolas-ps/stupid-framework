<?php

namespace Src\Controllers;

use Src\Session\AccessControl;

class HomeController
{
    public function index()
    {
        dd(AccessControl::sessionIsValid($_REQUEST['user_id']));
    }
}