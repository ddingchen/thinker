<?php

namespace Thinker\Models;

use Thinker\Facades\UCenterApi;
use Thinker\UCenter\Service\AppService;
use Thinker\UCenter\Service\DomainService;
use Thinker\UCenter\Service\RoleService;
use Thinker\UCenter\Service\UserService;

class User
{

    public $id;

    public $username;

    public $email;

    public $phone;

    protected $access_token_model;

    public function __construct($data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }

    public function hold(AccessToken $accessToken)
    {
        $this->access_token_model = $accessToken;
        return $this;
    }

    public function accessToken()
    {
        return $this->access_token_model;
    }

    public function login()
    {
        $model = app('auth')->getProvider()->createModel();
        $fieldName = $model->field_name_of_ucenter_id ?: 'ucenter_user_id';
        $appUser = $model->where($fieldName, $this->id)->firstOrFail();

        auth()->login($appUser);

        return $appUser;
    }

    public function fresh()
    {
        $user = UCenterApi::getUser($this->access_token);
        foreach ($user as $field => $value) {
            $this->$field = $value;
        }
        return $this;
    }

    public function update($data)
    {
        $user = UCenterApi::updateUser($this->access_token, $data);
        foreach ($user as $field => $value) {
            $this->$field = $value;
        }
        return $this;
    }

    public function users()
    {
        return new UserService($this->accessToken());
    }

    public function domains()
    {
        return new DomainService($this->accessToken());
    }

    public function apps()
    {
        return new AppService($this->accessToken());
    }

    public function roles()
    {
        return new RoleService($this->accessToken());
    }

    public function __get($name)
    {
        if ($name == 'access_token') {
            if (!$model = $this->access_token_model) {
                return null;
            }
            return $model->access_token;
        }
    }

}
