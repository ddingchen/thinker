<?php

namespace Tests\Feature;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class UCenterExceptionTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }
    
    public function test_it_returns_credentials_incorrect()
    {
        $this->clientFake
            ->mockCase('getAccessTokenByPassword', 'credentials_incorrect', [
                'username' => 'dc', 'password' => '123456'
            ])
            ->applyClient();

        try {
            UCenterApi::getAccessTokenByPassword('dc', '123');
        } catch(UCenterException $exception) {
            $this->assertEquals(401, $exception->statusCode);
            $this->assertEquals(401, $exception->code);
            $this->assertEquals("用户名或密码错误, The user credentials were incorrect.", $exception->message);
            $this->assertEquals('dc', $exception->data->username);
            $this->assertEquals('123456', $exception->data->password);
        }

    }

}
