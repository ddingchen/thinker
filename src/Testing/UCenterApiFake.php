<?php

namespace Thinker\Testing;

use Thinker\Testing\HttpClientFake;
use Thinker\UCenterApi;

class UCenterApiFake
{

    protected $responses = [];

    public function mockResponse($api, $case = 'ok', $mergeData = [], $dataFullReplace = false, $clearHistory = false)
    {
        if ($clearHistory) {
            unset($this->responses[$api]);
        }

        $this->responses[$api][] = [
            'case' => $case,
            'data' => $mergeData,
            'replace' => $dataFullReplace,
        ];

        return $this;
    }

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
        $case = 'ok';
        $data = [];
        $replace = false;

        // 如果有自定义返回则使用自定义返回数据
        if (isset($this->responses[$api])) {
            if ($custom = array_pop($this->responses[$api])) {
                $case = $custom['case'];
                $data = $custom['data'];
                $replace = $custom['replace'];
            }
        }

        // mock Http Client
        $client = (new HttpClientFake)->mockCase(
            $api,
            $case,
            $data,
            $replace
        )->makeClient();

        // call real action
        return (new UCenterApi($client))->$api(...$arguments);
    }

}
