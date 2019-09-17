<?php

namespace Xedi\SendGrid;

use Xedi\SendGrid\Clients\ApiClient;
use Xedi\SendGrid\Clients\MockClient;
use Xedi\SendGrid\Contracts\Client as ClientContract;
use Xedi\SendGrid\Contracts\Mailable;
use Xedi\SendGrid\Mail\Mail;

class SendGrid
{
    /**
     * The API Client responsible for communicating with SendGrid
     *
     * @static
     *
     * @var Xedi\SendGrid\Contracts\Client;
     */
    protected static $client = $client;

    public static function setClient(ClientContract $client)
    {
        static::$client = $client;
    }

    public static function getClient(string $api_key, array $options = [])
    {
        return new ApiClient($api_key, $options);
    }

    public static function getMockClient()
    {
        return new MockClient();
    }

    public function prepareMail()
    {
        return new Mail();
    }

    public function send(Mailable $mail_item)
    {

    }
}
