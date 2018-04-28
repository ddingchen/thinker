<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class BindWechatTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->fake = UCenterApi::fake();
    }

    public function test_it_returns_OK()
    {
        $result = UCenterApi::bindWechat($openid = 123456, $accessToken = '123456');

        $this->assertObjectHasAttribute('user_id', $result);
    }

    public function test_openid_exists()
    {
        $this->fake->action('bindWechat')
            ->expect('openid_exists')
            ->push();

        $this->expectException(UCenterException::class);

        UCenterApi::bindWechat($openid = 123456, $accessToken = '123456');
    }

}
