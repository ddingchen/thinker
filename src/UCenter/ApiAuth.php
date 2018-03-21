<?php

namespace Thinker\UCenter;

use Illuminate\Support\Facades\Cache;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;


class ApiAuth
{
    
    public function user($username, $password)
    {
        // authorize by credentials
        $accessTokenData = UCenterApi::getAccessTokenByPassword($username, $password);

        // retrieve user info
        $userData = UCenterApi::getUser($accessTokenData->access_token);

        $user = new User($this->adaptUserModel($userData));
        $user->hold(new AccessToken($accessTokenData));
        return $user;
    }

    protected function adaptUserModel($data)
    {
        $data->id = $data->user_id;
        return $data;
    }

}
