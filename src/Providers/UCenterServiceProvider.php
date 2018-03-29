<?php

namespace Thinker\Providers;

use Illuminate\Support\ServiceProvider;
use Thinker\UCenter;
use Thinker\UCenterApi;

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
        $this->app->singleton(UCenterApi::class, function ($app) {
            $api = new UCenterApi(app('GuzzleHttp\Client'));
            $api->loadConfig(config('ucenter'));
            return $api;
        });
    }
}
