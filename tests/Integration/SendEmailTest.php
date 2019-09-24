<?php

namespace Tests\Integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Integration\TestCase;
use Xedi\SendGrid\SendGrid;

class SendEmailTest extends TestCase
{
    /**
     * @test
     */
    public function positive()
    {
        SendGrid::setClient(
            SendGrid::getApiClient(
                'api-key',
                [
                    'handler' => HandlerStack::create(
                        new MockHandler(
                            [
                                new Response(200, []),
                            ]
                        )
                    ),
                ]
            )
        );

        ($mailable = SendGrid::prepareMail())
            ->setSender('n.fury@shield.com', 'Nick Fury')
            ->addRecipient('t.stark@shield.com', 'Tony Stark (Iron Man)')
            ->addRecipients([
                [ 'b.banner@shield.com', 'Bruce Banner (Hulk)' ],
                [ 'n.romanoff@shield.com', 'Natasha Romanoff (Black Widow)' ],
                [ 's.rogers@shield.com', 'Steve Rogers (Captain America)' ],
                [ 'c.barton@shield.com', 'Clint Barton (Hawkeye)' ],
            ])
            ->setSubject('[Gossip] Thor got fat!')
            ->addTextContent('Thor got fat! Don\'t mention it to him.')
            ->addHtmlContent('<body>Thor got <b>fat!</b> <strong>Don\'t mention it to him.</strong></body>');

        $response = SendGrid::send($mailable);

        $this->assertTrue($response->isSuccessful());
    }
}
