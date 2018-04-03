<?php

return [

    'ok' => [
        'status' => 200,
        'json' => '{
            "code": 0,
            "message": "",
            "data": {
                "domain_id": "1",
                "user_id": 1002,
                "roles": [
                    "guest"
                ]
            }
        }',
    ],

    'role_existed' => [
        'status' => 200,
        'json' => '{
            "code": 1,
            "message": "用户在此域的角色已存在",
            "data": {
                "domain_id": "1"
            }
        }',
    ],

    'role_invalid' => [
        'status' => 404,
        'json' => '{
            "code": 404,
            "message": "指定角色不存在",
            "data": {
                "role_name": "manager1"
            }
        }',
    ]
    
];
