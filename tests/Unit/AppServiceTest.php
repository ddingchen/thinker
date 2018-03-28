<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\AppService;
use Thinker\Facades\UCenterApi;

class AppServiceTest extends TestCase
{
    
    protected function setUp()
    {
        parent::setUp();
    
        $this->fake = UCenterApi::fake();
        $this->service = new AppService('token');
    }

    public function test_it_lists_all_apps_in_a_domain()
    {
        // $fake = UCenterApi::fake();
        $this->fake->action('getAppsInDomain')
            ->using([
                'apps' => [
                    '123' => [
                        "id" => 123,
                        "name" => "my app",
                        "tile" => ""
                    ]
                ]
            ])->push();

        $apps = $this->service->listInDomain(1);

        $this->assertCount(1, $apps);
    }

    public function test_it_lists_all_my_apps_in_a_domain()
    {
        $this->fake->action('getMyAppsInDomain')
            ->using([
                '123' => [
                    "id" => 123,
                    "name" => "my app",
                    "tile" => ""
                ]
            ], true)->push();

        $apps = $this->service->selfRelated()->listInDomain(1);

        $this->assertCount(1, $apps);
    }

}
