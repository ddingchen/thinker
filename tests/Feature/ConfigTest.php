<?php

namespace Tests\Feature;

use Tests\TestCase;
use Thinker\UCenter\Api;


class ConfigTest extends TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('ucenter', [
            'api_root' => 'http://api.com',
            'client_id' => '123456',
            'client_secret' => 'abc',
            'redirect_uri' => 'callback_url',
        ]);
    }
    
    public function test_it_load_configs_from_laravel_config()
    {
        $this->assertEquals(
            "http://api.com",
            app(Api::class)->api_root
        );
    }

}
