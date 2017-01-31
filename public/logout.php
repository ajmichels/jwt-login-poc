<?php

require_once __DIR__ . '/../src/includes.php';

JwtLoginPoc\Login::logout();

http_response_code(303);
header('Location: /index.php');
