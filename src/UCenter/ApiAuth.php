<?php

namespace Thinker\UCenter;

use Illuminate\Support\Facades\Cache;
use Thinker\Facades\UCenterApi;
use Thinker\Models\User;


class ApiAuth
{
    
    public function user($username, $password)
    {
        // authorize by credentials
        $accessToken = UCenterApi::getAccessTokenByPassword($username, $password);

        // retrieve user info
        $user = UCenterApi::getUser($accessToken);

        return User::mapToModel($user, $accessToken);
    }

}
