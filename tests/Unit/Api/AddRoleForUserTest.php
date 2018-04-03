<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class AddRoleForUserTest extends TestCase
{

    public function test_it_returns_ok()
    {
        $fake = UCenterApi::fake();
        $fake->action('addRoleForUser')
            ->using([
                'roles' => [
                    'admin',
                    'manager',
                ],
            ])
            ->push();

        $result = UCenterApi::addRoleForUser(1, 'admin', 1, 'access_token');

        $this->assertCount(2, $result);
    }

    public function test_it_returns_role_existed()
    {
        $fake = UCenterApi::fake();
        $fake->action('addRoleForUser')
            ->expect('role_existed')
            ->push();

        $this->expectException(UCenterException::class);

        UCenterApi::addRoleForUser(1, 'admin', 1, 'access_token');
    }

    public function test_it_returns_role_invalid()
    {
        $fake = UCenterApi::fake();
        $fake->action('addRoleForUser')
            ->expect('role_invalid')
            ->push();

        $this->expectException(UCenterException::class);

        UCenterApi::addRoleForUser(1, 'admin', 1, 'access_token');
    }

}
