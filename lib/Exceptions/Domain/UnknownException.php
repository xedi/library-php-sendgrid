<?php

namespace Xedi\SendGrid\Exceptions\Domain;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * Represents an unplanned for Exception in the SendGrid Domain.
 * @package Xedi\SendGrid\Exceptions\Domain
 */
class UnknownException extends RuntimeException implements ExceptionContract
{
    /**
     * @param GuzzleException $previous Original Exception
     */
    public function __construct(GuzzleException $previous)
    {
        parent::__construct(
            "Unknown exception encountered: [{$previous->getCode()}] {get_class($previous)}",
            $previous->getCode(),
            $previous
        );
    }
}
