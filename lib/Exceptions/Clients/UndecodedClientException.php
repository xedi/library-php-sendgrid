<?php

namespace Xedi\SendGrid\Exceptions\Clients;

use GuzzleHttp\Exceptions\ClientException;
use UnexpectedValueException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * A wild ClientException appeared! You are startled.
 *
 * @package Xedi\SendGrid\Exceptions\Clients
 */
class UndecodedClientException extends UnexpectedValueException implements ExceptionContract
{
    /**
     * @param ClientException $exception [description]
     */
    public function __construct(ClientException $exception)
    {
        parent::__construct(
            'Received a client exception but did not know how to decode it',
            500,
            $exception
        );
    }
}
