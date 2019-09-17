<?php

namespace Xedi\SendGrid\Mail;

use Xedi\SendGrid\Contracts\Client;
use Xedi\SendGrid\Contracts\Mailable;
use Xedi\SendGrid\Contracts\Response;

/**
 * Class Mail
 * @package Xedi\SendGrid\Mail
 */
class Mail implements Mailable
{

    /**
     * @param Client\Client $client
     *
     * @return Response
     */
    public function send(Client\Client $client): Response
    {
        // TODO: Implement send() method.
    }

    public function validate(): void
    {
        // TODO: Implement validate() method.
    }
}
