<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;

class UrlOfAuthorizePageTest extends TestCase
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
            "http://api.com/oauth/authorize?client_id=123456&redirect_uri=callback_url&response_type=code",
            UCenterApi::urlOfAuthorizePage()
        );
    }
}
