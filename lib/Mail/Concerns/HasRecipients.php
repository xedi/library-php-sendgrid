<?php

namespace Xedi\SendGrid\Mail\Concerns;

use Xedi\SendGrid\Exceptions\RecipientValidationException;
use Xedi\SendGrid\Mail\Entities\Recipient;

trait HasRecipients
{
    protected $recipients = [];

    /**
     * Add a Recipient
     *
     * @param string      $email_address Email address of the intended recipient
     * @param string|null $name          Name of the intended recipient
     */
    public function addRecipient(string $email_address, string $name = null): self
    {
        $this->recipients[] = new Recipient($email_address, $name);

        return $this;
    }

    /**
     * Add multiple Recipients at once
     *
     * ```php
     * $mailable->addRecipients(
     *     [
     *         ['test@test.com', 'Test Person'],
     *     ]
     * );
     * ```
     *
     * @param array  $recipients Array of Recipients
     */
    public function addRecipients(array $recipients): self
    {
        foreach ($recipients as $recipient) {
            $this->addRecipient(...$recipient);
        }

        return $this;
    }

    /**
     * Get the Recipients Property
     *
     * @return array Array of Recipient objects
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Check whether any recipients have been provider
     *
     * @return boolean
     */
    public function hasRecipients(): bool
    {
        return ! empty($this->recipients) &&
            array_every($this->recipients, function ($item) {
                return $item instanceof Recipient;
            });
    }

    /**
     * Validate the Recipients property
     *
     * @throws Xedi\SendGrid\Exceptions\RecipientValidationException
     * @return static
     */
    public function validateRecipients(): self
    {
        if (empty($this->recipients) {
            throw new RecipientValidationException('Missing Recipients', $this);
        }

        $has_recipient_objects = array_every($this->recipients, function ($item) {
            return $item instanceof Recipient;
        });

        if (! $has_recipient_objects) {
            throw new RecipientValidationException('Invalid Recipient Objects', $this);
        }

        return $this;
    }
}
