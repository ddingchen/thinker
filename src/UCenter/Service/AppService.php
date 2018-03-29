<?php

namespace Thinker\UCenter\Service;

use Thinker\Facades\UCenterApi;

/**
 * AppService
 */
class AppService extends Service
{

    private $selfRelated = false;

    public function listInDomain($domainId)
    {
        if ($this->selfRelated) {
            return UCenterApi::getMyAppsInDomain($domainId, $this->accessToken);
        }

        return UCenterApi::getAppsInDomain($domainId, $this->accessToken);
    }

    public function selfRelated()
    {
        $this->selfRelated = true;
        return $this;
    }

}
