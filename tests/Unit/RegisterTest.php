<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;

class RegisterTest extends TestCase
{
    
    protected function setUp()
    {
        parent::setUp();
    }

    public function test_it_redirect_register_page()
    {
        $response = UCenter::register()->redirect();

        TestResponse::fromBaseResponse($response)
            ->assertRedirect(UCenterApi::urlOfRegisterPage());
    }
}
