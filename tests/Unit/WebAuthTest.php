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
        $fake = UCenterApi::fake();
        $fake->action('getUser')->expect('ok')
            ->using(['user_id' => '123'])->push();
        $fake->action('getAccessTokenByCode')->expect('ok')
            ->using(['access_token' => 'abc'])->push();

        $user = $this->webAuth->user($authorizedCode = '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('123', $user->id);
        $this->assertInstanceOf(AccessToken::class, $user->accessToken());
        $this->assertEquals('abc', $user->access_token);
    }

}
