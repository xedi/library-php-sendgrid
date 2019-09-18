<?php

namespace Xedi\SendGrid\Exceptions\Clients;

use RuntimeException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * An wild UnknownException appeared! You are suprised.
 *
 * @package Xedi\SendGrid\Exceptions
 */
class UnknownException extends RuntimeException implements ExceptionContract
{
    /**
     * @param GuzzleException $exception
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
