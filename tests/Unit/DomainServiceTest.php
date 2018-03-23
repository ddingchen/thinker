<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\DomainService;
use Thinker\Facades\UCenterApi;

/**
* DomainServiceTest
*/
class DomainServiceTest extends TestCase
{
    
    public function test_it_returns_all_domains_associated_with_current_app()
    {
        UCenterApi::fake();

        $service = new DomainService('token');

        $domains = $service->list();
        
        $this->assertCount(2, $domains);
    }

}
