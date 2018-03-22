<?php

namespace Tests\Feature;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Auth\User as AppUser;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Mockery;
use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Middleware\OAuth;
use Thinker\UCenter\WebAuth;


class OAuthCheckTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->app->make(Kernel::class)
            ->pushMiddleware(StartSession::class);

        Route::get('test', function () { return 'test'; })
            ->middleware(OAuth::class);
    }

    public function test_it_redirect_to_authorize_page_if_the_user_hasnot_authorized()
    {
        UCenterApi::fake();

        $this->get('test')
            ->assertRedirect('url_of_authorize_page');
    }

    public function test_it_redirect_back_if_authorized_successfully()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom('tests/database/migrations');
        UCenterApi::fake();
        session()->put('pre_auth_url', 'http://target.url');
        AppUser::forceCreate([
            'name' => 'chen.d',
            'email' => 'chen@d.com',
            'password' => bcrypt(123456),
            'ucenter_user_id' => 123,
        ]);

        $response = $this->get('test?code=123456');

        $response->assertRedirect('http://target.url');
        $this->assertTrue(auth()->check());
    }

}
