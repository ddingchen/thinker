<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;


class UserTest extends TestCase
{
    
    public function test_it_returns_user_info()
    {
        $this->mockHttpClient('{
            "code": 0,
            "message": "获取用户信息成功",
            "data": {
                "user_id": 1002,
                "username": "",
                "email": "",
                "phone": "",
                "details": {
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
                    }
                }
            }
        }');

        $result = UCenterApi::getUser('IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertEquals("1002", $result->user_id);
    }

}
