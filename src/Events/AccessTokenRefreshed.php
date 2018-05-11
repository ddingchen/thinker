<?php

namespace Thinker\Events;

class AccessTokenRefreshed
{

    /**
     * "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
     * "token_type": "Bearer",
     * "expires_in": 7200,
     * "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
     */
    public $tokenPair;

    public function __construct($tokenPair)
    {
        $this->tokenPair = $tokenPair;
    }

}
