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
        $jwt = explode('.', $token);

        if (count($jwt) !== 3) return false;

        return $this->validateToken($jwt);
    }

    private function validateToken (array $token): bool
    {
        $headerDecoded = base64_decode($token[0]);
        $payloadDecoded = base64_decode($token[1]);

        $data = [
            [
                'value' => $headerDecoded,
                'type' => 'header'
            ],
            [
                'value' => $payloadDecoded,
                'type' => 'payload'
            ]
        ];

        foreach ($data as $info) {
            if (! $this->validates($info)) return false;
        }

        return $payloadDecoded;
    }

    private function refreshToken () {

    }

    private function validates (array $data) {
        $conditions = [
            'IsJson' => function ($data) {
                if (! (json_decode($data) instanceof \stdClass)) return false;

                return true;
            }
        ];

        foreach ($conditions as $condition) {
            if (! $condition($data)) return false;
        }

        return true;
    }
}