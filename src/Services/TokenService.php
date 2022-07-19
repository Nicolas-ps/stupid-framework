<?php

namespace Src\Services;

class TokenService
{
    public function generateToken(string $name, string $username): string
    {
        $inThirtyMinutes = (new \DateTime('now'))->add(new \DateInterval('PT30M'))
            ->getTimestamp();

        $header = json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT'
        ]);

        $payload = json_encode([
            'exp' => $inThirtyMinutes,
            'name' => $name,
            'username' => $username
        ]);


        $signature = hash_hmac(
            'sha256',
            base64url_encode($header) . '.' . base64url_encode($payload),
            '03861321'
        );

        $token = base64url_encode($header) . '.' . base64url_encode($payload) . '.' . base64url_encode($signature);

        return $token;
    }

    public function isValid(string $token): bool
    {
        if (explode('.', $token) != 3) return false;

        return $this->validateToken($token);
    }

    private function validateToken (string $token): bool
    {
        dd($token);
    }
}