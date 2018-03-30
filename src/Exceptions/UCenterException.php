<?php

namespace Thinker\Exceptions;

class UCenterException extends \Exception
{

    public $statusCode;

    public $code;

    public $message;

    public $data;

    public function __construct($statusCode, $code, $message, $data)
    {
        $this->statusCode = $statusCode;
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

}
