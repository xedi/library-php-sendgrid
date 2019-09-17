<?php

namespace Xedi\SendGrid\Mail\Concerns;

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
}
