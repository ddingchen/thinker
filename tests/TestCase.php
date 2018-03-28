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
            'Orchestra\Database\ConsoleServiceProvider',
        ];
    }

    protected function mockApiDemo($action, $case = 'ok', $customData = [])
    {
        $this->app->singleton(Client::class, function ($app) use ($action, $case, $customData) {
            return makeApiDemoClient($action, $case, $customData);
        });
    }

    protected function mockHttpClient($result, $statusCode = 200)
    {
        $this->app->singleton(Client::class, function ($app) {
            return makeHttpClient($result, $statusCode);
        });
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler
        {
            public function __construct()
            {}
            public function report(\Exception $e)
            {}
            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

}
