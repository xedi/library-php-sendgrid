<?php

namespace Tests\SendGrid;

use Tests\TestCase;
use Xedi\SendGrid\Clients\ApiClient;
use Xedi\SendGrid\SendGrid;

class GetApiClientTest extends TestCase
{
    /**
     * @test
     */
    public function withoutOptions()
    {
        $client = SendGrid::getApiClient('api-key');

        $this->assertInstanceOf(ApiClient::class, $client);
    }

    /**
     * @test
     */
    public function withOptions()
    {
        $client = SendGrid::getApiClient('api-key', [ 'key' => 'value' ]);

        $this->assertInstanceOf(ApiClient::class, $client);
    }
}
