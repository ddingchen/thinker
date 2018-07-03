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

    'credentials_incorrect' => [
        'status' => 401,
        'json' => '{
            "code": 401,
            "message": "用户名或密码错误, The user credentials were incorrect.",
            "data": {}
        }',
    ],

    'non_existent_account' => [
        'status' => 200,
        'json' => '{
            "code": 1,
            "message": "获取access_token失败",
            "data": {}
        }',
    ],

];
