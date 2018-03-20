<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Thinker\Middleware\ApiAuth;
use Thinker\Models\User;
use Illuminate\Foundation\Auth\User as AppUser;


class ApiAuthMiddlewareTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        Route::any('test', function () { return 'test'; })
            ->middleware(['api', ApiAuth::class]);
    }

    public function test_it_resolves_the_user_of_a_request()
    {
        $user = $this->mockUser();
        Cache::put('api-session.123456', $user, 1);

        $response = $this->postJson('test', [
            'sess_key' => '123456'
        ]);

        $this->assertTrue(auth()->check());
    }

    public function test_sess_key_passed_by_cookie()
    {
        $user = $this->mockUser();
        Cache::put('api-session.123456', $user, 1);

        $this->call('GET', 'test', [], $cookies = [
            'sess_key' => '123456'
        ]);

        $this->assertTrue(auth()->check());
    }

    public function test_sess_key_passed_by_meta()
    {
        $user = $this->mockUser();
        Cache::put('api-session.123456', $user, 1);

        $this->get('test', [
            'sess_key' => '123456'
        ]);

        $this->assertTrue(auth()->check());
    }

    public function test_it_fails_to_verify_a_request()
    {
        $response = $this->postJson('test', [
            'sess_key' => '123456'
        ])->assertStatus(401);
    }

    protected function mockUser()
    {
        // user model in business application
        AppUser::forceCreate([
            'name' => 'chen.d',
            'email' => 'chen@d.com',
            'password' => bcrypt(123456),
            'ucenter_user_id' => 123,
        ]);

        // ucenter user model
        $user = new User;
        $user->id = 123;
        return $user;
    }
    
}
