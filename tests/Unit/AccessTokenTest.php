<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Models\AccessToken;

class AccessTokenTest extends TestCase
{
    
    protected function setUp()
    {
        parent::setUp();

        $accessToken = new AccessToken(['access_token' => '123']);
        $this->accessToken = $accessToken;
    }

    public function test_props_are_correctly_set()
    {
        $this->assertEquals(123, $this->accessToken->access_token);
    }

}
