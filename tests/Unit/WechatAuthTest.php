<?php

namespace Tests\Unit;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\TestResponse;
use Mockery;
use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;


class WechatAuthTest extends TestCase
{

    private $wechatAuth;

    protected function setUp()
    {
        parent::setUp();

        $this->wechatAuth = UCenter::wechatAuth();
    }

    public function test_it_returns_user_info_if_openid_is_valid()
    {
        $fake = UCenterApi::fake();
        $fake->action('getUser')
            ->using(['user_id' => 123])->push();
        $fake->action('getAccessTokenByOpenId')
            ->using(['access_token' => 'new token'])->push();

        $user = $this->wechatAuth->user($openId = '123456', $adminAccessToken = '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(123, $user->id);
        $this->assertInstanceOf(AccessToken::class, $user->accessToken());
        $this->assertEquals('new token', $user->access_token);
    }

}
