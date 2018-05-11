<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class RefreshAccessTokenTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }
    
    public function test_it_returns_ok()
    {
        $this->clientFake->mock('refreshAccessToken')->applyClient();

        $result = UCenterApi::refreshAccessToken($code = 123456);

        $this->assertObjectHasAttribute('access_token', $result);
    }

}
