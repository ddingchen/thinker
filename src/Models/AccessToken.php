<?php

namespace Thinker\Models;

use Thinker\Facades\UCenterApi;

class AccessToken
{
    
    public $access_token;

    public $refresh_token;

    function __construct($data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }

    public function refresh()
    {
        $accessTokenData = UCenterApi::refreshAccessToken($this->refresh_token);

        foreach ($accessTokenData as $field => $value) {
            $this->$field = $value;
        }

        return $this;
    }

}
