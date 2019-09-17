<?php

namespace Xedi\SendGrid\Clients;

use GuzzleHttp\Exception\GuzzleException;
use Xedi\SendGrid\Contracts\Exception as ExceptonContract;

trait HandlesExceptions
{
    /**
     * Handles converting Guzzle exceptions into localized exceptions
     *
     * @param  GuzzleException $exception Exception thrown by Guzzle
     *
     * @return ExceptionContract Instance of a local exception
     */
    protected function handleException(GuzzleException $exception): ExceptionContract
    {
    }
}
