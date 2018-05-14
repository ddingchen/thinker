<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Testing\HttpClientFake;
use Thinker\UCenter\Service\AppService;

class AppServiceTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_lists_all_apps_in_a_domain()
    {
        $this->clientFake->mock('getAppsInDomain', [
            'apps' => [
                '123' => [
                    "id" => 123,
                    "name" => "my app",
                    "tile" => "",
                ],
            ],
        ])->applyClient();

        $apps = (new AppService($this->fakeToken()))->listInDomain(1);

        $this->assertCount(1, $apps);
    }

    public function test_it_lists_all_my_apps_in_a_domain()
    {
        $this->clientFake->mock('getMyAppsInDomain', [
            '123' => [
                "id" => 123,
                "name" => "my app",
                "tile" => "",
            ],
        ], true)->applyClient();

        $apps = (new AppService($this->fakeToken()))->selfRelated()->listInDomain(1);

        $this->assertCount(1, $apps);
    }

}
