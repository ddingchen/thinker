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

        $this->fake = UCenterApi::fake();
        $this->service = new DomainService('token');
    }

    public function test_it_returns_all_domains_associated_with_current_app()
    {
        $this->fake->action('getDomains')
            ->using([
                "1" => [
                  "id" => "1",
                  "name" => "新格尔软件",
                  "description" => "新格尔软件"
                ]
            ], true)->push();

        $domains = $this->service->list();

        $this->assertCount(1, $domains);
    }

    public function test_it_returns_domains_named_with_keywords()
    {
        $this->fake->action('searchDomains')
            ->using([
                "1" => [
                  "id" => "1",
                  "name" => "域名1",
                  "description" => "域描述1",
                  "created_at" => "2017-04-10 22:42:55",
                  "updated_at" => "2017-04-10 22:42:55"
                ]
            ], true)->push();

        $domains = $this->service->search('keyword');

        $this->assertCount(1, $domains);
    }

    public function test_it_returns_a_domain()
    {
        $this->fake->action('getDomainById')
            ->using(["domain.id" => 123])
            ->push();

        $domain = $this->service->find(1);

        $this->assertEquals(123, $domain->domain->id);
    }

    public function test_it_creates_a_domain()
    {
        $this->fake->action('createDomain')
            ->using(["id" => 123])
            ->push();

        $domain = $this->service->create('name', 'desc');

        $this->assertEquals(123, $domain->id);
    }

    public function test_it_updates_info_of_a_domain()
    {
        $this->fake->action('updateDomain')
            ->using(["description" => 'new desc'])
            ->push();

        $domain = $this->service->updateDesc(1, 'new desc');

        $this->assertEquals('new desc', $domain->description);
    }

}
