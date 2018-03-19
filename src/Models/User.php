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
        $model = app('auth')->getProvider()->createModel();
        $fieldName = $model->field_name_of_ucenter_id ?: 'ucenter_user_id';
        $appUser = $model->where($fieldName, $this->id)->firstOrFail();

        auth()->login($appUser);

        return $appUser;
    }

}
