<?php 

namespace Thinker\UCenter;

use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;
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
        $accessToken = UCenterApi::getAccessTokenByCode($code);
        $user = UCenterApi::getUser($accessToken);
        return User::mapToModel($user, $accessToken);
    }
}
