<?php

namespace Xedi\SendGrid\Mail\Concerns;

use Xedi\SendGrid\Mail\Entities\Recipient as Sender;

trait HasSender
{
    protected $from;

    /**
     * Set the Sender
     *
     * @param string      $email_address Email address of the Sender
     * @param string|null $name          Name of the Sender
     */
    public function setSender(string $email_address, string $name = null): self
    {
        $this->from = new Sender($email_address, $name);

        return $this;
    }
}
