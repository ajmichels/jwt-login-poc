<?php

require_once __DIR__ . '/../src/includes.php';

$isLoggedIn = JwtLoginPoc\Login::isLoggedIn();

    http_response_code(401);

?><!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Protected Content | JWT Login POC</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="/css/styles.css" />
    </head>
    <body>
        <?php if (!$isLoggedIn) : ?>
            <p class="error">You are not authorized to view this page. <a href="/login.php">Log In.</a></p>
        <?php else: ?>
            <p>protected content</p>
        <?php endif; ?>
    </body>
</html>
