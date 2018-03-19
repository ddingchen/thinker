<?php 

namespace Thinker\UCenter;

use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;

class WebAuth
{

    public function check()
    {
        return $this->user() && true;
    }

    public function redirect()
    {
        return redirect(UCenterApi::urlOfAuthorizePage());
    }

    public function user($code = null)
    {
        // retrieve user info from cache
        if (!$code) {
            return session()->get('ucenter.user');
        }

        // retrieve user info by authorized code
        $accessToken = UCenterApi::getAccessTokenByCode($code);
        $user = UCenterApi::getUser($accessToken);

        // cache user info
        session()->put('ucenter.user', $user);

        return $user;
    }
}
