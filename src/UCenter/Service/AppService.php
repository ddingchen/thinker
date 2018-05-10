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
            return UCenterApi::getMyAppsInDomain($this->accessToken, $domainId);
        }

        return UCenterApi::getAppsInDomain($this->accessToken, $domainId);
    }

    public function selfRelated()
    {
        $this->selfRelated = true;
        return $this;
    }

}
