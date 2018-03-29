<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\UCenter\Service\AppService;
use Thinker\UCenter\Service\DomainService;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Models\User;
use Thinker\UCenter\Service\RoleService;

class UserTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $user = new User([
            'id' => 123,
            'username' => 'chen.d',
            'email' => 'chen@ding.com',
            'phone' => 456,
        ]);
        $user->hold(new AccessToken(['access_token' => '789']));
        $this->user = $user;
    }

    public function test_props_are_correctly_set()
    {
        $this->assertEquals(123, $this->user->id);
        $this->assertEquals('chen.d', $this->user->username);
        $this->assertEquals('chen@ding.com', $this->user->email);
        $this->assertEquals(456, $this->user->phone);
    }

    public function test_it_returns_access_token_model()
    {
        $this->assertInstanceOf(AccessToken::class, $this->user->accessToken());
    }

    public function test_it_returns_access_token_string()
    {
        $this->assertEquals(789, $this->user->access_token);
    }

    public function test_it_may_reload_users_profile()
    {
        $fake = UCenterApi::fake();
        $fake->action('getUser')
            ->using(['user_id' => 123])
            ->push();

        $this->user->fresh();

        $this->assertEquals(123, $this->user->id);
    }

    public function test_it_may_update_props()
    {
        $fake = UCenterApi::fake();
        $fake->action('updateUser')
            ->using([
                'email' => 'ding@chen.com',
                'username' => 'chen.d'
            ])
            ->push();
        
        $this->user->update([
            'username' => 'chen.d',
            'email' => 'ding@chen.com',
        ]);

        $this->assertEquals('chen.d', $this->user->username);
        $this->assertEquals('ding@chen.com', $this->user->email);
    }

    public function test_it_returns_domain_service()
    {
        $this->assertInstanceOf(DomainService::class, $this->user->domains());
    }

    public function test_it_returns_app_service()
    {
        $this->assertInstanceOf(AppService::class, $this->user->apps());
    }

    public function test_it_returns_role_service()
    {
        $this->assertInstanceOf(RoleService::class, $this->user->roles());
    }

}
