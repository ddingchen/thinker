<?php

return [

    'ok' => [
        'status' => 200,
        'json' => '{
            "code": 0,
            "message": "微信绑定成功",
            "data": {
                "user_id": 5808,
                "unionid": null,
                "openid": "12345678",
                "nickname": null,
                "sex": null,
                "language": null,
                "city": null,
                "province": null,
                "country": null,
                "headimgurl": null
            }
        }',
    ],

    'openid_exists' => [
        'status' => 200,
        'json' => '{
            "code": 1,
            "message": "已绑定其他账号，可解绑后重新绑定",
            "data": {}
        }',
    ],

];
