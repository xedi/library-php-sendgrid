<?php

namespace Xedi\SendGrid\Exceptions\Domain;

use GuzzleHttp\Exception\ClientException;
use UnexpectedValueException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * Represents the event that a response could not be parsed,
 *
 * @package Xedi\SendGrid\Exceptions\Domain
 * @author  Chris Smith <chris@xedi.com>
 */
class UndecodedClientException extends UnexpectedValueException implements ExceptionContract
{
    /**
     * Create a new UndecodedClientException
     *
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
