<?php

namespace Thinker\Testing;

use GuzzleHttp\Client;
use Thinker\UCenterApi;
use Thinker\Util\HttpClient;

class UCenterApiFake extends HttpClient
{

    protected $action;

    protected $case = 'ok';

    protected $customData = [];

    protected $replaceDemoData = false;

    protected $replace = false;

    protected $responses = [];

    public function action($action)
    {
        $this->action = $action;
        return $this;
    }

    public function expect($case)
    {
        $this->case = $case;
        return $this;
    }

    public function using($data, $replace = false)
    {
        $this->customData = $data;
        $this->replaceDemoData = $replace;
        return $this;
    }

    public function push()
    {
        // push to responses
        $this->responses[$this->action] = [
            'case' => $this->case,
            'custom_data' => $this->customData,
            'replace_demo_data' => $this->replaceDemoData,
        ];

        // reset
        $this->action = null;
        $this->case = 'ok';
        $this->customData = [];
        $this->replaceDemoData = false;

        return $this;
    }

    public function __call($action, $arguments)
    {
        // 默认提取Demo中的“ok”Case作为返回
        $demoName = ucfirst($action);
        $case = 'ok';
        $data = [];
        $replace = false;

        // 如果有预设则使用预设
        if (isset($this->responses[$action])) {
            $responseOptions = $this->responses[$action];
            $case = $responseOptions['case'];
            $data = $responseOptions['custom_data'];
            $replace = $responseOptions['replace_demo_data'];
        }

        // mock Http Client
        $client = $this->makeApiDemoClient(
            $demoName,
            $case,
            $data,
            $replace
        );

        // call real action
        return (new UCenterApi($client))->$action(...$arguments);
    }

}
