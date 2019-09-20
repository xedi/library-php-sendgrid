<?php

namespace Xedi\SendGrid\Exceptions;

use Xedi\SendGrid\Exceptions\ValidationException;

/**
 * RecipientValidation Exception
 *
 * @package Xedi\SendGrid\Exceptions\RecipientValidationException
 * @author  Chris Smith <chris@xedi.com>
 */
class RecipientValidationException extends ValidationException
{
    /**
     * Get Recipients property from the Mailable
     *
     * @return array Associated Recipients of the Mailable
     */
    public function getRecipients(): array
    {
        return optional($this->mailable)
            ->getRecipients();
    }
}
