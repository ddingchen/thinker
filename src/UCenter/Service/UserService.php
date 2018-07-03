<?php

namespace Thinker\UCenter\Service;

use Thinker\Exceptions\UCenterException;

class UserService extends Service
{

    public function bindWechat($openId, $unionId = null)
    {
        return $this->ucenterApi->bindWechat($this->accessToken, $openId, $unionId);
    }

    public function unbindWechat($openId)
    {
        return $this->ucenterApi->unbindWechat($this->accessToken, $openId);
    }

    public function find($userId)
    {
        try {
            return $this->ucenterApi->getUserById($this->accessToken, $userId);
        } catch (UCenterException $e) {
            // 未找到该用户
            if ($e->code == 1) {
                return null;
            }
            // 其他异常
            throw $e;
        }
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
