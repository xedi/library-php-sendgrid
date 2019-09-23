<?php

namespace Xedi\SendGrid\Mail\Concerns;

use Xedi\SendGrid\Exceptions\SubjectValidationException;

/**
 * HasSubject Concern
 *
 * @package Xedi\SendGrid\Mail\Concerns
 * @author  Chris Smith <chris@xedi.com>
 */
trait HasSubject
{
    protected $subject;

    /**
     * Set the Subject for the Mailable
     *
     * @param string $subject Mailable Subject
     *
     * @return static
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the Subject for the Mailable
     *
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Check whether the subject property has been set
     *
     * @return boolean
     */
    public function hasSubject(): bool
    {
        return ! is_null($this->subject) &&
            is_string($this->subject);
    }

    /**
     * Validate the Mailable's Subject
     *
     * @throws Xedi\SendGrid\Exceptons\SubjectValidationException
     *
     * @return static
     */
    public function validateSubject()
    {
        if (is_null($this->subject)) {
            throw new SubjectValidationException('Missing Subject', $this);
        }

        if (! is_string($this->subject)) {
            throw new SubjectValidationExcepton('Invalid Subject', $this);
        }

        return $this;
    }

    /**
     * Build the Subject data for the API Request
     *
     * @return string API data
     */
    public function buildSubject(): array
    {
        return [
            'subject' => $this->subject
        ];
    }
}
