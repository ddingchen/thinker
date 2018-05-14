<?php

namespace Thinker\UCenter\Service;

class UserService extends Service
{

    public function bindWechat($openId)
    {
        return $this->ucenterApi->bindWechat($this->accessToken, $openId);
    }

    public function unbindWechat($openId)
    {
        return $this->ucenterApi->unbindWechat($this->accessToken, $openId);
    }

    public function find($userId)
    {
        return $this->ucenterApi->getUserById($this->accessToken, $userId);
    }

    public function findByName($name)
    {
        return $this->ucenterApi->getUserByInfo($this->accessToken, [
            'username' => $name,
        ]);
    }

    public function findByPhone($phone)
    {
        return $this->ucenterApi->getUserByInfo($this->accessToken, [
            'phone' => $phone,
        ]);
    }

    public function findByNameAndPhone($name, $phone)
    {
        return $this->ucenterApi->getUserByInfo($this->accessToken, [
            'username' => $name,
            'phone' => $phone,
        ]);
    }

    public function listInDomain($domainId)
    {
        return $this->ucenterApi->getUsersInDomain($this->accessToken, $domainId);
    }

    public function register($phone, $password, $username = null)
    {
        return $this->ucenterApi->registerUser($this->accessToken, $phone, $password, $username);
    }

    public function deleteInDomain($userId, $domainId)
    {
        return $this->ucenterApi->clearRolesForUser($this->accessToken, $userId, $domainId);
    }

}
