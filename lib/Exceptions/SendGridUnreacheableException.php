<?php

namespace Xedi\SendGrid\Exceptions;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use RuntimeException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * SendGridUnreachableException
 *
 * @package Xedi\SendGrid\Exceptions\SendGridUnreachable
 * @author  Chris Smith <chris@xedi.com>
 */
class SendGridUnreacheableException extends RuntimeException implements ExceptionContract
{
    /**
     * Convert a GuzzleHttp ConnectException into an instance of SendGridUnreachable
     *
     * @param ConnectException $exception Guzzle's connection exception
     *
     * @return self
     */
    public static function fromConnectionException(ConnectException $exception): self
    {
        return new self($exception->getMessage(), 503, $exception);
    }

    /**
     * Convert a GuzzleHttp ServerException into an instance of SendGridUnreachable
     *
     * @param ServerException $exception Guzzle's server exception
     *
     * @return self
     */
    public static function fromServerException(ServerException $exception): self
    {
        return new self($exception->getMessage(), 503, $exception);
    }
}
