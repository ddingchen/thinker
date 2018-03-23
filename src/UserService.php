<?php

namespace Thinker;

use Thinker\Facades\UCenterApi;

/**
* UserService
*/
class UserService
{

    private $accessToken;
    
    function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function find($userId)
    {
        return UCenterApi::getUserById($userId, $this->accessToken);
    }

}
