<?php

namespace Tests\Feature;

use Tests\TestCase;
use Thinker\UCenterApi;


class ConfigLoadTest extends TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('ucenter', [
            'root' => 'http://api.com',
            'client_id' => '123456',
            'client_secret' => 'abc',
            'redirect_uri' => 'callback_url',
        ]);
    }
    
    public function test_it_load_configs_from_laravel_config()
    {
        $this->assertEquals(
            "http://api.com",
            app(UCenterApi::class)->root
        );
    }

}
