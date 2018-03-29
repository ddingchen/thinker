<?php

namespace Thinker\UCenter\Service;

class Service
{

    protected $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
