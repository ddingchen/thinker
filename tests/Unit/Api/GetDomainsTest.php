<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;


class GetDomainsTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }
    
    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getDomains')->applyClient();

        $result = UCenterApi::getDomains($accessToken = 'IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertObjectHasAttribute('id', $result[0]);
    }

    public function test_it_returns_none()
    {
        $this->clientFake->mockCase('getDomains', 'none')->applyClient();

        $result = UCenterApi::getDomains($accessToken = 'IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertCount(0, $result);
    }

}
