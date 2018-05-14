<?php

namespace Thinker\UCenter\Service;

class DomainService extends Service
{

    public function listAll()
    {
        $domains = $this->ucenterApi->getDomains($this->accessToken);
        return $domains;
    }

    public function search($keyword)
    {
        return $this->ucenterApi->searchDomains($this->accessToken, $keyword);
    }

    public function find($domainId)
    {
        return $this->ucenterApi->getDomainById($this->accessToken, $domainId);
    }

    public function create($name, $desc)
    {
        return $this->ucenterApi->createDomain($this->accessToken, $name, $desc);
    }

    public function updateDesc($desc, $forDomainId)
    {
        return $this->ucenterApi->updateDomain($this->accessToken, [
            'description' => $desc,
        ], $forDomainId);
    }

}
