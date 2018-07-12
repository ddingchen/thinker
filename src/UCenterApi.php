<?php

namespace Thinker;

use Thinker\Exceptions\UCenterException;
use Thinker\Util\HttpClient;

class UCenterApi extends HttpClient
{

    public $root;

    public $client_id;

    public $client_secret;

    public $redirect_uri;

    public $scope;

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
     * Url of reset password page
     *
     * @return mixed
     */
    public function urlOfResetPasswordPage()
    {
        return sprintf(
            '%s/password/phone?client_id=%s&redirect_uri=%s&response_type=code',
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
            'scope' => $this->scope,
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
            'scope' => $this->scope,
            'username' => $username,
            'password' => $password,
        ]);
    }

    /**
     * Bind wechat to user account
     *
     * @return mixed
     */
    public function bindWechat($accessToken, $openId, $unionId = null)
    {
        return $this->post('/api/user/wechat', [
            'access_token' => $accessToken,
            'openid' => $openId,
            'unionid' => $unionId,
        ]);
    }

    public function forceBindWechat($accessToken, $adminAccessToken, $openId, $unionId = null)
    {
        return $this->put('/api/user/wechat', [
            'access_token' => $accessToken,
            'admin_access_token' => $adminAccessToken,
            'openid' => $openId,
            'unionid' => $unionId,
        ]);
    }

    /**
     * Unbind wechat to user account
     *
     * @return mixed
     */
    public function unbindWechat($accessToken, $openId)
    {
        return $this->delete('/api/user/wechat', [
            'access_token' => $accessToken,
            'openid' => $openId,
        ]);
    }

    public function getAccessTokenByOpenId($openId, $adminAccessToken)
    {
        return $this->post('/api/wechat/accessToken', [
            'access_token' => $adminAccessToken,
            'openid' => $openId,
            'scope' => $this->scope,
        ]);
    }

    public function refreshAccessToken($refreshAccessToken)
    {
        return $this->post('/api/oauth/accessToken', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'refresh_token',
            'scope' => $this->scope,
            'refresh_token' => $refreshAccessToken,
        ]);
    }

    public function urlOfApplication($accessToken, $appId, $domainId)
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

    public function updateUser($accessToken, $data)
    {
        return $this->put('/api/user', array_merge([
            'access_token' => $accessToken,
        ], $data));
    }

    public function getDomains($accessToken)
    {
        try {
            $data = $this->get('/api/user/domain', [
                'access_token' => $accessToken,
            ]);
        } catch (UCenterException $exception) {
            // 用户所属域不存在
            if ($exception->code == 1) {
                return [];
            }
            throw $exception;
        }

        return $this->clearArrayKeysOfTopLevel($data);
    }

    public function searchDomains($accessToken, $keyword)
    {
        $data = $this->get('/api/domains', [
            'access_token' => $accessToken,
            'name' => $keyword,
        ]);

        return $this->clearArrayKeysOfTopLevel($data);
    }

    public function getDomainById($accessToken, $domainId)
    {
        try {
            $data = $this->get('/api/domains/' . $domainId, [
                'access_token' => $accessToken,
            ]);
        } catch (UCenterException $exception) {
            // 域不存在
            if ($exception->code == 404) {
                return null;
            }
            throw $exception;
        }

        return $data;
    }

    public function createDomain($accessToken, $name, $desc)
    {
        return $this->post('/api/domain', [
            'access_token' => $accessToken,
            'domain_name' => $name,
            'description' => $desc,
        ]);
    }

    public function updateDomain($accessToken, $domainId, $desc)
    {
        return $this->put('/api/domain', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
            'description' => $desc,
        ]);
    }

    public function getUserById($accessToken, $userId)
    {
        return $this->get('/api/users/' . $userId, [
            'access_token' => $accessToken,
        ]);
    }

    public function getUserByInfo($accessToken, $info)
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

    public function getUsersInDomain($accessToken, $domainId)
    {
        $data = $this->get('/api/domains/' . $domainId . '/users', [
            'access_token' => $accessToken,
        ]);

        return $this->clearArrayKeysOfTopLevel($data->users);
    }

    public function registerUser($accessToken, $phone, $password, $username = null)
    {
        return $this->post('/api/user', [
            'access_token' => $accessToken,
            'phone' => $phone,
            'password' => $password,
            'username' => $username,
        ]);
    }

    public function getAppsInDomain($accessToken, $domainId)
    {
        $data = $this->get('/api/domains/' . $domainId . '/apps', [
            'access_token' => $accessToken,
        ]);

        return $this->clearArrayKeysOfTopLevel($data->apps);
    }

    public function getMyAppsInDomain($accessToken, $domainId)
    {
        $data = $this->get('/api/user/app', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
        ]);

        return $this->clearArrayKeysOfTopLevel($data);
    }

    public function getRolesInCurrentApp($accessToken)
    {
        $data = $this->get('/api/app/roles', [
            'access_token' => $accessToken,
        ]);

        // admin、developer角色不可用于应用环境下设置
        return array_filter($data, function ($item) {
            return !in_array($item->name, ['admin', 'developer']);
        });
    }

    public function getRolesWithPermissionsByUserInApp($accessToken, $userId, $appName)
    {
        $data = $this->get('/api/users/' . $userId . '/app/' . $appName . '/rolePermission', [
            'access_token' => $accessToken,
        ]);

        return collect($data)->map(function ($domainInfo) {
            return [
                'domain_id' => $domainInfo->domain->id,
                'domain_name' => $domainInfo->domain->name,
                'roles' => $domainInfo->roles,
            ];
        })->values();
    }

    public function getRolesInDomain($accessToken, $domainId)
    {
        $data = $this->get('/api/domains/' . $domainId . '/roles', [
            'access_token' => $accessToken,
        ]);

        return $this->clearArrayKeysOfTopLevel($data->roles);
    }

    public function getMyRolesInDomain($accessToken, $domainId = null)
    {
        $data = $this->get('/api/user/role', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
        ]);

        return $this->clearArrayKeysOfTopLevel($data->roles);
    }

    public function getMyRolesWithPermissionsInDomain($accessToken, $domainId = null)
    {
        $data = $this->get('/api/user/rolePermission', [
            'access_token' => $accessToken,
            'domain_id' => $domainId,
        ]);

        return $this->clearArrayKeysOfTopLevel($data->roles);
    }

    public function addRoleForUser($accessToken, $userId, $role, $domainId = null)
    {
        $data = $this->post('/api/user/role', [
            'access_token' => $accessToken,
            'user_id' => $userId,
            'role_name' => $role,
            'domain_id' => $domainId,
        ]);

        return $data->roles;
    }

    public function removeRoleForUser($accessToken, $userId, $role, $domainId = null)
    {
        return $this->delete('/api/user/role', [
            'access_token' => $accessToken,
            'user_id' => $userId,
            'role_name' => $role,
            'domain_id' => $domainId,
        ]);
    }

    public function clearRolesForUser($accessToken, $userId, $domainId = null)
    {
        return $this->delete('/api/user', [
            'access_token' => $accessToken,
            'user_id' => $userId,
            'domain_id' => $domainId,
        ]);
    }

}
