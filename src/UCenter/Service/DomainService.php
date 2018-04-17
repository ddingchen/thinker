<?php

namespace Thinker\UCenter\Service;

use Thinker\Facades\UCenterApi;

/**
* DomainService
*/
class DomainService extends Service
{

    public function listAll()
    {
        $domains = UCenterApi::getDomains($this->accessToken);
        return $domains;
    }

    public function search($keyword)
    {
        return UCenterApi::searchDomains($keyword, $this->accessToken);
    }

    public function find($domainId)
    {
        return UCenterApi::getDomainById($domainId, $this->accessToken);
    }

    public function create($name, $desc)
    {
        return UCenterApi::createDomain($name, $desc, $this->accessToken);
    }

    public function updateDesc($desc, $forDomainId)
    {
        return UCenterApi::updateDomain([
            'description' => $desc,
        ], $forDomainId, $this->accessToken);
    }

}
