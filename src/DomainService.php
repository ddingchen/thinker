<?php

namespace Thinker;

use Thinker\Facades\UCenterApi;

/**
* DomainService
*/
class DomainService
{

    private $accessToken;
    
    function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function list()
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
