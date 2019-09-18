<?php

namespace Xedi\SendGrid;

use Xedi\SendGrid\Clients\ApiClient;
use Xedi\SendGrid\Clients\MockClient;
use Xedi\SendGrid\Contracts\Clients\Client as ClientContract;
use Xedi\SendGrid\Contracts\Mailable;
use Xedi\SendGrid\Mail\Mail;

/**
 * Class SendGrid
 *
 * @package Xedi\SendGrid
 * @author  Chris Smith  <chris@xedi.com>
 * @link    https://github.io/xedi/sendgrid SendGrid documentation
 */
class SendGrid
{
    /**
     * The API Client responsible for communicating with SendGrid
     *
     * @var ClientContract
     */
    protected static $client;

    /**
     * Set the Transport Client for the library
     *
     * @param ClientContract $client A Client
     */
    public static function setClient(ClientContract $client)
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
        return $mail_item->send($this->client);
    }
}
