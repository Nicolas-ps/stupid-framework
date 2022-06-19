<?php

namespace Src\Controllers;

use Src\Session\SessionControl;

class HomeController
{
    public function index()
    {
        dd(SessionControl::sessionIsValid($_REQUEST['user_id']));
    }
}