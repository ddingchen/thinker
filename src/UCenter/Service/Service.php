<?php

namespace Thinker\UCenter\Service;

use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;

class Service
{

    protected $accessToken;

    protected $ucenterApi;

    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken->access_token;
        $this->ucenterApi = UCenterApi::withRefreshToken($accessToken->refresh_token);
    }
}
