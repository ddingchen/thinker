<?php

namespace Thinker\Util;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use Thinker\Exceptions\UCenterException;

class HttpClient
{

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get($url, $data)
    {
        return $this->request('get', $url, $data);
    }

    protected function post($url, $data)
    {
        return $this->request('post', $url, $data);
    }

    protected function put($url, $data)
    {
        return $this->request('put', $url, $data);
    }

    protected function delete($url, $data)
    {
        return $this->request('delete', $url, $data);
    }

    protected function request($method, $url, $data)
    {
        $response = $this->client->request($method, $this->root . $url, [
            $this->optionNameForMethod($method) => $data,
        ]);

        $body = json_decode($response->getBody());
        if ($body->code !== 0) {
            throw new UCenterException(
                $response->getStatusCode(), 
                $body->code, 
                $body->message, 
                $body->data
            );
        }

        return $body->data;
    }

    protected function optionNameForMethod($method)
    {
        $method = strtolower($method);

        if ($method == 'get') {
            return 'query';
        }

        return 'form_params';
    }

    protected function clearArrayKeysOfTopLevel($data)
    {
        // 转换为索引数组
        $data = json_decode(json_encode($data), true);

        // 去除索引
        $data = array_values($data);

        // 转换为Object
        return json_decode(json_encode($data));
    }

    public function makeApiDemoClient($action, $case = 'ok', $customData = [], $replace = false)
    {
        $demos = require __DIR__ . "/../../tests/ApiResponseDemo/{$action}.php";
        $demo = $demos[$case];

        // merge demo json with custom data
        $customData = $this->addPrefixForKeys($customData, 'data.');

        if ($replace) {
            $demo['json'] = $this->clearData($demo['json']);
        }
        $demoJson = $this->mergeArrayToJson($demo['json'], $customData);

        return $this->makeHttpClient(
            $demoJson,
            $demo['status']
        );
    }

    public function makeHttpClient($result, $statusCode = 200)
    {
        $stream = Psr7\stream_for($result);
        $response = new Response($statusCode, [], $stream);
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);

        return new Client([
            'handler' => $handler,
            'http_errors' => false,
        ]);
    }

    public function addPrefixForKeys($array, $prefix)
    {
        return collect($array)->mapWithKeys(function ($value, $key) {
            return ['data.' . $key => $value];
        })->toArray();
    }

    public function mergeArrayToJson($json, $array)
    {
        // convert json to array
        $tmp = json_decode($json, true);

        // map array
        foreach ($array as $key => $value) {
            data_set($tmp, $key, $value);
        }

        // convert back
        return json_encode($tmp);
    }

    public function clearData($json)
    {
        $array = json_decode($json, true);

        $array['data'] = null;

        return json_encode($array);
    }
}
