<?php

namespace Xedi\SendGrid\Exceptions;

/**
 * ContentValidation Exception
 * @package Xedi\SendGrid\Exceptions\ContentValidationException
 */
class ContentValidationException extends ValidationException
{
    /**
     * Get the Content from the Mailable
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return optional($this->mailable)
            ->getContent();
    }
}
