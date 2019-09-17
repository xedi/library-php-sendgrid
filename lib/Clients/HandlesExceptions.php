<?php

namespace Xedi\SendGrid\Clients;

use GuzzleHttp\Exception\GuzzleException;

trait HandlesExceptions
{
    /**
     * Handles converting Guzzle exceptions into localized exceptions
     *
     * @param  GuzzleException $exception Exception thrown by Guzzle
     * @return void
     */
    protected function handleException(GuzzleException $exception)
    {

    }
}
