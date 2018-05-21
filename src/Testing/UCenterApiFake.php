<?php

namespace Thinker\Testing;

use Thinker\Testing\HttpClientFake;
use Thinker\UCenterApi;

class UCenterApiFake
{

    public function __call($api, $arguments)
    {
        // 无需HTTP请求的action则直接调用
        if (in_array($api, [
            'withRefreshToken',
            'urlOfApplication',
            'urlOfAuthorizePage',
            'urlOfResetPasswordPage',
        ])) {
            return $this;
        }

        // 默认提取Demo中的“ok”Case作为返回
        $demoName = ucfirst($api);
        $case = 'ok';
        $data = [];
        $replace = false;

        // mock Http Client
        $client = (new HttpClientFake)->mockCase(
            $demoName,
            $case,
            $data,
            $replace
        )->makeClient();

        // call real action
        return (new UCenterApi($client))->$api(...$arguments);
    }

}
