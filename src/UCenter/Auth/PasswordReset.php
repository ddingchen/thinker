<?php

namespace Thinker\UCenter\Auth;

use Thinker\Facades\UCenterApi;

/**
* Password Reset
*/
class PasswordReset
{
    
    public function redirect()
    {
        return redirect(UCenterApi::urlOfResetPasswordPage());
    }

}
