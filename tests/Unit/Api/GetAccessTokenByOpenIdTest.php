<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class GetAccessTokenByOpenIdTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getAccessTokenByOpenId')->applyClient();

        $result = UCenterApi::getAccessTokenByOpenId($openId = 123456, $accessToken = '123');

        $this->assertObjectHasAttribute('access_token', $result);
    }

    public function test_openid_is_invalid()
    {
        $this->clientFake
            ->mockCase('getAccessTokenByOpenId', 'openid_invalid')
            ->applyClient();

        $this->expectException(UCenterException::class);

        UCenterApi::getAccessTokenByOpenId($openId = 123456, $accessToken = '123');
    }

}
