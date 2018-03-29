<?php

namespace Thinker\UCenter\Auth;

use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\UCenter\Auth\Auth;

class ApiAuth extends Auth
{

    public function user($username, $password)
    {
        $accessToken = new AccessToken(
            UCenterApi::getAccessTokenByPassword($username, $password)
        );

        return $this->makeUserByAccessToken($accessToken);
    }

}
