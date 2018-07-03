<?php

return [

    'ok' => [
        'status' => 200,
        'json' => '{
            "code": 0,
            "message": "",
            "data": {
                "domain": {
                    "id": "1",
                    "name": "新格尔软件"
                },  
                "user_id": 1000,
                "roles": [
                    {
                        "id": 2,
                        "name": "common",
                        "title": "普通用户"
                    }
                ]
            }
        }',
    ],

    'none' => [
        'status' => 404,
        'json' => '{
            "code": 404,
            "message": "当前用户不属于此域",
            "data": {
                "domain": "1"
            }
        }',
    ],

    'access_token_invalid' => [
        'status' => 401,
        'json' => '{
            "code": 401,
            "message": "access_token错误",
            "data": {}
        }',
    ],
    
];
