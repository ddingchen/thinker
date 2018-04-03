<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;


class GetDomainByIdTest extends TestCase
{
    
    public function test_it_returns_ok()
    {
        UCenterApi::fake();

        $result = UCenterApi::getDomainById(1, $accessToken = 'access_token');

        $this->assertObjectHasAttribute('domain', $result);
    }

    public function test_it_returns_none()
    {
        $fake = UCenterApi::fake();
        $fake->action('getDomainById')
            ->expect('none')
            ->push();

        $result = UCenterApi::getDomainById(1, $accessToken = 'access_token');

        $this->assertNull($result);
    }

}
