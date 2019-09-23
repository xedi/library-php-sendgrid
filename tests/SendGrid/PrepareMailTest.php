<?php

namespace Tests\SendGrid;

use Tests\TestCase;
use Xedi\SendGrid\SendGrid;
use Xedi\SendGrid\Mail\Mail;

class PrepareMailTest extends TestCase
{
    /**
     * @test
     */
    public function positive()
    {
        $mailable = SendGrid::prepareMail();

        $this->assertInstanceOf(Mail::class, $mailable);
    }
}
