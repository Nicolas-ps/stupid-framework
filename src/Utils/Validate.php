<?php

namespace Src\Utils;

class Validate
{
    public function validateEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}