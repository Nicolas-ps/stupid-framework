<?php

if (!function_exists('base64url_encode')) {
    function base64url_encode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-'), '=');
    }
}

if (!function_exists('responseJson')) {
    function responseJson (mixed $data) {
        echo json_encode($data);
    }
}