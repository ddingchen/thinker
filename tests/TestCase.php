<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Orchestra\Testbench\TestCase as TestbenchTest;
use Tests\EmptyExceptionHandler;
use Thinker\Models\AccessToken;

class TestCase extends TestbenchTest
{

    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set(
            'auth.providers.users.model',
            'Illuminate\Foundation\Auth\User'
        );
        $app['config']->set('ucenter', []);
        $app['config']->set('app.log', 'single');
    }

    protected function getPackageProviders($app)
    {
        return [
            'Thinker\Providers\UCenterServiceProvider',
        ];
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new EmptyExceptionHandler);
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

    protected function fakeToken()
    {
        return new AccessToken([
            'access_token' => 'fake token',
            'token_type' => 'Bearer',
            'expires_in' => 7200,
            'refresh_token' => 'fake refresh token',
        ]);
    }

}
