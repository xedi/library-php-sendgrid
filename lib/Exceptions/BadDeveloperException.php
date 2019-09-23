<?php

namespace Xedi\SendGrid\Exceptions;

use LogicException;
use Throwable;
use Xedi\SendGrid\Contracts\Exception as ExceptionContract;

/**
 * BadDeveloperException
 *
 * @package Xedi\SendGrid\Exceptions
 * @author  Chris Smith <chris@xedi.com>
 */
class BadDeveloperException extends LogicException implements ExceptionContract
{
    /**
     * Returns an instance of the BadDeveloperException.
     *
     * If you are seeing this it's because a negative path has occured
     * that was not covered or accounted for.
     *
     * @param Throwable $exception Caught Exception
     *
     * @return static
     */
    public static function uncaughtException(Throwable $exception)
    {
        return new static(
            "An exception has not been handled correctly",
            500,
            $exception
        );
    }
}
