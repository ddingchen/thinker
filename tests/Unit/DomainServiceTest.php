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

    private $service;

    protected function setUp()
    {
        parent::setUp();

        UCenterApi::fake();
        $this->service = new DomainService('token');
    }

    public function test_it_returns_all_domains_associated_with_current_app()
    {
        $domains = $this->service->list();

        $this->assertEquals(UCenterApi::getDomains(), $domains);
    }

    public function test_it_returns_domains_named_with_keywords()
    {
        $domains = $this->service->search('keyword');

        $this->assertEquals(UCenterApi::searchDomains(), $domains);
    }

}
