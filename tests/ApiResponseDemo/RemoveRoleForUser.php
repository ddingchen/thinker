<?php

return [

    'ok' => [
        'status' => 200,
        'json' => '{
            "code": 0,
            "message": "",
            "data": {
                "domain_id": "13",
                "user_id": 1038,
                "role_name": "guest"
            }
        }',
    ],

    'role_invalid' => [
        'status' => 404,
        'json' => '{
            "code": 404,
            "message": "指定用户角色不存在",
            "data": {
                "role_name": "manager"
            }
        }',
    ],
    
];
