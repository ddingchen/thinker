<?php 

namespace Thinker\UCenter;

use GuzzleHttp\Client;
use Thinker\Exceptions\UCenterException;


class Api
{

    public $client;

    public $root;

    public $client_id;

    public $client_secret;

    public $redirect_uri;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function loadConfig($configurations)
    {
        foreach ($configurations as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Url of ucenter authorize page
     *
     * @return mixed
     */
    public function urlOfAuthorizePage()
    {
        return sprintf(
            '%s/oauth/authorize?client_id=%s&redirect_uri=%s&response_type=code',
            $this->root,
            $this->client_id,
            $this->redirect_uri
        );
    }
    
    /**
     * Authorize by code mode
     *
     * @return mixed
     */
    public function getAccessTokenByCode($code)
    {
        $url = $this->root . '/api/oauth/accessToken';
        $response = $this->client->request("POST", $url, [
            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $this->redirect_uri,
                'code' => $code,
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            throw new UCenterException;
        }

        $response = json_decode($response->getBody());

        return $response->data;
    }

    /**
     * Authorize by password mode
     *
     * @return mixed
     */
    public function getAccessTokenByPassword($username, $password)
    {
        $url = $this->root . '/api/oauth/accessToken';
        $response = $this->client->request("POST", $url, [
            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type' => 'password',
                'username' => $username,
                'password' => $password,
            ],
        ]);
        $response = json_decode($response->getBody());

        if ($response->code !== 0) {
            throw new UCenterException;
        }

        return $response->data;
    }

    public function refreshAccessToken($accessToken)
    {
        $url = $this->root . '/api/oauth/accessToken';
        $response = $this->client->request("POST", $url, [
            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type' => 'refresh_token',
                'refresh_token' => $accessToken,
            ],
        ]);
        $response = json_decode($response->getBody());

        if ($response->code !== 0) {
            throw new UCenterException;
        }

        return $response->data;
    }

    public function urlOfApplication($appId, $domainId, $accessToken)
    {
        return sprintf(
            '%s/api/sso/redirect?access_token=%s&app_id=%s&domain_id=%s',
            $this->root,
            $accessToken,
            $appId,
            $domainId
        );
    }

    public function getUser($accessToken)
    {
        $url = $this->root . '/api/user';
        $response = $this->client->request("GET", $url, [
            'query' => [
                'access_token' => $accessToken,
            ],
        ]);
        $response = json_decode($response->getBody());

        if ($response->code !== 0) {
            throw new UCenterException;
        }

        return $response->data;
    }
   
}
