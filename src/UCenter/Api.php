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
        return $this->post('/api/oauth/accessToken', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirect_uri,
            'code' => $code,
        ]);
    }

    /**
     * Authorize by password mode
     *
     * @return mixed
     */
    public function getAccessTokenByPassword($username, $password)
    {
        return $this->post('/api/oauth/accessToken', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ]);
    }

    public function refreshAccessToken($refreshAccessToken)
    {
        return $this->post('/api/oauth/accessToken', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshAccessToken,
        ]);
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
        return $this->get('/api/user', [
            'access_token' => $accessToken,
        ]);
    }

    public function updateUser($data, $accessToken)
    {
        return $this->put('/api/user', array_merge([
            'access_token' => $accessToken,
        ], $data));
    }

    public function getDomains($accessToken)
    {
        $data = $this->get('/api/user/domain', [
            'access_token' => $accessToken,
        ]);

        return $this->clearArrayKeysOfTopLevel($data);
    }

    public function getDomainById($domainId, $accessToken)
    {
        return $this->get('/api/user/domain/' . $domainId, [
            'access_token' => $accessToken,
        ]);
    }

    public function createDomain($name, $desc, $accessToken)
    {
        return $this->post('/api/domain', [
            'access_token' => $accessToken,
            'domain_name' => $name,
            'description' => $desc,
        ]);
    }

    public function updateDomain($domainId, $desc, $accessToken)
    {
        return $this->put('/api/domain', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
            'description' => $desc,
        ]);
    }

    public function getUserById($userId, $accessToken)
    {
        return $this->get('/api/users/' . $userId, [
            'access_token' => $accessToken,
        ]);
    }

    public function getUserByInfo($info, $accessToken)
    {
        $data = ['access_token' => $accessToken];

        if (isset($info['username'])) {
            $data['username'] = $info['username'];
        }

        if (isset($info['phone'])) {
            $data['phone'] = $info['phone'];
        }

        return $this->get('/api/users', $data);
    }

    public function getUserInDomain($domainId, $accessToken)
    {
        return $this->get('/api/domains/' . $domainId . '/users', [
            'access_token' => $accessToken,
        ]);
    }

    public function registerUser($phone, $password, $username = null, $accessToken)
    {
        return $this->post('/api/user', [
            'access_token' => $accessToken,
            'phone' => $phone,
            'password' => $password,
            'username' => $username,
        ]);
    }

    public function getAppsInDomain($domainId, $accessToken)
    {
        $data = $this->get('/api/domains/' . $domainId . '/apps', [
            'access_token' => $accessToken,
        ]);

        return $this->clearArrayKeysOfTopLevel($data->apps);
    }

    public function getMyAppsInDomain($domainId, $accessToken)
    {
        $data = $this->get('/api/user/app', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
        ]);

        return $this->clearArrayKeysOfTopLevel($data);
    }

    public function getRolesInCurrentApp($accessToken)
    {
        return $this->get('/api/app/roles', [
            'access_token' => $accessToken,
        ]);
    }

    public function getRolesInDomain($domainId, $accessToken)
    {
        return $this->get('/api/domains/' . $domainId . '/roles', [
            'access_token' => $accessToken,
        ]);
    }

    public function getMyRolesInDomain($domainId = null, $accessToken)
    {
        return $this->get('/api/user/role', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
        ]);
    }

    public function getMyRolesWithPermissionsInDomain($domainId = null, $accessToken)
    {
        return $this->get('/api/user/rolePermission', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
        ]);
    }

    public function addRoleForUser($userId, $role, $domainId = null, $accessToken)
    {
        return $this->post('/api/user/role', [
            'access_token' => $accessToken,
            'user_id' => $userId,
            'role_name' => $role,
            'domain_id' => $domainId,
        ]);
    }

    public function removeRoleForUser($userId, $role, $domainId = null, $accessToken)
    {
        return $this->delete('/api/user/role', [
            'access_token' => $accessToken,
            'user_id' => $userId,
            'role_name' => $role,
            'domain_id' => $domainId,
        ]);
    }

    public function clearRolesForUser($userId, $domainId = null, $accessToken)
    {
        return $this->delete('/api/user', [
            'access_token' => $accessToken,
            'user_id' => $userId,
            'domain_id' => $domainId,
        ]);
    }

    protected function get($url, $data)
    {
        return $this->request('get', $url, $data);
    }

    public function post($url, $data)
    {
        return $this->request('post', $url, $data);
    }

    public function put($url, $data)
    {
        return $this->request('put', $url, $data);
    }

    public function delete($url, $data)
    {
        return $this->request('delete', $url, $data);
    }

    protected function request($method, $url, $data)
    {
        $response = $this->client->request($method, $url, [
            $this->optionNameForMethod($method) => $data,
        ]);

        $response = json_decode($response->getBody());
        if ($response->code !== 0) {
            throw new UCenterException;
        }

        return $response->data;
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
