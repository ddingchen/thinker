<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;


class GetUserTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }
    
    public function test_it_returns_ok()
    {
        $this->clientFake->mock('getUser')->applyClient();

        $result = UCenterApi::getUser($accessToken = 'IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertObjectHasAttribute('user_id', $result);
    }

}
