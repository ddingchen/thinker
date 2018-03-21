<?php 

namespace Thinker\UCenter;

use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;

class WebAuth
{

    public function redirect()
    {
        return redirect(UCenterApi::urlOfAuthorizePage());
    }

    public function user($code)
    {
        // retrieve user info by authorized code
        $accessTokenData = UCenterApi::getAccessTokenByCode($code);
        $userData = UCenterApi::getUser($accessTokenData->access_token);
        
        $user = new User($this->adaptUserModel($userData));
        $accessToken = new AccessToken($accessTokenData);
        $user->hold($accessToken);
        return $user;
    }

    protected function adaptUserModel($data)
    {
        $data->id = $data->user_id;
        return $data;
    }
}
