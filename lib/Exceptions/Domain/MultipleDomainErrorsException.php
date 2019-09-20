<?php

namespace Xedi\SendGrid\Exceptions\Domain;

use DomainException;
use GuzzleHttp\Exception\GuzzleException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * Exception representing Multiple exceptions
 *
 * @package Xedi\SendGrid\Exceptions\Domain
 * @author  Chris Smith <chris@xedi.com>
 */
class MultipleDomainErrorsException extends DomainException implements ExceptionContract
{
    /**
     * List of Exceptions
     *
     * @var array
     */
    protected $exceptions = [];

    /**
     * Create a new MultipleDomainErrorsException
     *
     * @param array                $exceptions Array of Exception objects
     * @param int|integer          $code       Status Code to report
     * @param GuzzleException|null $previous   Original Exception
     */
    public function __construct(array $exceptions, int $code = 500, GuzzleException $previous = null)
    {
        parent::__construct(
            'Multiple Domain errors were returned by SendGrid',
            $code,
            $previous
        );

        $this->exceptions = $exceptions;
    }

    /**
     * String representation of the exception
     *
     * @return string
     */
    public function __toString()
    {
        $exception_messages = array_map($this->exceptions, function ($exception) {
            return (string) $exception;
        });

        $exception_messages = implode("\r\n", $exception_messages);

        return <<<EOL
{__CLASS__}[{$this->code}]: {$this->message}
{$exception_messages}
EOL;
    }
}
