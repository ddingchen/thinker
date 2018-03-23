<?php

namespace Thinker\Models;

class AccessToken
{
    
    public $access_token;

    function __construct($data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }

}
