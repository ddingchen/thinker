<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class GetAccessTokenByOpenIdTest extends TestCase
{

    public function test_it_returns_ok()
    {
        UCenterApi::fake();

        $result = UCenterApi::getAccessTokenByOpenId($openId = 123456, $accessToken = '123');

        $this->assertObjectHasAttribute('access_token', $result);
    }

    public function test_openid_is_invalid()
    {
        $fake = UCenterApi::fake();
        $fake->action('getAccessTokenByOpenId')
            ->expect('openid_invalid')
            ->push();

        $this->expectException(UCenterException::class);
        
        UCenterApi::getAccessTokenByOpenId($openId = 123456, $accessToken = '123');
    }

}
