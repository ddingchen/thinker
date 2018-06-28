<?php

return [

    'ok' => [
        'status' => 200,
        'json' => '{
            "code": 0,
            "message": "",
            "data": {
                "user_id": 1002,
                "username": "",
                "email": "",
                "phone": "",
                "details": {
                    "realname": {
                        "title": "姓名",
                        "value": ""
                    },
                    "position": {
                        "title": "职位",
                        "value": ""
                    },
                    "address": {
                        "title": "地址",
                        "value": ""
                    },
                    "department": {
                        "title": "部门",
                        "value": ""
                    },
                    "school": {
                        "title": "学校",
                        "value": ""
                    },
                    "sex": {
                        "title": "性别",
                        "value": ""
                    }
                }
            }
        }',
    ],

    'none' => [
        'status' => 200,
        'json' => '{
            "code": 1,
            "message": "用户不存在",
            "data": {}
        }',
    ],
    
];
