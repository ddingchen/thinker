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
        UCenterApi::fake();

        $user = $this->apiAuth->user($username = 'chen', $password = '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(123, $user->id);
        $this->assertInstanceOf(AccessToken::class, $user->accessToken());
        $this->assertEquals('JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA', $user->access_token);
    }
    
}
