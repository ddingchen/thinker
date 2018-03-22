<?php

namespace Tests\Feature\AppUser;

use Tests\TestCase;
use Thinker\Models\User;
use Thinker\Testing\User as AppUser;
use Thinker\Testing\UserWithCustomUCenterId as AppUserWithCustomUCenterId;


class UserWithDefaultUCenterIdTest extends TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set(
            'auth.providers.users.model', 
            AppUser::class
        );
    }

    public function test_it_login_as_an_application_user()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom('tests/database/migrations');

        AppUser::forceCreate([
            'name' => 'chen.d',
            'email' => 'chen@d.com',
            'password' => bcrypt(123456),
            'ucenter_user_id' => 123,
        ]);

        $user = new User(['id' => 123]);

        $user->login();

        $this->assertTrue(auth()->check());
        $this->assertEquals(123, auth()->user()->ucenter_user_id);
    }

}
