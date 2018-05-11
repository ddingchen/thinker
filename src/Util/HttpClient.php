<?php

namespace Thinker\Util;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Response;
use Thinker\Events\AccessTokenRefreshed;
use Thinker\Exceptions\UCenterException;
use Thinker\Facades\UCenterApi;

class HttpClient
{

    protected $client;

    protected $refreshToken;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function withRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
        return $this;
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
            'http_errors' => false,
        ]);

        // access token expired or invalid
        if ($response->getStatusCode() == 401 && $this->refreshToken) {
            // refresh access token and try to request again
            return $this->tryAgain($method, $url, $data);
        }

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

    protected function tryAgain($method, $url, $data)
    {
        $tokenPair = UCenterApi::refreshAccessToken($this->refreshToken);

        event(new AccessTokenRefreshed($tokenPair));

        return $this->request(
            $method,
            $url,
            array_merge($data, [
                'access_token' => $tokenPair->access_token
            ])
        );
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
}
