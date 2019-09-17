<?php

namespace Xedi\SendGrid;

use Xedi\SendGrid\Clients\ApiClient;
use Xedi\SendGrid\Clients\MockClient;
use Xedi\SendGrid\Contracts\Client as ClientContract;
use Xedi\SendGrid\Contracts\Mailable;
use Xedi\SendGrid\Mail\Mail;

/**
 * Class SendGrid
 * @package Xedi\SendGrid
 */
class SendGrid
{

    /**
     * The API Client responsible for communicating with SendGrid
     *
     * @static
     *
     * @var ClientContract\Client
     */
    protected static $client;

    /**
     * @param ClientContract\Client $client
     */
    public static function setClient(ClientContract\Client $client)
    {
        static::$client = $client;
    }

    /**
     * @param string $api_key
     * @param array  $options
     *
     * @return ApiClient
     */
    public static function getClient(string $api_key, array $options = [])
    {
        return new ApiClient($api_key, $options);
    }

    /**
     * @return MockClient
     */
    public static function getMockClient()
    {
        return new MockClient();
    }

    /**
     * @return Mail
     */
    public function prepareMail()
    {
        return new Mail();
    }

    /**
     * @param Mailable $mail_item
     */
    public function send(Mailable $mail_item)
    {
        ///mail/send
    }
}
