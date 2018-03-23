<?php

namespace Thinker;

use Thinker\Facades\UCenterApi;

/**
* UserService
*/
class UserService
{

    private $accessToken;
    
    function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

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

}
