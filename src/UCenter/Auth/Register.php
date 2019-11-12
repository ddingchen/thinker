<?php

namespace Thinker\UCenter\Auth;

use Thinker\Facades\UCenterApi;

class Register
{
    public function redirect()
    {
        return redirect(UCenterApi::urlOfRegisterPage());
    }
}
