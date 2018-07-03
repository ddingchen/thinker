<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class ForceBindWechatTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake;
    }

    public function test_it_returns_OK()
    {
        $this->clientFake->mock('forceBindWechat')->applyClient();

        $result = UCenterApi::forceBindWechat($accessToken = '123456', $openid = 123456, '123456');

        $this->assertObjectHasAttribute('user_id', $result);
    }

    public function test_openid_exists()
    {
        $this->clientFake
            ->mockCase('forceBindWechat', 'openid_exists')
            ->applyClient();

        $this->expectException(UCenterException::class);

        UCenterApi::forceBindWechat($accessToken = '123456', $openid = 123456, '123456');
    }

}
