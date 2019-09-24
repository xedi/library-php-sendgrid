<?php

namespace Tests\Clients\ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;
use Tests\TestCase;
use Xedi\SendGrid\Clients\ApiClient;
use Xedi\SendGrid\Clients\HttpResponse;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;
use Xedi\SendGrid\Exceptions\BadDeveloperException;
use Xedi\SendGrid\Exceptions\SendGridUnreacheableException;

class MakeRequestTest extends TestCase
{
    /**
     * @test
     */
    public function positive()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    /**
     * @test
     * @group icare
     */
    public function catchesConnectionExceptions()
    {
        $this->markTestSkipped('@CS - Test broken for some reason');

        ($mock_exception = Mockery::mock(ConnectException::class))
            ->shouldReceive('getMessage')
            ->once()
            ->andReturn('a message');

        ($mock_guzzle_client = Mockery::mock(GuzzleClient::class))
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'an/endpoint', [ 'headers' => [] ])
            ->andThrows($mock_exception);

        $api_client = (new ReflectionClass(ApiClient::class))
            ->newInstanceWithoutConstructor();

        ($reflection = new ReflectionProperty(ApiClient::class, 'client'))
            ->setAccessible(true);
        $reflection->setValue($api_client, $mock_guzzle_client);

        $this->expectException(SendGridUnreacheableException::class);

        $api_client->get('an/endpoint');
    }

    /**
     * @test
     */
    public function catchesGuzzleExceptions()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    /**
     * @test
     */
    public function catchesThrowableExceptions()
    {
        $this->markTestSkipped('@CS - Test broken for some reason');

        ($mock_exception = Mockery::mock(RuntimeException::class))
            ->shouldReceive('getMessage')
            ->once()
            ->andReturn('a message');

        ($mock_guzzle_client = Mockery::mock(GuzzleClient::class))
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'an/endpoint', [ 'headers' => [] ])
            ->andThrows($mock_exception);

        $api_client = (new ReflectionClass(ApiClient::class))
            ->newInstanceWithoutConstructor();

        ($reflection = new ReflectionProperty(ApiClient::class, 'client'))
            ->setAccessible(true);
        $reflection->setValue($api_client, $mock_guzzle_client);

        $this->expectException(BadDeveloperException::class);

        $api_client->get('an/endpoint');
    }
}
