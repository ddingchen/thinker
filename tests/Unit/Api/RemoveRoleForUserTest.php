<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class RemoveRoleForUserTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_returns_ok()
    {
        $this->clientFake->mock('removeRoleForUser')->applyClient();

        $result = UCenterApi::removeRoleForUser(1, 'admin', 1, $accessToken = 'access_token');

        $this->assertObjectHasAttribute('role_name', $result);
    }

    public function test_it_returns_role_invalid()
    {
        $this->clientFake
            ->mockCase('removeRoleForUser', 'role_invalid')
            ->applyClient();

        $this->expectException(UCenterException::class);

        $result = UCenterApi::removeRoleForUser(1, 'admin', 1, $accessToken = 'access_token');
    }

}
