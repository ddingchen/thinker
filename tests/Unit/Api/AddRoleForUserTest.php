<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class AddRoleForUserTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_returns_ok()
    {
        $this->clientFake
            ->mock('addRoleForUser', [
                'roles' => [
                    'admin',
                    'manager',
                ],
            ])->applyClient();

        $result = UCenterApi::addRoleForUser(1, 'admin', 1, 'access_token');

        $this->assertCount(2, $result);
    }

    public function test_it_returns_role_existed()
    {
        $this->clientFake
            ->mockCase('addRoleForUser', 'role_existed')
            ->applyClient();

        $this->expectException(UCenterException::class);

        UCenterApi::addRoleForUser(1, 'admin', 1, 'access_token');
    }

    public function test_it_returns_role_invalid()
    {
        $this->clientFake
            ->mockCase('addRoleForUser', 'role_invalid')
            ->applyClient();

        $this->expectException(UCenterException::class);

        UCenterApi::addRoleForUser(1, 'admin', 1, 'access_token');
    }

}
