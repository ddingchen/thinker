<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;


class GetRolesInCurrentAppTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }
    
    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getRolesInCurrentApp')->applyClient();

        $result = UCenterApi::getRolesInCurrentApp($accessToken = 'access_token');

        $this->assertObjectHasAttribute('id', $result[0]);
    }

    public function test_system_roles_are_hidden_in_list()
    {
        $this->clientFake->mock('getRolesInCurrentApp', [
            [
                "id" => "14",
                "app_id" => "5",
                "name" => "admin",
                "title" => "管理员",
                "description" => "管理员",
                "created_at" => "2017-04-11 00:47:48",
                "updated_at" => "2017-04-11 00:47:48",
                "perms" => []
            ],
            [
                "id" => "14",
                "app_id" => "5",
                "name" => "developer",
                "title" => "开发者",
                "description" => "开发者",
                "created_at" => "2017-04-11 00:47:48",
                "updated_at" => "2017-04-11 00:47:48",
                "perms" => []
            ]
        ], true)->applyClient();

        $result = UCenterApi::getRolesInCurrentApp($accessToken = 'access_token');

        $this->assertCount(0, $result);
    }

}
