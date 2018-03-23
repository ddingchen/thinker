<?php

namespace Thinker;

use Thinker\Facades\UCenterApi;

/**
 * AppService
 */
class AppService
{

    private $accessToken;

    private $selfRelated = false;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

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
