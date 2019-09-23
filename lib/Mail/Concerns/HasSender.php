<?php

namespace Xedi\SendGrid\Mail\Concerns;

use Xedi\SenderGrid\Exceptions\SenderValidationException;
use Xedi\SendGrid\Mail\Entities\Sender;

/**
 * HasSender Concern
 *
 * @package Xedi\SendGrid\Mail\Concerns
 * @author  Chris Smith <chris@xedi.com>
 */
trait HasSender
{
    protected $from;

    /**
     * Set the Sender
     *
     * @param string      $email_address Email address of the Sender
     * @param string|null $name          Name of the Sender
     *
     * @return static
     */
    public function setSender(string $email_address, string $name = null): self
    {
        $this->from = new Sender($email_address, $name);

        return $this;
    }

    /**
     * Get the Mailable's Sender
     *
     * @return Sender Associated Sender object
     */
    public function getSender(): ?Sender
    {
        return $this->from;
    }

    /**
     * Check whether the sender property has been set
     *
     * @return boolean
     */
    public function hasSender(): bool
    {
        return ! is_null($this->from) &&
            $this->from instanceof Sender;
    }

    /**
     * Validate the Sender property
     *
     * @return static
     */
    public function validateSender(): self
    {
        if (is_null($this->from)) {
            throw new SenderValidationException('Missing Sender', $this);
        }

        if ($this->from instanceof Sender) {
            throw new SenderValidationException('Invalid Sender', $this);
        }

        return $this;
    }

    /**
     * Build the Sender data for the API Request
     *
     * @return array API data
     */
    public function buildSender(): array
    {
        return [
            'from' => $this->from->toArray()
        ];
    }
}
