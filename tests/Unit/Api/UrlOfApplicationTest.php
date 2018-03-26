<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Exceptions\UCenterException;

class UrlOfApplicationTest extends TestCase
{

    public function test_it_returns_ok()
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
