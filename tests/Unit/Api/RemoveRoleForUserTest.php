<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class RemoveRoleForUserTest extends TestCase
{

    public function test_it_returns_ok()
    {
        UCenterApi::fake();

        $result = UCenterApi::removeRoleForUser(1, 'admin', 1, $accessToken = 'access_token');

        $this->assertObjectHasAttribute('role_name', $result);
    }

    public function test_it_returns_role_invalid()
    {
        $fake = UCenterApi::fake();
        $fake->action('removeRoleForUser')
            ->expect('role_invalid')
            ->push();

        $this->expectException(UCenterException::class);

        $result = UCenterApi::removeRoleForUser(1, 'admin', 1, $accessToken = 'access_token');
    }

}
