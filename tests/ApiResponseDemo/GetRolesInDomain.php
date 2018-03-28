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
                      "name": "新格尔软件",
                      "description": "新格尔软件"
                },    
                "roles": {
                    "10": {     
                        "id": 10,
                        "name": "role name",
                        "title": "角色名称",
                        "permission_ids": [],
                        "users": {
                            "1001": {
                                "user_id": "1001",
                                "username": "用户名",
                                "email": "",
                                "phone": "",
                                "details": {
                                    "realname": {
                                        "title": "姓名",
                                        "value": ""
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }',
    ],
    
];
