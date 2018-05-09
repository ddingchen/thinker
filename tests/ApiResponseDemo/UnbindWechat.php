<?php

return [

    'ok' => [
        'status' => 200,
        'json' => '{
            "code": 0,
            "message": "微信解绑成功",
            "data": {
                "user_id": 5808
            }
        }',
    ],

    'invalid_openid' => [
        'status' => 200,
        'json' => '{
            "code": 1,
            "message": "微信解绑失败",
            "data": {}
        }',
    ],

];
