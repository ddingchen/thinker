<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class GetAccessTokenByCodeTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getAccessTokenByCode')->applyClient();

        $result = UCenterApi::getAccessTokenByCode($code = 123456);

        $this->assertObjectHasAttribute('access_token', $result);
    }

}
