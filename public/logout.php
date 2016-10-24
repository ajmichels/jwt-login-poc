<?php

require_once __DIR__ . '/../vendor/autoload.php';

JwtLoginPoc\Login::logout();

http_response_code(303);
header('Location: /index.php');
