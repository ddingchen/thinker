<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Testing\HttpClientFake;
use Thinker\UCenter\Service\RoleService;

class RoleServiceTest extends TestCase
{

    private $service;

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
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
                "perms" => [],
            ],
        ], true)->applyClient();

        $roles = (new RoleService($this->fakeToken()))->listAll();

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
                    "perms" => [],
                ],
            ],
        ], true)->applyClient();

        $roles = (new RoleService($this->fakeToken()))->inDomain(1)->listAll();

        $this->assertCount(1, $roles);
    }

    public function test_it_lists_my_roles_in_a_domain()
    {
        $this->clientFake->mock('getMyRolesInDomain', [
            'roles' => [
                [
                    "id" => 1,
                    "name" => "common",
                    "title" => "普通用户",
                ],
            ],
        ])->applyClient();

        $roles = (new RoleService($this->fakeToken()))->selfRelated()->inDomain(1)->listAll();

        $this->assertCount(1, $roles);
    }

    public function test_a_user_has_no_roles_in_domain()
    {
        $this->clientFake
            ->mockCase('getMyRolesInDomain', 'none')
            ->applyClient();

        $roles = (new RoleService($this->fakeToken()))->selfRelated()->inDomain(1)->listAll();

        $this->assertCount(0, $roles);
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
                            "title" => "创建权限",
                        ],
                        [
                            "id" => 38,
                            "name" => "create-app",
                            "title" => "创建应用",
                        ],
                    ],
                ],
            ],
        ])->applyClient();

        $roles = (new RoleService($this->fakeToken()))->selfRelated()->withPermissions()->inDomain(1)->listAll();

        $this->assertCount(1, $roles);
        $this->assertCount(2, $roles[0]->permissions);
    }

    public function test_it_lists_all_roles_by_an_user_and_an_app()
    {
        $this->clientFake->mock('getRolesWithPermissionsByUserInApp', [
            "109" => [
                "domain" => [
                    "id" => 109,
                    "name" => "工厂A",
                    "description" => "工厂A",
                ],
                "roles" => [
                    [
                        "id" => 186,
                        "name" => "customer",
                        "title" => "经销商",
                    ],
                    [
                        "id" => 12,
                        "name" => "manger",
                        "title" => "管理员",
                    ]
                ]
            ],
            "123" => [
                "domain" => [
                    "id" => 123,
                    "name" => "工厂B",
                    "description" => "工厂B",
                ],
                "roles" => [
                    [
                        "id" => 186,
                        "name" => "customer",
                        "title" => "经销商",
                    ]
                ]
            ],
        ], true)->applyClient();

        $roles = (new RoleService($this->fakeToken()))->forUser(1)->inApp(1)->withPermissions()->listAll();

        $this->assertCount(2, $roles);
        $this->assertCount(2, $roles[0]->roles);
    }

    public function test_it_add_a_role_for_a_user()
    {
        $this->clientFake
            ->mock('addRoleForUser', ["roles" => ['guest']])
            ->applyClient();

        $result = (new RoleService($this->fakeToken()))->forUser(1)->inDomain(1)->add('guest');

        $this->assertEquals(['guest'], $result);
    }

    public function test_it_remove_a_role_for_a_user()
    {
        $this->clientFake->mock('removeRoleForUser')->applyClient();

        (new RoleService($this->fakeToken()))->forUser(1)->inDomain(1)->remove('manger');
    }

    public function test_it_clear_all_roles_for_a_user()
    {
        $this->clientFake->mock('removeRoleForUser')->applyClient();

        (new RoleService($this->fakeToken()))->forUser(1)->inDomain(1)->clear();
    }

}
