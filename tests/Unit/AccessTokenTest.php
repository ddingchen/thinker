<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Models\AccessToken;
use Thinker\Testing\HttpClientFake;
use Thinker\Testing\UCenterApiFake;

class AccessTokenTest extends TestCase
{

    private $accessToken;
    
    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
        $this->accessToken = new AccessToken(['access_token' => '123']);
    }

    public function test_props_are_correctly_set()
    {
        $this->assertEquals(123, $this->accessToken->access_token);
    }

    public function test_it_refresh_by_refresh_token()
    {
        $this->clientFake
            ->mock('refreshAccessToken', ['access_token' => 'new_access_token'])
            ->applyClient();

        $this->accessToken->refresh();

        $this->assertEquals('new_access_token', $this->accessToken->access_token);
    }

}
