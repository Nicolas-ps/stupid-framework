<?php

namespace Src;

class ExpiredTokenException extends \Exception
{
    public function __construct(string $message = "O Token Expirou!", int $code = 401)
    {
        parent::__construct($message, $code);
    }
}