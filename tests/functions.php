<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;

function makeApiDemoClient($action, $case = 'ok', $customData = [], $replace = false)
{
    $demos = require "tests/ApiResponseDemo/{$action}.php";
    $demo = $demos[$case];

    // merge demo json with custom data
    $customData = addPrefixForKeys($customData, 'data.');

    if ($replace) {
        $demo['json'] = clearData($demo['json']);
    }
    $demoJson = mergeArrayToJson($demo['json'], $customData);

    return makeHttpClient(
        $demoJson,
        $demo['status']
    );
}

function makeHttpClient($result, $statusCode = 200)
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

function addPrefixForKeys($array, $prefix)
{
    return collect($array)->mapWithKeys(function ($value, $key) {
        return ['data.' . $key => $value];
    })->toArray();
}

function mergeArrayToJson($json, $array)
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

function clearData($json)
{
    $array = json_decode($json, true);

    $array['data'] = null;

    return json_encode($array);
}
