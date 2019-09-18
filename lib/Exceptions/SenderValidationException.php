<?php

namespace Xedi\SendGrid\Exceptions;

use Xedi\SendGrid\Exceptions\ValidationException;
use Xedi\SendGrid\Mail\Entities\Sender;

/**
 * SenderValidation Exception
 *
 * @package Xedi\SendGrid\Exceptions\SenderValidationException
 */
class SenderValidationException extends ValidationException
{
    /**
     * Get the Sender from the Mailable
     *
     * @return Sender|null
     */
    public function getSender(): ?Sender
    {
        return optional($this->mailable)
            ->getSender();
    }
}
