<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;


class GetDomainByIdTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }
    
    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getDomainById')->applyClient();

        $result = UCenterApi::getDomainById(1, $accessToken = 'access_token');

        $this->assertObjectHasAttribute('domain', $result);
    }

    public function test_it_returns_none()
    {
        $this->clientFake->mockCase('getDomainById', 'none')->applyClient();

        $result = UCenterApi::getDomainById(1, $accessToken = 'access_token');

        $this->assertNull($result);
    }

}
