<?php

namespace Thinker\Testing\Fakes;

use Thinker\UCenter\Api;


class UCenterApiFake
{

    public function urlOfAuthorizePage()
    {
        return 'url_of_authorize_page';
    }

    public function getAccessTokenByCode($code)
    {
        return json_decode('{
            "access_token": "JQrKik8HTWaW2G2Aq2QKh9hYGK0Ntfv4Tc42rpJA",
            "token_type": "Bearer",
            "expires_in": 7200,
            "refresh_token": "JsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I"
        }');
    }

    public function getAccessTokenByPassword($username, $password)
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

}
