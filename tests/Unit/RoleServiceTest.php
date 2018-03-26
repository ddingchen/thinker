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
    
        UCenterApi::fake();
        $this->service = new RoleService('token');
    }

    public function test_it_lists_all_roles_in_current_app()
    {
        $roles = $this->service->list();

        $this->assertEquals(UCenterApi::getRolesInCurrentApp(), $roles);
    }

    public function test_it_lists_all_roles_in_a_domain()
    {
        $roles = $this->service->inDomain(1)->list();

        $this->assertEquals(UCenterApi::getRolesInDomain(), $roles);
    }

    public function test_it_lists_my_roles_in_a_domain()
    {
        $roles = $this->service->selfRelated()->inDomain(1)->list();

        $this->assertEquals(UCenterApi::getMyRolesInDomain(), $roles);
    }

    public function test_it_lists_my_roles_with_permissions_in_a_domain()
    {
        $roles = $this->service->selfRelated()->withPermissions()->inDomain(1)->list();

        $this->assertEquals(UCenterApi::getMyRolesWithPermissionsInDomain(), $roles);
    }

    public function test_it_add_a_role_for_a_user()
    {
        $result = $this->service->forUser(1)->inDomain(1)->add('manger');

        $this->assertEquals(UCenterApi::addRoleForUser(), $result);
    }

    public function test_it_remove_a_role_for_a_user()
    {
        $result = $this->service->forUser(1)->inDomain(1)->remove('manger');

        $this->assertEquals(UCenterApi::removeRoleForUser(), $result);
    }

    public function test_it_clear_all_roles_for_a_user()
    {
        $result = $this->service->forUser(1)->inDomain(1)->clear();

        $this->assertEquals(UCenterApi::clearRolesForUser(), $result);
    }

}
