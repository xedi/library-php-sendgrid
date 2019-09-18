<?php

namespace Xedi\SendGrid\Exceptions\Domain;

use GuzzleHttp\Exceptions\ClientException;
use UnexpectedValueException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * Represents the event that a response could not be parsed,
 * @package Xedi\SendGrid\Exceptions\Domain
 */
class UndecodedClientException extends UnexpectedValueException implements ExceptionContract
{
    /**
     * @param ClientException $previous Original Exception
     */
    public function __construct(ClientException $previous)
    {
        parent::__construct(
            "ClientException returned by SendGrid not in a parsible format",
            500,
            $previous
        );
    }
}
