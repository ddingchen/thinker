<?php

namespace Thinker\Testing\Fakes;

use Thinker\UCenter\Api;


class UCenterApiFake
{

    public function urlOfAuthorizePage()
    {
        return 'url_of_authorize_page';
    }

    public function getAccessTokenByCode()
    {
        return json_decode('{
            "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
            "token_type": "Bearer",
            "expires_in": 7200,
            "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
        }');
    }

    public function getAccessTokenByPassword()
    {
        return json_decode('{
            "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
            "token_type": "Bearer",
            "expires_in": 7200,
            "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
        }');
    }

    public function refreshAccessToken()
    {
        return json_decode('{
            "access_token": "new_access_token",
            "token_type": "Bearer",
            "expires_in": 7200,
            "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
        }');
    }

    public function getUser()
    {
        return json_decode('{
            "user_id": 123,
            "username": "fake name",
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
        }');
    }

    public function updateUser()
    {
        return json_decode('{
            "user_id": 123,
            "username": "updated name",
            "email": "updated email",
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
        }');
    }

    public function getDomains()
    {
        $data = json_decode('{
            "1": {
              "id": "1",
              "name": "新格尔软件",
              "description": "新格尔软件"
            },
            "10": {
              "id": "10",
              "name": "测试域",
              "description": "仅测试用"
            }
        }', true);
        $data = array_values($data);
        return json_decode(json_encode($data));
    }

    public function searchDomains()
    {
        $data = json_decode('{
            "0": {
              "id": "1",
              "name": "域名1",
              "description": "域描述1",
              "created_at": "2017-04-10 22:42:55",
              "updated_at": "2017-04-10 22:42:55"
            },
            "1": {
              "id": "13",
              "name": "域名2",
              "description": "域描述2",
              "created_at": "2017-04-12 18:37:24",
              "updated_at": "2017-04-12 18:37:24"
            }
        }', true);
        $data = array_values($data);
        return json_decode(json_encode($data));
    }

    public function getDomainById()
    {
        return json_decode('{
            "domain": {
              "id": "1",
              "name": "新格尔软件",
              "description": "新格尔软件"
            },
            "apps": {
                "1": {
                    "id": "1",
                    "name": "ucenter",
                    "title": "用户中心",
                    "users": {
                        "1002": {
                            "user_id": "1002",
                            "username": "",
                            "email": "",
                            "phone": "",
                            "details": {

                            },
                            "roles": {

                            }
                        }
                    }
                }
            },    
            "users": {
                "1001": {
                    "user_id": 1001,
                    "username": "",
                    "email": "",
                    "phone": "",
                    "details": {
  
                    }
                }
            }
        }');
    }

    public function createDomain()
    {
        return json_decode('{
            "id": "1",
            "name": "域名称",
            "description": "域描述",
            "created_at": "2017-04-01 00:00:00",
            "updated_at": "2017-04-01 00:00:00"
        }');
    }

    public function updateDomain()
    {
        return json_decode('{
            "id": "1",
            "name": "域名称",
            "description": "域描述",
            "created_at": "2017-04-01 00:00:00",
            "updated_at": "2017-04-02 00:00:00"
        }');
    }

    public function getUserById()
    {
        return json_decode('{
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
        }');
    }

    public function getUserByInfo()
    {
        return json_decode('{
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
        }');
    }

    public function getUsersInDomain()
    {
        $data = json_decode('{
            "domain": {
                  "id": "1",
                  "name": "新格尔软件",
                  "description": "新格尔软件"
            },    
            "users": {
                "1001": {    
                    "user_id": 1001,
                    "username": "",
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
        }');

        return $data->users;
    }

    public function registerUser()
    {
        return json_decode('{
            "user_id": 1002,
            "username": "188888888",
            "phone": "188888888",
            "created_at": "2017-04-01 12:12:12"
        }');
    }

}
