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
    
        UCenterApi::fake();
        $this->service = new AppService('token');
    }

    public function test_it_lists_all_apps_in_a_domain()
    {
        $apps = $this->service->listInDomain(1);

        $this->assertEquals(UCenterApi::getAppsInDomain(), $apps);
    }

    public function test_it_lists_all_my_apps_in_a_domain()
    {
        $apps = $this->service->selfRelated()->listInDomain(1);

        $this->assertEquals(UCenterApi::getMyAppsInDomain(), $apps);
    }

}
