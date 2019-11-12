<?php

namespace Thinker\UCenter\Auth;

use Thinker\Facades\UCenterApi;

class Register
{
    public function redirect($redirectBack = null)
    {
        return redirect(UCenterApi::urlOfRegisterPage($redirectBack));
    }
}
