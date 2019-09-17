<?php

namespace Xedi\SendGrid\Exceptions;

use GuzzleHttp\Exception\ConnectException;
use RuntimeException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * SendGridUnreachable Exception
 *
 * @package Xedi\SendGrid\Exceptions\SendGridUnreachable
 */
class SendGridUnreacheable extends RuntimeException implements ExceptionContract
{
    /**
     * Convert a GuzzleHttp ConnectException into an instance of SendGridUnreachable
     *
     * @param  ConnectException $exception Guzzle's connection exception
     *
     * @return self
     */
    public static function fromConnectionException(ConnectException $exception): self
    {
        return new self($exception->getMessage(), 503, $exception);
    }
}