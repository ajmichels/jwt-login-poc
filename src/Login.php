<?php

declare(strict_types=1);

namespace JwtLoginPoc;

class Login
{

    const TOKEN_COOKIE = 'usertoken';

    const TOKEN_COOKIE_TTL = 900; // 15 minutes

    public static function loginWithCredentials(string $email, string $password) : bool
    {

        // check email and password against these static values (for POC)
        if ('foo@bar.com' == $email && 'baz' == $password) {
            $userTokenExpire = time() + self::TOKEN_COOKIE_TTL;

            // create the user token
            $userToken = self::createUserToken($email, $userTokenExpire);

            // set the token as a cookie
            setcookie(self::TOKEN_COOKIE, $userToken, $userTokenExpire);

            return true;
        }

        return false;
    }

    public static function logout()
    {
        // overwrite the cookie with one that will expire immediately
        if (isset($_COOKIE[self::TOKEN_COOKIE])) {
            setcookie(self::TOKEN_COOKIE, '', -1);
        }
    }

    public static function createUserToken(string $email, int $expireTimestamp) : string
    {
        $tokenPayload = [
            'exp' => $expireTimestamp,
            'email' => $email,
        ];

        return JsonWebToken::generateToken($tokenPayload);
    }

    public static function isLoggedIn()
    {
        // if there is no token cookie they can't be logged in
        if (!isset($_COOKIE[self::TOKEN_COOKIE])) {
            return false;
        }

        // retrieve the payload from the token
        $tokenPayload = JsonWebToken::readToken($_COOKIE[self::TOKEN_COOKIE]);

        // If the token payload could not be retrieved they can't be logged in
        if (!$tokenPayload) {
            return false;
        }

        // verify the token isn't expired (in the event someone modified the cookie expiration)
        if ($tokenPayload['exp'] <= time()) {
            return false;
        }

        return true;
    }

}
