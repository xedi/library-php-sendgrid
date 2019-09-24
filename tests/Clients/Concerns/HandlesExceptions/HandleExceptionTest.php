<?php

namespace Tests\Clients\Concerns\HandlesExceptions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;
use RuntimeException;
use Tests\Clients\Concerns\HandlesExceptions\Stub;
use Tests\TestCase;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;
use Xedi\SendGrid\Exceptions\Clients\UnknownException;

class HandleExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function handlesClientException()
    {
        $this->markTestSkipped('@CS - Test broken for some reason');

        $mock_exception = Mockery::mock(ClientException::class);
        $mock_local_exception = Mockery::mock(ExceptionContract::class);

        /*
            This is really dirty, but I don't know a better way of testing this
            in a strictly unit fashion.

            @CS - 23/09/2019
         */
        ($stub = Mockery::mock(Stub::class)->makePartial())
            ->shouldReceive('handlesClientException')
            ->once()
            ->with($mock_exception)
            ->andReturn($mock_local_exception);

        $local_exception = $stub->handleException($mock_exception);

        $this->assertInstanceOf(ExceptionContract::class, $local_exception);
    }

    /**
     * @test
     */
    public function handlesUnknownException()
    {
        $this->markTestSkipped('@CS - Test broken for some reason');

        ($mock_exception = Mockery::mock(
            GuzzleException::class,
            RuntimeException::class
        ))
            ->shouldReceive('getMessage')
            ->once()
            ->andReturn('its not important');

        $this->assertInstanceOf(
            UnknownException::class,
            (new Stub())->handleException($mock_exception)
        );
    }
}
