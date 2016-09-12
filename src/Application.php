<?php

namespace Ajmichels\JwtLoginPoc;

class Application
{

    const VIEW_PATH = __DIR__ . '/view/';

    public static function handleRequest()
    {
        $uri = static::getUri();
        $method = static::getMethod();

        switch ($uri) {

            default:
                return static::notFound();

            case '/':
                $content = static::render('layout', [
                    'content' => static::render('index'),
                ]);

                return static::ok($content);

            case '/protected':
                if (!static::isAuthenticated()) {
                    return static::unauthorized();
                }

                $content = static::render('layout', [
                    'content' => static::render('protected'),
                ]);

                return static::ok($content);

            case '/login':
                if ('POST' == $method) {
                    if (static::authenticate()) {
                        $redirect = array_key_exists('login-redirect', $_COOKIE) ? $_COOKIE['login-redirect'] : '/';
                        // TODO: sanitize to remove absolute paths
                        return static::seeOther($redirect);
                    } else {
                        return static::unauthorized();
                    }
                }

                $content = static::render('layout', [
                    'content' => static::render('login'),
                ]);

                return static::ok($content);

        }
    }

    public static function handleResponse(Response $response)
    {
        http_response_code($response->getStatus());
        echo $response->getBody();
        $location = $response->getLocation();
        if ($location) {
            header('Location: ' . $location);
        }
        exit();
    }

    private static function getUri()
    {
        return urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    private static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function render($__template, array $__data = [])
    {
        extract($__data);
        ob_start();
        include self::VIEW_PATH . $__template . '.phtml';
        return ob_get_clean();
    }

    private static function isAuthenticated()
    {
        // TODO: check for JWT token cookie
        return false;
    }

    private static function authenticate()
    {
        $username = $_POST['username'] ?: null;
        $password = $_POST['password'] ?: null;

        if ('user' !== $username || 'pass' !== $password) {
            return false;
        }

        // TODO: create JWT token cookie

        return true;
    }

    private static function ok($body)
    {
        return new Response(Response::STATUS_OK, $body);
    }

    private static function notFound()
    {
        $content = static::render('layout', [
            'content' => static::render('404'),
        ]);

        return new Response(Response::STATUS_NOT_FOUND, $content);
    }

    private static function unauthorized()
    {
        $content = static::render('layout', [
            'content' => static::render('401'),
        ]);

        return new Response(Response::STATUS_UNAUTHORIZED, $content);
    }

    private static function seeOther($location)
    {
        return (new Response(Response::STATUS_SEE_OTHER, null))->setLocation($location);
    }

}
