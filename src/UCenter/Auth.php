<?php

namespace Thinker\UCenter;

use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;

abstract class Auth
{

    protected function makeUserByAccessToken(AccessToken $accessToken)
    {
        $userData = $this->adaptUserModel(
            UCenterApi::getUser($accessToken->access_token)
        );

        return (new User($userData))->hold($accessToken);
    }

    protected function adaptUserModel($data)
    {
        $data->id = $data->user_id;
        return $data;
    }

}
