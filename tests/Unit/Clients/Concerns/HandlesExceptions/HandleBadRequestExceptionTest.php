<?php

namespace Tests\Unit\Clients\Concerns\HandlesExceptions;

use GuzzleHttp\Exception\ClientException;
use Mockery;
use Psr\Http\Message\ResponseInterface;
use Tests\Unit\Clients\Concerns\HandlesExceptions\Stub;
use Tests\Unit\TestCase;
use Xedi\SendGrid\Exceptions\Clients\UndecodedClientException;
use Xedi\SendGrid\Exceptions\Clients\UnknownException;
use Xedi\SendGrid\Exceptions\Domain\ContentException;
use Xedi\SendGrid\Exceptions\Domain\FailedDecodingException;
use Xedi\SendGrid\Exceptions\Domain\MultipleDomainErrorsException;
use Xedi\SendGrid\Exceptions\Domain\Personalization\ToException;
use Xedi\SendGrid\Exceptions\Domain\PersonalizationException;
use Xedi\SendGrid\Exceptions\Domain\SubjectException;

class HandleBadRequestExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function unableToDecodeException()
    {
        ($mock_response = Mockery::mock(ResponseInterface::class))
            ->shouldReceive('getHeader')
            ->once()
            ->with('Accepts')
            ->andReturn('text/plain');

        ($mock_exception = Mockery::mock(ClientException::class))
            ->shouldReceive('getResponse')
            ->once()
            ->andReturn($mock_response);

        $this->assertInstanceOf(
            UndecodedClientException::class,
            (new Stub())->handleBadRequestException($mock_exception)
        );
    }

    /**
     * @test
     */
    public function failedToDecodeException()
    {
        ($mock_response = Mockery::mock(ResponseInterface::class))
            ->shouldReceive('getHeader')
            ->once()
            ->with('Accepts')
            ->andReturn('application/json');

        $mock_response->shouldReceive('getResponse')
            ->once()
            ->andReturn('some-content');

        ($mock_exception = Mockery::mock(ClientException::class))
            ->shouldReceive('getResponse')
            ->once()
            ->andReturn($mock_response);

        $this->assertInstanceOf(
            FailedDecodingException::class,
            (new Stub())->handleBadRequestException($mock_exception)
        );
    }

    /**
     * @test
     */
    public function handlesUnknownException()
    {
        ($mock_response = Mockery::mock(ResponseInterface::class))
            ->shouldReceive('getHeader')
            ->once()
            ->with('Accepts')
            ->andReturn('application/json');

        $mock_response->shouldReceive('getResponse')
            ->once()
            ->andReturn(json_encode(['errors' => []]));

        ($mock_exception = Mockery::mock(ClientException::class))
            ->shouldReceive('getResponse')
            ->once()
            ->andReturn($mock_response);

        $this->assertInstanceOf(
            UnknownException::class,
            (new Stub())->handleBadRequestException($mock_exception)
        );
    }

    /**
     * @test
     * @dataProvider providesSendGridErrors
     */
    public function handlesSendGridError($error, $exception_class)
    {
        ($mock_response = Mockery::mock(ResponseInterface::class))
            ->shouldReceive('getHeader')
            ->once()
            ->with('Accepts')
            ->andReturn('application/json');

        $mock_response->shouldReceive('getResponse')
            ->once()
            ->andReturn(json_encode(['errors' => [$error]]));

        ($mock_exception = Mockery::mock(ClientException::class))
            ->shouldReceive('getResponse')
            ->once()
            ->andReturn($mock_response);

        $this->assertInstanceOf(
            $exception_class,
            (new Stub())->handleBadRequestException($mock_exception)
        );
    }

    public function providesSendGridErrors()
    {
        return [
            'ContentException' => [
                [
                    'field' => 'content',
                    'message' => 'content error message',
                    'help' => 'help url'
                ],
                ContentException::class
            ],
            'SubjectException' => [
                [
                    'field' => 'subject',
                    'message' => 'subject error message',
                    'help' => 'help url'
                ],
                SubjectException::class
            ],
            'Personalization\\ToException' => [
                [
                    'field' => 'personalization.to',
                    'message' => 'personalization.to error message',
                    'help' => 'help url'
                ],
                ToException::class
            ],
        ];
    }

    /**
     * @test
     */
    public function handlesMultipleDomainErrors()
    {
        ($mock_response = Mockery::mock(ResponseInterface::class))
            ->shouldReceive('getHeader')
            ->once()
            ->with('Accepts')
            ->andReturn('application/json');

        $errors = array_map(
            function ($error) {
                return $error[0];
            },
            $this->providesSendGridErrors()
        );
        $errors = array_values($errors);

        $mock_response->shouldReceive('getResponse')
            ->once()
            ->andReturn(json_encode(['errors' => $errors]));

        ($mock_exception = Mockery::mock(ClientException::class))
            ->shouldReceive('getResponse')
            ->once()
            ->andReturn($mock_response);

        $this->assertInstanceOf(
            MultipleDomainErrorsException::class,
            (new Stub())->handleBadRequestException($mock_exception)
        );
    }
}
