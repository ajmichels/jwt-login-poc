<?php

namespace Ajmichels\JwtLoginPoc;

class Response
{

    const STATUS_OK = 200;
    const STATUS_SEE_OTHER = 303;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_NOT_FOUND = 404;

    private $status;

    private $body;

    private $location;

    public function __construct($status, $body)
    {
        $this->status = $status;
        $this->body = $body;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

}
