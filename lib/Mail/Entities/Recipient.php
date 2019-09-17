<?php

namespace Xedi\SendGrid\Mail\Entities;

use Xedi\SendGrid\Mail\Entities\Entity;

/**
 * Recipient Class
 * @package Xedi\SendGrid\Mail\Entities\Recipient
 */
class Recipient extends Entity
{
    /**
     * @param string      $email_address Recipient Email Address
     * @param string|null $name          Recipient Name
     */
    public function __construct(string $email_address, string $name = null)
    {
        parent::__construct([
            'email' => $email_address,
            'name' => $name
        ]);
    }
}
