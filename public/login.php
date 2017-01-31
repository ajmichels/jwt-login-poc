<?php

require_once __DIR__ . '/../src/includes.php';

$baseUrlPattern = '/^(http|https):\/\/' . str_replace('.', '\.', $_SERVER['HTTP_HOST']) . '/i';
$referrer = isset($_POST['redirect']) ? $_POST['redirect'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/index.php');

if (preg_match('/^\//', $referrer) || preg_match($baseUrlPattern, $referrer)) {
    $redirect = $referrer;
} else {
    $redirect = '/index.php';
}

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if('' == $email || '' == $password) {
        http_response_code(400);
        $errorMessage = 'Both email and password must be provided.';
    } elseif (JwtLoginPoc\Login::loginWithCredentials($email, $password)) {
        http_response_code(303);
        header('Location: ' . $redirect);
    } else {
        http_response_code(400);
        $errorMessage = 'Unable to authenticate with the provided credentials.';
    }
}

?><!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login | JWT Login POC</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="/css/styles.css" />
    </head>
    <body>
        <form action="" method="post" class="login">
            <input name="redirect" type="hidden" value="<?php echo $redirect; ?>" />
            <label for="email-input">Email</label>
            <input id="email-input" name="email" type="email" required />
            <label for="password-input">Password</label>
            <input id="password-input" name="password" type="password" required />
            <button type="submit">Log In</button>
        </form>
        <?php if (isset($errorMessage)) : ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </body>
</html>
