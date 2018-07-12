<?php

namespace Thinker\UCenter\Service;

use Thinker\Exceptions\UCenterException;

class RoleService extends Service
{

    private $appName;

    private $domainId;

    private $selfRelated = false;

    private $withPermissions = false;

    public function listAll()
    {
        try {
            if ($this->selfRelated) {
                if ($this->withPermissions) {
                    return $this->ucenterApi->getMyRolesWithPermissionsInDomain($this->accessToken, $this->domainId);
                }

                return $this->ucenterApi->getMyRolesInDomain($this->accessToken, $this->domainId);
            }
        } catch (UCenterException $e) {
            if ($e->statusCode == 404) {
                // 用户不属于此域
                return [];
            }
        }

        if ($this->domainId) {
            return $this->ucenterApi->getRolesInDomain($this->accessToken, $this->domainId);
        }

        if ($this->appName) {
            return $this->ucenterApi->getRolesWithPermissionsByUserInApp($this->accessToken, $this->userId, $this->appName);
        }

        return $this->ucenterApi->getRolesInCurrentApp($this->accessToken);
    }

    public function inApp($name)
    {
        $this->appName = $name;
        return $this;
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
