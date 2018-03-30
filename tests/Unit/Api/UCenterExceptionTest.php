<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class UCenterExceptionTest extends TestCase
{
    
    public function test_it_returns_credentials_incorrect()
    {
        $fake = UCenterApi::fake();
        $fake->action('GetAccessTokenByPassword')
            ->expect('credentials_incorrect')
            ->using(['username' => 'dc', 'password' => '123456'])
            ->push();

        try {
            UCenterApi::GetAccessTokenByPassword('dc', '123');
        } catch(UCenterException $exception) {
            $this->assertEquals(401, $exception->statusCode);
            $this->assertEquals(401, $exception->code);
            $this->assertEquals("用户名或密码错误, The user credentials were incorrect.", $exception->message);
            $this->assertEquals('dc', $exception->data->username);
            $this->assertEquals('123456', $exception->data->password);
        }

    }

}
