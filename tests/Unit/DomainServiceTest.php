<?php

namespace Tests\Unit;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;
use Thinker\Testing\HttpClientFake;
use Thinker\UCenter\Service\DomainService;

/**
 * DomainServiceTest
 */
class DomainServiceTest extends TestCase
{

    private $service;

    protected function setUp()
    {
        parent::setUp();

        $this->clientFake = new HttpClientFake();
        $this->service = new DomainService('token');
    }

    public function test_it_returns_all_domains_associated_with_current_app()
    {
        $this->clientFake->mock('getDomains', [
            "1" => [
              "id" => "1",
              "name" => "新格尔软件",
              "description" => "新格尔软件"
            ]
        ], true)->applyClient();

        $domains = $this->service->listAll();

        $this->assertCount(1, $domains);
    }

    public function test_it_returns_domains_named_with_keywords()
    {
        $this->clientFake->mock('searchDomains', [
            "1" => [
              "id" => "1",
              "name" => "域名1",
              "description" => "域描述1",
              "created_at" => "2017-04-10 22:42:55",
              "updated_at" => "2017-04-10 22:42:55"
            ]
        ], true)->applyClient();

        $domains = $this->service->search('keyword');

        $this->assertCount(1, $domains);
    }

    public function test_it_returns_a_domain()
    {
        $this->clientFake
            ->mock('getDomainById', ["domain.id" => 123])
            ->applyClient();

        $domain = $this->service->find(1);

        $this->assertEquals(123, $domain->domain->id);
    }

    public function test_it_creates_a_domain()
    {
        $this->clientFake
            ->mock('createDomain', ["id" => 123])
            ->applyClient();

        $domain = $this->service->create('name', 'desc');

        $this->assertEquals(123, $domain->id);
    }

    public function test_it_updates_info_of_a_domain()
    {
        $this->clientFake
            ->mock('updateDomain', ["description" => 'new desc'])
            ->applyClient();

        $domain = $this->service->updateDesc(1, 'new desc');

        $this->assertEquals('new desc', $domain->description);
    }

}
