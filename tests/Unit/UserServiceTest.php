<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\UCenter\Service\UserService;

/**
* UserServiceTest
*/
class UserServiceTest extends TestCase
{

    private $service;

    protected function setUp()
    {
        parent::setUp();

        $this->fake = UCenterApi::fake();
        $this->service = new UserService('token');    
    }

    public function test_it_returns_a_user()
    {
        $this->fake->action('getUserById')
            ->using(["user_id" => 123])
            ->push();

        $result = $this->service->find(1);

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_finds_a_user_by_username()
    {
        $this->fake->action('getUserByInfo')
            ->using(["user_id" => 123])
            ->push();

        $result = $this->service->findByName('name');

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_finds_a_user_by_phone()
    {
        $this->fake->action('getUserByInfo')
            ->using(["user_id" => 123])
            ->push();

        $result = $this->service->findByPhone('12345678901');

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_finds_a_user_by_username_and_phone()
    {
        $this->fake->action('getUserByInfo')
            ->using(["user_id" => 123])
            ->push();

        $result = $this->service->findByNameAndPhone('name', '12345678901');

        $this->assertEquals(123, $result->user_id);
    }

    public function test_it_lists_users_in_a_domain()
    {
        $this->fake->action('getUsersInDomain')
            ->using(["users" => [
                "1001" => [
                    "user_id" => 1001,
                    "username" => "",
                    "email" => "",
                    "phone" => "",
                    "details" => [
                        "realname" => [
                            "title" => "姓名",
                            "value" => ""
                        ]
                    ]
                ]
            ]])
            ->push();

        $users = $this->service->listInDomain(1);

        $this->assertCount(1, $users);
    }

    public function test_it_register_a_new_user()
    {
        $this->fake->action('registerUser')
            ->using(["user_id" => 123])
            ->push();

         $user = $this->service->register('12345678901', '123456', 'name');

         $this->assertEquals(123, $user->user_id);
    }

    public function test_it_deletes_user_in_a_domain()
    {
         $this->service->deleteInDomain(1, 1);
    }

}
