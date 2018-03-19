<?php

namespace Thinker;

use App\Exceptions\UCenterException;
use GuzzleHttp\Client;
use Thinker\Exceptions\CredentialsIncorrectException;
use Thinker\UCenter\ApiAuth;
use Thinker\UCenter\WebAuth;

class UCenter
{

    private $webAuth;

    public function __construct(Client $client, WebAuth $webAuth, ApiAuth $apiAuth)
    {
        $this->client = $client;
        $this->webAuth = $webAuth;
        $this->apiAuth = $apiAuth;
    }

    public function webAuth()
    {
        return $this->webAuth;
    }

    public function apiAuth()
    {
        return $this->apiAuth;
    }

    public function authorizeByAdmin()
    {
        $url = config('ucenter.api.root') . config('ucenter.api.access_token');
        $response = $this->client->request("POST", $url, [
            'form_params' => [
                'client_id' => config('ucenter.client_id'),
                'client_secret' => config('ucenter.client_secret'),
                'grant_type' => 'password',
                'username' => config('ucenter.admin.username'),
                'password' => config('ucenter.admin.password'),
            ],
        ]);
        $response = json_decode($response->getBody());

        if ($response->code !== 0) {
            throw new UCenterException($response->message);
        }

        return $response->data;
    }

    public function registerUser($data)
    {

        $url = config('ucenter.api.root') . config('ucenter.api.user_info');
        $response = $this->client->request("POST", $url, [
            'form_params' => [
                'access_token' => $data['access_token'],
                'phone' => $data['phone'],
                'password' => $data['password'],
            ],
        ]);
        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * Get user info from ucenter
     *
     * @return mixed
     */
    public function userInfo($accessToken)
    {
        $url = config('ucenter.api.root') . config('ucenter.api.user_info');
        $response = $this->client->request("GET", $url, [
            'query' => [
                'access_token' => $accessToken,
            ],
        ]);
        $response = json_decode($response->getBody());

        if ($response->code !== 0) {
            throw new UCenterException($response->message);
        }

        return $response->data;
    }

    /**
     * Get user info from ucenter
     *
     * @return mixed
     */
    public function usersInfo($accessToken, $phone)
    {
        $url = config('ucenter.api.root') . config('ucenter.api.users_info');
        $response = $this->client->request("GET", $url, [
            'query' => [
                'access_token' => $accessToken,
                'phone' => $phone,
            ],
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }

}
