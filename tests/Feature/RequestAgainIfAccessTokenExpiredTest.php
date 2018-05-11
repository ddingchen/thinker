<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Thinker\Events\AccessTokenRefreshed;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;

class RequestAgainIfAccessTokenExpiredTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
    }

    public function test_it_refresh_access_token_if_access_token_expired()
    {
        Event::fake();

        $this->clientFake
            ->mockCase('GetUser', 'access_token_invalid')
            ->mock('RefreshAccessToken', [
                'access_token' => 'new access token',
                'refresh_token' => 'new refresh token',
            ])
            ->mock('GetUser')
            ->applyClient();

        UCenterApi::withRefreshToken($refreshToken = '456')
            ->getUser($accessToken = '123');

        Event::assertDispatched(AccessTokenRefreshed::class, function ($event) {
            $tokenPair = $event->tokenPair;
            return $tokenPair->access_token == 'new access token'
                && $tokenPair->refresh_token == 'new refresh token';
        });
    }

}
