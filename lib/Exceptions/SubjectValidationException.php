<?php

namespace Xedi\SendGrid\Exceptions;

use Xedi\SendGrid\Exceptons\ValidationException;

/**
 * SubjectValidation Exception
 *
 * @package Xedi\SendGrid\Exceptions\SubjectValidationException
 * @author  Chris Smith <chris@xedi.com>
 */
class SubjectValidationException extends ValidationException
{
    /**
     * Get the Mailable's Subject property
     *
     * @return string|null Subject string
     */
    public function getSubject(): ?string
    {
        return optional($this->mailable)
            ->getSubject();
    }
}
