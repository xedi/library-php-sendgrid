<?php

namespace Xedi\SendGrid\Exceptions;

use UnexpectedValueException;
use Xedi\SendGrid\Contracts\Exception;
use Xedi\SendGrid\Contracts\Mailable;

/**
 * Abstract ValidationException
 *
 * @package Xedi\SendGrid\Exceptions\ValidationException
 * @author  Chris Smith <chris@xedi.com>
 */
abstract class ValidationException extends UnexpectedValueException implements Exception
{
    /**
     * The Exception Code
     *
     * @var integer
     */
    protected int $code = 422;

    /**
     * Mailable that caused the exception
     *
     * @var Xedi\SendGrid\Contracts\Mailable
     */
    protected $mailable;

    /**
     * Create new extension of the ValidationException
     *
     * @param string   $message  Explanation of the exception
     * @param Mailable $mailable Mailable that is associated with the exception
     */
    public function __construct(string $message, Mailable $mailable)
    {
        parent::__construct($message);
        $this->mailable = $mailable;
    }

    /**
     * Get the associated mailable
     *
     * @return Mailable|null
     */
    public function getMailable(): ?Mailable
    {
        return $this->mailable;
    }
}
