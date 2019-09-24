<?php

namespace Tests\Unit\Clients\ApiClient;

use Tests\Unit\TestCase;
use Xedi\SendGrid\Clients\ApiClient;

class ConstructTest extends TestCase
{
    /**
     * @test
     */
    public function withoutOptions()
    {
        $guzzle_client = (new ApiClient('api-key'))->client;

        $this->assertEquals(
            'Bearer api-key',
            $guzzle_client->getConfig('headers')['Authorization']
        );
    }

    /**
     * @test
     */
    public function withOptions()
    {
        $guzzle_client = (new ApiClient('api-key', [ 'base_uri' => 'https://test.com' ]))->client;

        $this->assertEquals(
            'Bearer api-key',
            $guzzle_client->getConfig('headers')['Authorization']
        );

        $this->assertEquals(
            'https://test.com',
            $guzzle_client->getConfig('base_uri')
        );
    }
}
