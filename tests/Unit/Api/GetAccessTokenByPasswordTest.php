<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class GetAccessTokenByPasswordTest extends TestCase
{
    
    public function test_it_returns_ok()
    {
        UCenterApi::fake();

        $result = UCenterApi::GetAccessTokenByPassword('dc', '123');

        $this->assertObjectHasAttribute('access_token', $result);
    }

    public function test_it_returns_credentials_incorrect()
    {
        $fake = UCenterApi::fake();
        $fake->action('GetAccessTokenByPassword')
            ->expect('credentials_incorrect')->push();

        $this->expectException(UCenterException::class);

        $result = UCenterApi::GetAccessTokenByPassword('dc', '123');
    }
    
}
