<?php

namespace Xedi\SendGrid\Mail;

use Xedi\SendGrid\Contracts\Clients\Client;
use Xedi\SendGrid\Contracts\Clients\Response;
use Xedi\SendGrid\Contracts\Mailable;
use Xedi\SendGrid\Mail\Concerns\HasContent;
use Xedi\SendGrid\Mail\Concerns\HasRecipients;
use Xedi\SendGrid\Mail\Concerns\HasSender;
use Xedi\SendGrid\Mail\Concerns\HasSubject;
use Xedi\SendGrid\Mail\Concerns\HasAttachment;

/**
 * Class Mail
 *
 * @package Xedi\SendGrid\Mail
 * @author  Chris Smith <chris@xedi.com>
 */
class Mail implements Mailable
{
    use HasAttachment;
    use HasContent;
    use HasRecipients;
    use HasSender;
    use HasSubject;

    /**
     * Validate the Mailable is sufficiently setup to be sent
     *
     * @return static
     */
    public function validate()
    {
        return $this->validateContent()
            ->validateRecipients()
            ->validateSender()
            ->validateSubject();
    }

    /**
     * Send the Mailable
     *
     * @param Client\Client $client Transmission Adapter
     *
     * @return Response An implementation of the Response contract
     */
    public function send(Client $client): Response
    {
        $this->validate();

        $data = array_merge_recursive(
            [],
            $this->buildContent(),
            $this->buildRecipients(),
            $this->buildSender(),
            $this->buildSubject()
        );

        if ($this->hasAttachment()) {
            $data = array_merge($data, $this->buildAttachment());
        }

        return $client->post('v3/mail/send', $data);
    }
}
