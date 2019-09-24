<?php

namespace Tests\Integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\Integration\TestCase;
use Xedi\SendGrid\SendGrid;
use Xedi\SendGrid\Exceptions\Domain as DomainExceptions;

class SendEmailTest extends TestCase
{
    /**
     * @test
     */
    public function positive()
    {
        $this->setupMockHandler(
            [
                new Response(200, []),
            ]
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

    /**
     * @test
     * @dataProvider providesNegativeScenarios
     */
    public function negative(array $queue, string $exception_class)
    {
        $this->setupMockHandler($queue);

        ($mailable = SendGrid::prepareMail())
            ->setSubject('Negative Test')
            ->setSender('negative.sender@test.com', 'Negative Sender')
            ->addRecipient('negative.recipient@test.com', 'Negative Recipient')
            ->addTextContent('Negative Test');

        $this->expectException($exception_class);

        SendGrid::send($mailable);
    }

    public function providesNegativeScenarios()
    {
        return [
            'to parameter is required' => [
                [
                    $this->getMockErrorResponse(
                        [
                            [
                                'field' => 'personalization.to',
                                'help' => 'https://help.docs',
                                'message' => 'The to parameter is required for all personalization objects.',
                            ],
                        ]
                    ),
                ],
                DomainExceptions\Personalization\ToException::class
            ],
            'content is required' => [
                [
                    $this->getMockErrorResponse(
                        [
                            [
                                'field' => 'content',
                                'help' => 'https://help.docs',
                                'message' => 'The content param is required unless you are using a transactional template and have defined a template_ID.',
                            ],
                        ]
                    ),
                ],
                DomainExceptions\ContentException::class
            ],
            'content value is required' => [
                [
                   $this->getMockErrorResponse(
                        [
                            [
                                'field' => 'content.value',
                                'help' => 'https://help.docs',
                                'message' => 'A content value is required, this is the content of the email you are sending.'
                            ]
                        ]
                   )
                ],
                DomainExceptions\Content\ValueException::class
            ],
            'from value is required' => [
                [
                    $this->getMockErrorResponse(
                        [
                            [
                                'field' => 'from',
                                'help' => 'https://help.docs',
                                'message' => 'The from object must at least have an email parameter with a valid email address and may also contain a name parameter. e.g. {"email": "example@example.com"} or {"email": "example@example.com", "name": "Example Recipient"}'
                            ]
                        ]
                    )
                ],
                DomainExceptions\FromException::class
            ],
            'unplanned exceptions' => [
                [
                    $this->getMockErrorResponse(
                        [
                            [
                                'field' => 'sections',
                                'message' => 'The section values must be strings.',
                                'help' => 'https://help.docs'
                            ]
                        ]
                    )
                ],
                DomainExceptions\UnknownException::class
            ]
        ];
    }

    private function getMockErrorResponse(array $errors)
    {
        return new Response(
            400,
            [
                'Accept' => 'application/json',
            ],
            json_encode(
                [
                    'errors' => $errors
                ]
            )
        );
    }

    private function setupMockHandler(array $queue)
    {
        SendGrid::setClient(
            SendGrid::getApiClient(
                'api-key',
                [
                    'handler' => HandlerStack::create(
                        new MockHandler($queue)
                    ),
                ]
            )
        );
    }
}
