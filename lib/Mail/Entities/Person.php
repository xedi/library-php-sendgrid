<?php

namespace Xedi\SendGrid\Mail\Entities;

use Xedi\SendGrid\Mail\Entities\Entity;

/**
 * Abstract Person Class
 *
 * @package  Xedi\SendGrid\Mail\Entities
 * @author   Chris Smith <chris@xedi.com>
 * @property string $email_address Email address of the Person
 * @property string $name          Name of the Person
 */
abstract class Person extends Entity
{
    /**
     * Create an instance of a class that extends the Person Entity
     *
     * @param string      $email_address Person Email Address
     * @param string|null $name          Person Name
     */
    public function __construct(string $email_address, string $name = null)
    {
        parent::__construct([
            'email' => $email_address,
            'name' => $name
        ]);
    }
}
