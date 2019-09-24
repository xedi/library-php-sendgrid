<?php

namespace Tests\Unit\Clients\ApiClient;

use ReflectionProperty;
use Tests\Unit\TestCase;
use Xedi\SendGrid\Clients\ApiClient;

class ConstructTest extends TestCase
{
    /**
     * @test
     */
    public function withoutOptions()
    {
        $client = new ApiClient('api-key');

        ($reflection = new ReflectionProperty(ApiClient::class, 'client'))
            ->setAccessible(true);

        $guzzle_client = $reflection->getValue($client);

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
        $client = new ApiClient('api-key', [ 'base_uri' => 'https://test.com' ]);

        ($reflection = new ReflectionProperty(ApiClient::class, 'client'))
            ->setAccessible(true);

        $guzzle_client = $reflection->getValue($client);

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
