<?php

namespace Xedi\SendGrid\Mail;

use Xedi\SendGrid\Contracts\Client;
use Xedi\SendGrid\Contracts\Mailable;
use Xedi\SendGrid\Contracts\Response;
use Xedi\SendGrid\Mail\Concerns\HasContent;
use Xedi\SendGrid\Mail\Concerns\HasRecipients;
use Xedi\SendGrid\Mail\Concerns\HasSender;
use Xedi\SendGrid\Mail\Concerns\HasSubject;

/**
 * Class Mail
 * @package Xedi\SendGrid\Mail
 */
class Mail implements Mailable
{
    use HasContent;
    use HasRecipients;
    use HasSender;
    use HasSubject;

    /**
     * Validate the Mailable is sufficiently setup to be sent
     *
     * @return static
     */
    final public function validate(): self
    {
        return $this->validateContent()
            ->validateRecipients()
            ->validateSender()
            ->validateSubject();
    }

    /**
     * Send the Mailable
     *
     * @param  Client\Client $client Transmission Adapter
     *
     * @return Response An implementation of the Response contract
     */
    final public function send(Client\Client $client): Response
    {
    }
}
