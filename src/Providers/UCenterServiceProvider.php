<?php

namespace Thinker\Providers;

use Illuminate\Support\ServiceProvider;
use Thinker\UCenter;
use Thinker\UCenter\Api;

class UCenterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/ucenter.php' => config_path('ucenter.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Api::class, function ($app) {
            $api = new Api(app('GuzzleHttp\Client'));
            $api->loadConfig(config('ucenter'));
            return $api;
        });
    }
}
