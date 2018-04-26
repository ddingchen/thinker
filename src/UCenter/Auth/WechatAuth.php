<?php

namespace Thinker\UCenter\Auth;

use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;

class WechatAuth extends Auth
{

    public function user($openId, $adminAccessToken)
    {
        $accessToken = new AccessToken(
            UCenterApi::getAccessTokenByOpenId($openId, $adminAccessToken)
        );

        return $this->makeUserByAccessToken($accessToken);
    }

}
