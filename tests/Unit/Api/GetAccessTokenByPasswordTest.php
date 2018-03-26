<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class GetAccessTokenByPasswordTest extends TestCase
{
    
    public function test_it_returns_ok()
    {
        $this->mockApiDemo('GetAccessTokenByPassword', 'ok');

        $result = UCenterApi::GetAccessTokenByPassword('dc', '123');

        $this->assertObjectHasAttribute('access_token', $result);
    }

    public function test_it_returns_credentials_incorrect()
    {
        $this->mockApiDemo('GetAccessTokenByPassword', 'credentials_incorrect');

        $this->expectException(UCenterException::class);

        $result = UCenterApi::GetAccessTokenByPassword('dc', '123');
    }
    
}
