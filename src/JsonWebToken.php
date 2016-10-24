<?php

namespace JwtLoginPoc;

class JsonWebToken
{

    const SIGNATURE_KEY = '90jikvldfay8rwnkfndakhfhklj908fdsauhtn98whfdsna89gifdJagjfds8a9ijkjadsda';

    public static function generateToken(array $payload = []) : string
    {
        $tokenHeader = [
            'alg' => 'HS512',
            'typ' => 'JWT',
        ];

        $tokenParts = [
            self::urlsafeB64Encode(json_encode($tokenHeader)),
            self::urlsafeB64Encode(json_encode($payload)),
        ];

        $tokenParts[] = self::sign($tokenParts);

        return implode('.', $tokenParts);
    }

    public static function readToken(string $token) : array
    {
        $tokenParts = explode('.', $token);

        if ($tokenParts[2] !== self::sign(array_slice($tokenParts, 0, 2))) {
            throw new \Exception('Signature invalid');
        }

        return json_decode(self::urlsafeB64Decode($tokenParts[1]), true);
    }

    public static function sign(array $tokenParts) : string
    {
        $signature = hash_hmac('sha512', implode('.', $tokenParts), self::SIGNATURE_KEY, true);

        return self::urlsafeB64Encode($signature);
    }

    public static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    public static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

}
