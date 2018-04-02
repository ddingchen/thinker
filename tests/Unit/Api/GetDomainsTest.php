<?php 

namespace Tests\Unit\Api;

use Tests\TestCase;
use Thinker\Facades\UCenterApi;


class GetDomainsTest extends TestCase
{
    
    public function test_it_returns_ok()
    {
        UCenterApi::fake();

        $result = UCenterApi::getDomains($accessToken = 'IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertObjectHasAttribute('id', $result[0]);
    }

    public function test_it_returns_none()
    {
        $fake = UCenterApi::fake();
        $fake->action('getDomains')
            ->expect('none')
            ->push();

        $result = UCenterApi::getDomains($accessToken = 'IsFrLIQfKZ4YVba5qUS2q1UyXE24pJCkO5NC9i3I');

        $this->assertCount(0, $result);
    }

}
