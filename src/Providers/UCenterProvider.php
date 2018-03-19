<?php

namespace Thinker\Providers;

use Illuminate\Support\ServiceProvider;
use Thinker\UCenter;
use Thinker\UCenter\Api;

class UCenterProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Api::class, function ($app) {
            return new Api(app('GuzzleHttp\Client'));
        });
    }
}
