<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;

class GetRolesInDomainTest extends TestCase
{

    public function test_it_returns_ok()
    {
        $fake = UCenterApi::fake();
        $fake->action('getRolesInDomain')
            ->using([
                'roles' => [
                    '10' => [],
                    '11' => [],
                ],
            ])
            ->push();

        $result = UCenterApi::getRolesInDomain(1, 'access_token');

        $this->assertCount(2, $result);
    }

}
