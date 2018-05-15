<?php

namespace Thinker\Testing;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;

class HttpClientFake
{

    protected $responses = [];

    public function mock($api, $mergeData = [], $dataFullReplace = false)
    {
        $this->mockResponse($api, 'ok', $mergeData, $dataFullReplace);
        
        return $this;
    }

    public function mockCase($api, $case = 'ok', $mergeData = [], $dataFullReplace = false)
    {
        $this->mockResponse($api, $case, $mergeData, $dataFullReplace);

        return $this;
    }

    public function applyClient()
    {
        app()->instance('GuzzleHttp\Client', $this->makeClient());
    }

    public function makeClient()
    {
        $mock = new MockHandler($this->makeResponses());
        $handler = HandlerStack::create($mock);

        return new Client([
            'handler' => $handler,
            'http_errors' => false,
        ]);
    }

    public function makeResponses()
    {
        // generate guzzle response
        return array_map(function ($response) {
            $stream = Psr7\stream_for($response['json']);
            return new Response($response['status'], [], $stream);
        }, $this->responses);
    }

    protected function mockResponse($api, $case = 'ok', $mergeData = [], $dataFullReplace = false)
    {
        // retrieve demo case
        $demos = require __DIR__ . "/../../tests/ApiResponseDemo/{$api}.php";
        $demo = $demos[$case];

        // use mergeData as response data
        if ($dataFullReplace) {
            $demo['json'] = $this->clearData($demo['json']);
        }

        // merge demo json with custom data
        $mergeData = $this->addPrefixForKeys($mergeData, 'data.');

        // generate reponse data
        $demoJson = $this->mergeArrayToJson($demo['json'], $mergeData);

        // return $this->responses($demoJson, $demo['status']);
        array_push($this->responses, [
            'status' => $demo['status'],
            'json' => $demoJson,
        ]);

        return $this;
    }

    protected function addPrefixForKeys($array, $prefix)
    {
        return collect($array)->mapWithKeys(function ($value, $key) {
            return ['data.' . $key => $value];
        })->toArray();
    }

    protected function mergeArrayToJson($json, $array)
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

    protected function clearData($json)
    {
        $array = json_decode($json, true);

        $array['data'] = null;

        return json_encode($array);
    }

}
