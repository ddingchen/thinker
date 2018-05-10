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
        return UCenterApi::searchDomains($this->accessToken, $keyword);
    }

    public function find($domainId)
    {
        return UCenterApi::getDomainById($this->accessToken, $domainId);
    }

    public function create($name, $desc)
    {
        return UCenterApi::createDomain($this->accessToken, $name, $desc);
    }

    public function updateDesc($desc, $forDomainId)
    {
        return UCenterApi::updateDomain($this->accessToken, [
            'description' => $desc,
        ], $forDomainId);
    }

}
