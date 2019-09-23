<?php

namespace Xedi\SendGrid\Exceptions;

use DomainException as BaseDomainException;
use GuzzleHttp\Exception\GuzzleException;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * Abstract DomainException representing the SendGrip error
 *
 * @package Xedi\SendGrid\Exceptions\Domain
 * @author  Chris Smith <chris@xedi.com>
 */
abstract class DomainException extends BaseDomainException implements ExceptionContract
{
    /**
     * Help URL
     *
     * @var string $help_url Link to SendGrid documentation
     */
    protected $help_url;

    /**
     * Create a new instance of an extension of the DomainException
     *
     * @param object          $error    Error object sent back from SendGrid
     * @param GuzzleException $previous The origin exception
     * @param int|integer     $code     Status code to report
     */
    public function __construct(object $error, GuzzleException $previous, int $code = 422)
    {
        parent::__construct(
            $error->message,
            $code,
            $previous
        );

        $this->help_url = $error->help;
    }

    /**
     * String representation of the exception
     *
     * @return string The exception
     */
    public function __toString()
    {
        return <<<EOL
{__CLASS__}[{$this->code}]: {$this->message}
For more information see: {$this->help_url}
EOL;
    }
}
