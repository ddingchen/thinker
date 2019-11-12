<?php

namespace Thinker;

use Thinker\UCenter\Auth\ApiAuth;
use Thinker\UCenter\Auth\PasswordReset;
use Thinker\UCenter\Auth\Register;
use Thinker\UCenter\Auth\WebAuth;
use Thinker\UCenter\Auth\WechatAuth;

class UCenter
{

    public function webAuth()
    {
        return new WebAuth;
    }

    public function apiAuth()
    {
        return new ApiAuth;
    }

    public function wechatAuth()
    {
        return new WechatAuth;
    }

    public function register()
    {
        return new Register;
    }

    public function passwordReset()
    {
        return new PasswordReset;
    }

}
