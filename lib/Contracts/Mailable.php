<?php

namespace Xedi\SendGrid\Contracts;

use Xedi\SendGrid\Contracts\Client;
use Xedi\SendGrid\Contracts\Response;

interface Mailable
{
    public function validate(): void;

    public function send(Client $client): Response;
}
