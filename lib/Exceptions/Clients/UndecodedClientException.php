<?php

namespace Xedi\SendGrid\Exceptions\Clients;

use GuzzleHttp\Exception\ClientException;
use UnexpectedValueException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * A wild ClientException appeared! You are startled.
 *
 * @package Xedi\SendGrid\Exceptions\Clients
 * @author  Chris Smith <chris@xedi.com>
 */
class UndecodedClientException extends UnexpectedValueException implements ExceptionContract
{
    /**
     * Create a new UndecodedClientException
     *
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
