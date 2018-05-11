<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;
use Thinker\Testing\HttpClientFake;

class WebAuthTest extends TestCase
{

    private $webAuth;

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
        $this->webAuth = UCenter::webAuth();
    }

    public function test_it_redirect_authorize_page()
    {
        $response = $this->webAuth->redirect();

        TestResponse::fromBaseResponse($response)
            ->assertRedirect(UCenterApi::urlOfAuthorizePage());
    }

    public function test_it_returns_user_info_if_authorized_code_is_valid()
    {
        $this->clientFake
            ->mock('getAccessTokenByCode', ['access_token' => 'abc'])
            ->mock('getUser', ['user_id' => '123'])
            ->applyClient();

        $user = $this->webAuth->user($authorizedCode = '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('123', $user->id);
        $this->assertInstanceOf(AccessToken::class, $user->accessToken());
        $this->assertEquals('abc', $user->access_token);
    }

}
