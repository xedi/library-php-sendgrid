<?php

namespace Tests\Clients\ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use Mockery;
use ReflectionClass;
use ReflectionProperty;
use Tests\TestCase;
use Xedi\SendGrid\Clients\ApiClient;

class SetClientTest extends TestCase
{
    /**
     * @test
     */
    public function positive()
    {
        $mock_guzzle_client = Mockery::mock(GuzzleClient::class);

        $api_client = (new ReflectionClass(ApiClient::class))
            ->newInstanceWithoutConstructor();

        $api_client->setClient($mock_guzzle_client);

        ($reflection = new ReflectionProperty($api_client, 'client'))
            ->setAccessible(true);

        $this->assertInstanceOf(
            GuzzleClient::class,
            $reflection->getValue($api_client)
        );
    }
}
