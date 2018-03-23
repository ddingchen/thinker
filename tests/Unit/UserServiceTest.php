<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\UserService;

/**
* UserServiceTest
*/
class UserServiceTest extends TestCase
{

    private $service;

    protected function setUp()
    {
        parent::setUp();

        UCenterApi::fake();
        $this->service = new UserService('token');    
    }

    public function test_it_returns_a_user()
    {
        $user = $this->service->find(1);

        $this->assertEquals(UCenterApi::getUserById(), $user);
    }

    public function test_it_finds_a_user_by_username()
    {
        $user = $this->service->findByName('name');

        $this->assertEquals(UCenterApi::getUserByInfo(), $user);
    }

    public function test_it_finds_a_user_by_phone()
    {
        $user = $this->service->findByPhone('12345678901');

        $this->assertEquals(UCenterApi::getUserByInfo(), $user);
    }

    public function test_it_finds_a_user_by_username_and_phone()
    {
        $user = $this->service->findByNameAndPhone('name', '12345678901');

        $this->assertEquals(UCenterApi::getUserByInfo(), $user);
    }

    public function test_it_lists_users_in_a_domain()
    {
        $users = $this->service->listInDomain(1);

        $this->assertEquals(UCenterApi::getUsersInDomain(), $users);
    }

    public function test_it_register_a_new_user()
    {
         $user = $this->service->register('12345678901', '123456', 'name');

         $this->assertEquals(UCenterApi::registerUser(), $user);
    }

}
