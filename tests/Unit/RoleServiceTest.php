<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;
use Thinker\UCenter\Service\RoleService;

class RoleServiceTest extends TestCase
{

    private $service;
    
    protected function setUp()
    {
        parent::setUp();
    
        $this->clientFake = new HttpClientFake();
        $this->service = new RoleService('token');
    }

    public function test_it_lists_all_roles_in_current_app()
    {
        $this->clientFake->mock('getRolesInCurrentApp', [
            [
                "id" => "14",
                "app_id" => "5",
                "name" => "guest",
                "title" => "访客",
                "description" => "访客",
                "created_at" => "2017-04-11 00:47:48",
                "updated_at" => "2017-04-11 00:47:48",
                "perms" => []
            ]
        ], true)->applyClient();

        $roles = $this->service->listAll();

        $this->assertCount(1, $roles);
    }

    public function test_it_lists_all_roles_in_a_domain()
    {
        $this->clientFake->mock('getRolesInDomain', [
            'roles' => [
                "14" => [
                    "id" => "14",
                    "app_id" => "5",
                    "name" => "guest",
                    "title" => "访客",
                    "description" => "访客",
                    "created_at" => "2017-04-11 00:47:48",
                    "updated_at" => "2017-04-11 00:47:48",
                    "perms" => []
                ]
            ]
        ], true)->applyClient();

        $roles = $this->service->inDomain(1)->listAll();

        $this->assertCount(1, $roles);
    }

    public function test_it_lists_my_roles_in_a_domain()
    {
        $this->clientFake->mock('getMyRolesInDomain', [
            'roles' => [
                [
                    "id" => 1,
                    "name" => "common",
                    "title" => "普通用户"
                ]
            ]
        ])->applyClient();

        $roles = $this->service->selfRelated()->inDomain(1)->listAll();

        $this->assertCount(1, $roles);
    }

    public function test_it_lists_my_roles_with_permissions_in_a_domain()
    {
        $this->clientFake->mock('getMyRolesWithPermissionsInDomain', [
            "roles" => [
                [
                    "id" => 2,
                    "name" => "admin",
                    "title" => "管理员",
                    "permissions" => [
                        [
                            "id" => 39,
                            "name" => "create-permission",
                            "title" => "创建权限"
                        ],
                        [
                            "id" => 38,
                            "name" => "create-app",
                            "title" => "创建应用"
                        ]
                    ]
                ]
            ]
        ])->applyClient();

        $roles = $this->service->selfRelated()->withPermissions()->inDomain(1)->listAll();

        $this->assertCount(1, $roles);
        $this->assertCount(2, $roles[0]->permissions);
    }

    public function test_it_add_a_role_for_a_user()
    {
        $this->clientFake
            ->mock('addRoleForUser', ["roles" => ['guest']])
            ->applyClient();

        $result = $this->service->forUser(1)->inDomain(1)->add('guest');

        $this->assertEquals(['guest'], $result);
    }

    public function test_it_remove_a_role_for_a_user()
    {
        $this->clientFake->mock('removeRoleForUser')->applyClient();

        $this->service->forUser(1)->inDomain(1)->remove('manger');
    }

    public function test_it_clear_all_roles_for_a_user()
    {
        $this->clientFake->mock('removeRoleForUser')->applyClient();
        
        $this->service->forUser(1)->inDomain(1)->clear();
    }

}
