<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;

class RefreshAccessTokenTest extends TestCase
{
    
    public function test_it_returns_ok()
    {
        $this->mockApiDemo('RefreshAccessToken', 'ok');

        $result = UCenterApi::refreshAccessToken($code = 123456);

        $this->assertObjectHasAttribute('access_token', $result);
    }

}
