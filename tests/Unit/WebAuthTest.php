<?php

namespace Tests\Unit;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;


class WebAuthTest extends TestCase
{

    private $webAuth;

    protected function setUp()
    {
        parent::setUp();

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
        UCenterApi::fake();
        $userData = UCenterApi::getUser();
        $accessTokenData = UCenterApi::getAccessTokenByCode('123456');

        $user = $this->webAuth->user($authorizedCode = '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData->user_id, $user->id);
        $this->assertInstanceOf(AccessToken::class, $user->accessToken());
        $this->assertEquals($accessTokenData->access_token, $user->access_token);
    }

}
