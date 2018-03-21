<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Exceptions\UCenterException;

class AuthorizeTest extends TestCase
{
    
    public function test_it_returns_url_of_ucenter_authorize_page()
    {
        UCenterApi::loadConfig([
            'root' => 'http://api.com',
            'client_id' => '123456',
            'client_secret' => 'abc',
            'redirect_uri' => 'callback_url',
        ]);

        $this->assertEquals(
            "http://api.com/oauth/authorize?client_id=123456&redirect_uri=callback_url&response_type=code",
            UCenterApi::urlOfAuthorizePage()
        );
    }

    public function test_it_returns_access_token_by_authorized_code()
    {
        $this->mockHttpClient('{
            "code": 0,
            "message": "获取access_token成功",
            "data": {
                "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
                "token_type": "Bearer",
                "expires_in": 7200,
                "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
            }
        }');

        $result = UCenterApi::getAccessTokenByCode($code = 123456);

        $this->assertEquals(
            "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
            $result->access_token
        );
    }

    public function test_it_returns_access_token_by_password()
    {
        $this->mockHttpClient('{
            "code": 0,
            "message": "获取access_token成功",
            "data": {
                "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
                "token_type": "Bearer",
                "expires_in": 7200,
                "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
            }
        }');

        $result = UCenterApi::getAccessTokenByPassword('chen', '123456');

        $this->assertEquals(
            "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
            $result->access_token
        );
    }

    public function test_credentials_are_incorrect()
    {
        $this->mockHttpClient('{
            "code": 401,
            "message": "用户名或密码错误, The user credentials were incorrect.",
            "data": {}
        }', 401);

        $this->expectException(UCenterException::class);

        UCenterApi::getAccessTokenByPassword('chen', '123456');
    }

    public function test_it_refreshes_access_token()
    {
        $this->mockHttpClient('{
            "code": 0,
            "message": "获取access_token成功",
            "data": {
                "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
                "token_type": "Bearer",
                "expires_in": 7200,
                "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
            }
        }');

        $result = UCenterApi::refreshAccessToken('IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertEquals(
            "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
            $result->access_token
        );
    }

    public function test_it_returns_url_of_another_application()
    {
        UCenterApi::loadConfig([
            'root' => 'http://api.com',
            'client_id' => '123456',
            'client_secret' => 'abc',
            'redirect_uri' => 'callback_url',
        ]);

        $this->assertEquals(
            "http://api.com/api/sso/redirect?access_token=123&app_id=456&domain_id=789",
            UCenterApi::urlOfApplication($appId = 456, $domainId = 789, $accessToken = 123)
        );
    }

}
