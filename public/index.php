<?php

require_once __DIR__ . '/../src/includes.php';

$isLoggedIn = JwtLoginPoc\Login::isLoggedIn();

?><!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>JWT Login POC</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="/css/styles.css" />
    </head>
    <body>
        <?php if ($isLoggedIn) : ?>
            <p>Logged In! <a href="/logout.php">Logout</a></p>
        <?php else: ?>
            <p>Not logged in. <a href="/login.php">Log In</a></p>
        <?php endif; ?>
        <p><a href="/protected.php">Protected content</a></p>
    </body>
</html>
