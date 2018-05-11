<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class GetRolesInDomainTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getRolesInDomain', [
            'roles' => [
                '10' => [],
                '11' => [],
            ],
        ])->applyClient();

        $result = UCenterApi::getRolesInDomain(1, 'access_token');

        $this->assertCount(2, $result);
    }

}
