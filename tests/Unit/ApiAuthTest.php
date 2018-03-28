<?php 

namespace Tests\Unit;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;


class ApiAuthTest extends TestCase
{

    private $apiAuth;

    protected function setUp()
    {
        parent::setUp();

        $this->apiAuth = UCenter::apiAuth();
    }

    public function test_it_returns_user_info_if_credentials_are_correct()
    {
        $fake = UCenterApi::fake();
        $fake->action('getUser')
            ->using(['user_id' => 123])->push();
        $fake->action('getAccessTokenByPassword')
            ->using(['access_token' => 'new token'])->push();

        $user = $this->apiAuth->user('chen', '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(123, $user->id);
        $this->assertInstanceOf(AccessToken::class, $user->accessToken());
        $this->assertEquals('new token', $user->access_token);
    }
    
}
