<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class BindWechatTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake;
    }

    public function test_it_returns_OK()
    {
        $this->clientFake->mock('bindWechat')->applyClient();

        $result = UCenterApi::bindWechat($openid = 123456, $accessToken = '123456');

        $this->assertObjectHasAttribute('user_id', $result);
    }

    public function test_openid_exists()
    {
        $this->clientFake
            ->mockCase('bindWechat', 'openid_exists')
            ->applyClient();

        $this->expectException(UCenterException::class);

        UCenterApi::bindWechat($openid = 123456, $accessToken = '123456');
    }

}
