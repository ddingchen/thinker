<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;

class GetAccessTokenByOpenIdTest extends TestCase
{

    public function test_it_returns_ok()
    {
        UCenterApi::fake();

        $result = UCenterApi::getAccessTokenByOpenId($openId = 123456, $accessToken = '123');

        $this->assertObjectHasAttribute('access_token', $result);
    }

}
