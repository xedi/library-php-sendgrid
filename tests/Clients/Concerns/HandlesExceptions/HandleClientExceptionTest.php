<?php

namespace Tests\Clients\Concerns\HandlesExceptions;

use GuzzleHttp\Exception\ClientException;
use Mockery;
use Tests\Clients\Concerns\HandlesExceptions\Stub;
use Tests\TestCase;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;
use Xedi\SendGrid\Exceptions\Clients\UnknownException;

class HandleClientExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function handles400()
    {
        ($mock_exception = Mockery::mock(ClientException::class))
            ->shouldReceive('getCode')
            ->once()
            ->andReturn(400);

        $mock_local_exception = Mockery::mock(ExceptionContract::class);

        /*
            This is really dirty, but I don't know a better way of testing this
            in a strictly unit fashion.

            @CS - 23/09/2019
         */
        ($mocked_stub = Mockery::mock(Stub::class)->makePartial())
            ->shouldReceive('handleClientException')
            ->once()
            ->with($mock_exception)
            ->andReturn($mock_local_exception);

        $local_exception = $mocked_stub->handleClientException($mock_exception);

        $this->assertInstanceOf(ExceptionContract::class, $local_exception);
    }

    /**
     * @test
     */
    public function handleUnknownException()
    {
        $mock_exception = Mockery::mock(ClientException::class);

        $this->assertInstanceOf(
            UnknownException::class,
            (new Stub())->handleClientException($mock_exception)
        );
    }
}
