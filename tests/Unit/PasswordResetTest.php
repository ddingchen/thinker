<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Thinker\Facades\UCenter;
use Thinker\Facades\UCenterApi;

class PasswordResetTest extends TestCase
{

    public function test_it_redirect_to_password_reset_page()
    {
        $response = UCenter::passwordReset()->redirect();

         TestResponse::fromBaseResponse($response)
            ->assertRedirect(UCenterApi::urlOfResetPasswordPage());
    }

}
