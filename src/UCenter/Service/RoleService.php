<?php

namespace Thinker\UCenter\Service;

class RoleService extends Service
{

    private $domainId;

    private $selfRelated = false;

    private $withPermissions = false;

    public function listAll()
    {
        if ($this->selfRelated) {
            if ($this->withPermissions) {
                return $this->ucenterApi->getMyRolesWithPermissionsInDomain($this->accessToken, $this->domainId);
            }

            return $this->ucenterApi->getMyRolesInDomain($this->accessToken, $this->domainId);
        }

        if ($this->domainId) {
            return $this->ucenterApi->getRolesInDomain($this->accessToken, $this->domainId);
        }

        return $this->ucenterApi->getRolesInCurrentApp($this->accessToken);
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
        return $this->ucenterApi->addRoleForUser($this->accessToken, $this->userId, $role, $this->domainId);
    }

    public function remove($role)
    {
        return $this->ucenterApi->removeRoleForUser($this->accessToken, $this->userId, $role, $this->domainId);
    }

    public function clear()
    {
        return $this->ucenterApi->clearRolesForUser($this->accessToken, $this->userId, $this->domainId);
    }

}
