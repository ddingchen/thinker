<?php

namespace Thinker\UCenter\Service;

use Thinker\Facades\UCenterApi;

/**
 * UserService
 */
class UserService extends Service
{

    public function bindWechat($openId)
    {
        return UCenterApi::bindWechat($this->accessToken, $openId);
    }

    public function unbindWechat($openId)
    {
        return UCenterApi::unbindWechat($this->accessToken, $openId);
    }

    public function find($userId)
    {
        return UCenterApi::getUserById($this->accessToken, $userId);
    }

    public function findByName($name)
    {
        return UCenterApi::getUserByInfo($this->accessToken, [
            'username' => $name,
        ]);
    }

    public function findByPhone($phone)
    {
        return UCenterApi::getUserByInfo($this->accessToken, [
            'phone' => $phone,
        ]);
    }

    public function findByNameAndPhone($name, $phone)
    {
        return UCenterApi::getUserByInfo($this->accessToken, [
            'username' => $name,
            'phone' => $phone,
        ]);
    }

    public function listInDomain($domainId)
    {
        return UCenterApi::getUsersInDomain($this->accessToken, $domainId);
    }

    public function register($phone, $password, $username = null)
    {
        return UCenterApi::registerUser($this->accessToken, $phone, $password, $username);
    }

    public function deleteInDomain($userId, $domainId)
    {
        return UCenterApi::clearRolesForUser($this->accessToken, $userId, $domainId);
    }

}
