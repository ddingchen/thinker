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

}
