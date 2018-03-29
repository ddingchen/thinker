<?php

namespace Thinker\UCenter\Service;

use Thinker\Facades\UCenterApi;

/**
 * UserService
 */
class UserService extends Service
{

    public function find($userId)
    {
        return UCenterApi::getUserById($userId, $this->accessToken);
    }

    public function findByName($name)
    {
        return UCenterApi::getUserByInfo([
            'username' => $name,
        ], $this->accessToken);
    }

    public function findByPhone($phone)
    {
        return UCenterApi::getUserByInfo([
            'phone' => $phone,
        ], $this->accessToken);
    }

    public function findByNameAndPhone($name, $phone)
    {
        return UCenterApi::getUserByInfo([
            'username' => $name,
            'phone' => $phone,
        ], $this->accessToken);
    }

    public function listInDomain($domainId)
    {
        return UCenterApi::getUsersInDomain($domainId, $this->accessToken);
    }

    public function register($phone, $password, $username = null)
    {
        return UCenterApi::registerUser($phone, $password, $username, $this->accessToken);
    }

    public function deleteInDomain($userId, $domainId)
    {
        return UCenterApi::clearRolesForUser($userId, $domainId, $this->accessToken);
    }

}
