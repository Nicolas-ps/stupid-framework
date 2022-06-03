<?php

namespace Src\Utils;

class Sanitize
{
    public function sanitizeText(string $string): string
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
}