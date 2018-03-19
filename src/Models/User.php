<?php

namespace Thinker\Models;

use Thinker\Testing\User as AppUser;


class User
{

    public $id;

    public $username;

    public $email;

    public $phone;

    public $accessToken;

    public static function mapToModel($data, $accessToken)
    {
        $user = new User;
        $user->id = $data->user_id;
        $user->username = $data->username;
        $user->email = $data->email;
        $user->phone = $data->phone;
        $user->accessToken = $accessToken;
        return $user;
    }

    public function login()
    {
        $appUser = AppUser::where('ucenter_user_id', $this->id)->firstOrFail();

        auth()->login($appUser);

        return $appUser;
    }

}
