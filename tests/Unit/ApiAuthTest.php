<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Models\AccessToken;
use Thinker\Models\User;
use Thinker\Testing\HttpClientFake;

class ApiAuthTest extends TestCase
{

    private $apiAuth;

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
        $this->apiAuth = UCenter::apiAuth();
    }

    public function test_it_returns_user_info_if_credentials_are_correct()
    {
        $this->clientFake
            ->mock('getAccessTokenByPassword', ['access_token' => 'new token'])
            ->mock('getUser', [
                'user_id' => 123,
                'details' => [
                    'position' => [
                        'title' => '职位',
                        'value' => 'boss',
                    ],
                ],
            ])
            ->applyClient();

        $user = $this->apiAuth->user('chen', '123456');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(123, $user->id);
        $this->assertEquals('boss', $user->details->position->value);
        $this->assertInstanceOf(AccessToken::class, $user->accessToken());
        $this->assertEquals('new token', $user->access_token);
    }

}
