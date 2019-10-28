<?php

namespace Tests\Unit\Clients\ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use RuntimeException;
use Tests\Unit\TestCase;
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
     */
    public function catchesConnectionExceptions()
    {
        $mock_exception = Mockery::mock(
            ConnectException::class,
            [
                'a message',
                Mockery::mock(RequestInterface::class)
            ]
        )
            ->makePartial();

        ($mock_guzzle_client = Mockery::mock(GuzzleClient::class))
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'an/endpoint', [ 'headers' => [], 'json' => [] ])
            ->andThrows($mock_exception);

        $api_client = (new ReflectionClass(ApiClient::class))
            ->newInstanceWithoutConstructor();

        $api_client->client = $mock_guzzle_client;

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
        $mock_exception = Mockery::mock(RuntimeException::class, ['a message'])
            ->makePartial();

        ($mock_guzzle_client = Mockery::mock(GuzzleClient::class))
            ->shouldReceive('request')
            ->once()
            ->with('GET', 'an/endpoint', [ 'headers' => [], 'json' => [] ])
            ->andThrows($mock_exception);

        $api_client = (new ReflectionClass(ApiClient::class))
            ->newInstanceWithoutConstructor();

        $api_client->client = $mock_guzzle_client;

        $this->expectException(BadDeveloperException::class);

        $api_client->get('an/endpoint');
    }
}
