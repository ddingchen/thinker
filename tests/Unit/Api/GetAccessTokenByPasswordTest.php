<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class GetAccessTokenByPasswordTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }
    
    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getAccessTokenByPassword')->applyClient();

        $result = UCenterApi::getAccessTokenByPassword('dc', '123');

        $this->assertObjectHasAttribute('access_token', $result);
    }

    public function test_it_returns_credentials_incorrect()
    {
        $this->clientFake->mockCase('getAccessTokenByPassword', 'credentials_incorrect')->applyClient();

        $this->expectException(UCenterException::class);

        $result = UCenterApi::GetAccessTokenByPassword('dc', '123');
    }
    
}
