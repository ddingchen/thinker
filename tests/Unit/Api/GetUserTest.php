<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;


class GetUserTest extends TestCase
{
    
    public function test_it_returns_ok()
    {
        $this->mockApiDemo('GetUser', 'ok');

        $result = UCenterApi::getUser($accessToken = 'IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertObjectHasAttribute('user_id', $result);
    }

}
