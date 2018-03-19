<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Models\User;
use Thinker\Testing\User as AppUser;


class UserTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    public function test_it_login_as_an_application_user()
    {
        AppUser::forceCreate([
            'name' => 'chen.d',
            'email' => 'chen@d.com',
            'password' => bcrypt(123456),
            'ucenter_user_id' => 123,
        ]);

        $user = new User;
        $user->id = 123;
        $user->username = 'chen.d';

        $user->login();

        $this->assertTrue(auth()->check());
        $this->assertEquals(123, auth()->user()->ucenter_user_id);
    }

}
