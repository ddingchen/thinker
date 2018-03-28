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
                        "name": "admin",
                        "title": "管理员",
                        "permissions": [
                            {
                                "id": 39,
                                "name": "create-permission",
                                "title": "创建权限"
                            },
                            {
                                "id": 38,
                                "name": "create-app",
                                "title": "创建应用"
                            },
                            {
                                "id": 37,
                                "name": "delete-user",
                                "title": "删除用户"
                            }
                        ]
                    }
                ]
            }
        }',
    ],
    
];
