<?php

namespace Src\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

class TokenService
{
    public array $supportedAlgs = [
        'HS256',
        'HS384',
        'HS512',
        'RS256',
        'RS384',
        'RS512',
        'ES256',
        'ES384',
        'ES512',
        'PS256',
        'PS384',
        'PS512',
    ];

    private string $key = '03861321';

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
        $jwt = explode('.', $token);

        if (count($jwt) !== 3) return false;

        try {
            JWT::decode($token, new Key($this->key, 'HS256'));
        } catch (Throwable $violation) {
            dd($violation);
        }
    }
}