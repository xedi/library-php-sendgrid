<?php

namespace Tests\Unit\Clients\Concerns\HandlesExceptions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;
use RuntimeException;
use Tests\Unit\Clients\Concerns\HandlesExceptions\Stub;
use Tests\Unit\TestCase;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;
use Xedi\SendGrid\Exceptions\Clients\UnknownException;

class HandleExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function handlesClientException()
    {
        $mock_exception = Mockery::mock(ClientException::class);
        $mock_local_exception = Mockery::mock(ExceptionContract::class);

        /*
            This is really dirty, but I don't know a better way of testing this
            in a strictly unit fashion.

            @CS - 23/09/2019
         */
        ($stub = Mockery::mock(Stub::class)->makePartial())
            ->shouldReceive('handleClientException')
            ->once()
            ->with($mock_exception)
            ->andReturn($mock_local_exception);

        $local_exception = $stub->handleException($mock_exception);

        $this->assertInstanceOf(ExceptionContract::class, $local_exception);
    }

    /**
     * @test
     * @group icare
     */
    public function handlesUnknownException()
    {
        $mock_exception = Mockery::mock(
            GuzzleException::class,
            RuntimeException::class,
            ['its not important']
        )
            ->makePartial();

        $this->assertInstanceOf(
            UnknownException::class,
            (new Stub())->handleException($mock_exception)
        );
    }
}
