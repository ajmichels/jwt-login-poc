<?php

require __DIR__ . '/../vendor/autoload.php';

$response = Ajmichels\JwtLoginPoc\Application::handleRequest();
Ajmichels\JwtLoginPoc\Application::handleResponse($response);
