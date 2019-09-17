<?php

namespace Xedi\SendGrid\Mail\Concerns;

trait HasSubject
{
    protected $subject;

    /**
     * Set the Subject for the Mailable
     *
     * @param string $subject Mailable Subject
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
