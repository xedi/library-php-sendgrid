<?php

namespace Xedi\SendGrid\Contracts;

use Xedi\SendGrid\Contracts\Client;

interface Mailable
{
    public function validate(): void;

    public function send(Client\Client $client): Response;
}
