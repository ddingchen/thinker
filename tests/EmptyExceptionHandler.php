<?php

namespace Tests;

use Illuminate\Foundation\Exceptions\Handler;

class EmptyExceptionHandler extends Handler
{

    public function __construct()
    {

    }

    public function report(\Exception $e)
    {

    }

    public function render($request, \Exception $e)
    {
        throw $e;
    }
}
