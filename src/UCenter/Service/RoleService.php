<?php

namespace Thinker\UCenter\Service;

use Thinker\Facades\UCenterApi;

class RoleService extends Service
{

    private $domainId;

    private $selfRelated = false;

    private $withPermissions = false;

    public function listAll()
    {
        if ($this->selfRelated) {
            if ($this->withPermissions) {
                return UCenterApi::getMyRolesWithPermissionsInDomain($this->accessToken, $this->domainId);
            }

            return UCenterApi::getMyRolesInDomain($this->accessToken, $this->domainId);
        }

        if ($this->domainId) {
            return UCenterApi::getRolesInDomain($this->accessToken, $this->domainId);
        }

        return UCenterApi::getRolesInCurrentApp($this->accessToken);
    }

    public function inDomain($id)
    {
        $this->domainId = $id;
        return $this;
    }

    public function selfRelated()
    {
        $this->selfRelated = true;
        return $this;
    }

    public function withPermissions()
    {
        $this->withPermissions = true;
        return $this;
    }

    public function forUser($id)
    {
        $this->userId = $id;
        return $this;
    }

    public function add($role)
    {
        return UCenterApi::addRoleForUser($this->accessToken, $this->userId, $role, $this->domainId);
    }

    public function remove($role)
    {
        return UCenterApi::removeRoleForUser($this->accessToken, $this->userId, $role, $this->domainId);
    }

    public function clear()
    {
        return UCenterApi::clearRolesForUser($this->accessToken, $this->userId, $this->domainId);
    }

}
