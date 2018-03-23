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

}
