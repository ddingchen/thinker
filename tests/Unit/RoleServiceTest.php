<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\RoleService;

class RoleServiceTest extends TestCase
{

    private $service;
    
    protected function setUp()
    {
        parent::setUp();
    
        $this->fake = UCenterApi::fake();
        $this->service = new RoleService('token');
    }

    public function test_it_lists_all_roles_in_current_app()
    {
        $this->fake->action('getRolesInCurrentApp')
            ->using([
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
            ], true)
            ->push();

        $roles = $this->service->list();

        $this->assertCount(1, $roles);
    }

    public function test_it_lists_all_roles_in_a_domain()
    {
        $this->fake->action('getRolesInDomain')
            ->using([
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
            ], true)
            ->push();

        $roles = $this->service->inDomain(1)->list();

        $this->assertCount(1, $roles);
    }

    public function test_it_lists_my_roles_in_a_domain()
    {
        $this->fake->action('getMyRolesInDomain')
            ->using([
                'roles' => [
                    [
                        "id" => 1,
                        "name" => "common",
                        "title" => "普通用户"
                    ]
                ]
            ])
            ->push();

        $roles = $this->service->selfRelated()->inDomain(1)->list();

        $this->assertCount(1, $roles);
    }

    public function test_it_lists_my_roles_with_permissions_in_a_domain()
    {
        $this->fake->action('getMyRolesWithPermissionsInDomain')
            ->using([
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
            ])
            ->push();

        $roles = $this->service->selfRelated()->withPermissions()->inDomain(1)->list();

        $this->assertCount(1, $roles);
        $this->assertCount(2, $roles[0]->permissions);
    }

    public function test_it_add_a_role_for_a_user()
    {
        $this->fake->action('addRoleForUser')
            ->using(["roles" => ['guest']])
            ->push();

        $result = $this->service->forUser(1)->inDomain(1)->add('guest');

        $this->assertEquals(['guest'], $result);
    }

    public function test_it_remove_a_role_for_a_user()
    {
        $this->service->forUser(1)->inDomain(1)->remove('manger');
    }

    public function test_it_clear_all_roles_for_a_user()
    {
        $this->service->forUser(1)->inDomain(1)->clear();
    }

}
