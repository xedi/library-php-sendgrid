<?php

namespace Xedi\SendGrid\Exceptions\Clients;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * An wild UnknownException appeared! You are suprised.
 *
 * @package Xedi\SendGrid\Exceptions
 * @author  Chris Smith <chris@xedi.com>
 */
class UnknownException extends RuntimeException implements ExceptionContract
{
    /**
     * Create a new UnknownException
     *
     * @param GuzzleException $exception Original Exception
     */
    public function __construct(GuzzleException $exception)
    {
        parent::__construct(
            "An unknown exception has been encountered: {$exception->getMessage()}",
            500,
            $exception
        );
    }
}
