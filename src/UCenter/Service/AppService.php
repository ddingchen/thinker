<?php

namespace Thinker\UCenter\Service;

class AppService extends Service
{

    private $selfRelated = false;

    public function listInDomain($domainId)
    {
        if ($this->selfRelated) {
            return $this->ucenterApi->getMyAppsInDomain($this->accessToken, $domainId);
        }

        return $this->ucenterApi->getAppsInDomain($this->accessToken, $domainId);
    }

    public function selfRelated()
    {
        $this->selfRelated = true;
        return $this;
    }

}
