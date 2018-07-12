<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class GetRolesWithPermissionsByUserInAppTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getRolesWithPermissionsByUserInApp')->applyClient();

        $result = UCenterApi::getRolesWithPermissionsByUserInApp($accessToken = 'IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I', 1, 1);

        $this->assertCount(1, $result);
    }

}
