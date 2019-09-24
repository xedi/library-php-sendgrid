<?php

namespace Xedi\SendGrid\Clients\Concerns;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;
use Xedi\SendGrid\Exceptions\Clients\UndecodedClientException;
use Xedi\SendGrid\Exceptions\Clients\UnknownException;
use Xedi\SendGrid\Exceptions\Domain\FailedDecodingException;
use Xedi\SendGrid\Exceptions\Domain\MultipleDomainErrorsException;
use Xedi\SendGrid\Exceptions\Domain\UnknownException as UnknownDomainException;

/**
 * HandleExceptions Concern
 *
 * @package Xedi\SendGrid\Clients
 * @author  Chris Smith <chris@xedi.com>
 */
trait HandlesExceptions
{
    /**
     * Handles converting Guzzle exceptions into localized exceptions
     *
     * @param GuzzleException $exception Exception thrown by Guzzle
     *
     * @return ExceptionContract Instance of a local exception
     */
    protected function handleException(GuzzleException $exception): ExceptionContract
    {
        switch (get_class($exception)) {
            case (ClientException::class):
                return $this->handleClientException($exception);
                break;
            default:
                return $this->handleUnknownException($exception);
        }
    }

    /**
     * Handles exclusively Client (4xx) Exceptions
     *
     * @param ClientException $exception Original Exception
     *
     * @return ExceptionContract Am implementation of the local exception contract
     */
    private function handleClientException(ClientException $exception)
    {
        switch ($exception->getCode()) {
            case 400:
                return $this->handleBadRequestException($exception);
                break;
            default:
                return $this->handleUnknownException($exception);
        }
    }

    /**
     * Handles exclusively 400 BAD REQUEST exceptions
     *
     * @param ClientException $exception Original Exception
     *
     * @return ExceptionContract Am implementation of the local exception contract
     */
    private function handleBadRequestException(ClientException $exception)
    {
        $response = $exception->getResponse();

        if (! in_array('application/json', $response->getHeader('Accept'))) {
            return new UndecodedClientException($exception);
        }

        $body = json_decode((string) $response->getBody());
        if ($body === null && json_last_error()) {
            return new FailedDecodingException(
                json_last_error_msg(),
                500,
                $exception
            );
        }

        $errors = $body->errors ?: [];

        switch (count($errors)) {
            case 0:
                return $this->handleUnknownDomainException($exception);
                break;
            case 1:
                return $this->handleSendGridError($errors[0], $exception);
                break;
            default:
                return new MultipleDomainErrorsException(
                    array_map(
                        function ($error) use ($exception) {
                            return $this->handleSendGridError($error, $exception);
                        },
                        $errors
                    ),
                    500,
                    $exception
                );
        }
    }

    /**
     * Handles errors from SendGrid extracted from the ClientExceptions
     *
     * @param object          $error     Error Object
     * @param GuzzleException $exception Original Exception
     *
     * @return ExceptionContract Am implementation of the local exception contract
     */
    private function handleSendGridError(object $error, GuzzleException $exception)
    {
        if (Str::contains($error->field, '.')) {
            $parts = [];
            preg_match_all('/([[:alpha:]]+)/', $error->field, $parts);
            $parts = array_map(Str::class . '::title', $parts[0]);
            $short_name = join("\\", $parts) . "Exception";
        } else {
            $short_name = Str::title($error->field) . 'Exception';
        }
        $class_name = "Xedi\\SendGrid\\Exceptions\\Domain\\{$short_name}";

        try {
            return (new ReflectionClass($class_name))
                ->newInstance($error, $exception);
        } catch (ReflectionException $not_found_exception) {
            return $this->handleUnknownDomainException($exception);
        }
    }

    private function handleUnknownDomainException(GuzzleException $exception)
    {
        return new UnknownDomainException($exception);
    }

    /**
     * Handles Unrecognised Guzzle Exceptions
     *
     * @param GuzzleException $exception Original Exception
     *
     * @return UnknownException
     */
    private function handleUnknownException(GuzzleException $exception)
    {
        return new UnknownException($exception);
    }
}
