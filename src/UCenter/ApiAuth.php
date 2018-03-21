<?php

namespace Thinker\UCenter;

use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;

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
