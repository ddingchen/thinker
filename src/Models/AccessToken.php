<?php

namespace Thinker\Models;

use Tests\TestCase;


class AccessToken extends TestCase
{
    
    public $access_token;

    function __construct($data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }

}
