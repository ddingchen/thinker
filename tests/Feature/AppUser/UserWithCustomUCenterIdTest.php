<?php

namespace Tests\Feature\AppUser;

use Tests\TestCase;
use Thinker\Models\User;
use Thinker\Testing\User as AppUser;
use Thinker\Testing\UserWithCustomUCenterId as AppUserWithCustomUCenterId;


class UserWithCustomUCenterIdTest extends TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set(
            'auth.providers.users.model', 
            AppUserWithCustomUCenterId::class
        );
    }

    public function test_field_name_of_user_may_be_custom()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom('tests/database/migrations_with_custom_field_name');

        AppUserWithCustomUCenterId::forceCreate([
            'name' => 'chen.d',
            'email' => 'chen@d.com',
            'password' => bcrypt(123456),
            'uc_uid' => 123,
        ]);

        $user = new User([
            'id' => 123,
        ]);

        $user->login();

        $this->assertEquals(123, auth()->user()->ucenter_user_id);
    }

}
