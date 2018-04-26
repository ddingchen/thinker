<?php

return [

    'ok' => [
        'status' => 200,
        'json' => '{
            "code": 0,
            "message": "获取access_token成功",
            "data": {
                "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
                "token_type": "Bearer",
                "expires_in": 7200,
                "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
            }
        }',
    ],

    'openid_invalid' => [
        'status' => 200,
        'json' => '{
            "code": 1,
            "message": "当前微信未绑定账户",
            "data": {}
        }',
    ],
    
];
