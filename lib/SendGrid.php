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
     *
     * @return void
     */
    public static function setClient(ClientContract $client)
    {
        static::$client = $client;
    }

    /**
     * Get an instance of the API Client
     *
     * @param string $api_key SendGrid API Key
     * @param array  $options Additional Options to pass to GuzzleHttp\Client
     *
     * @return ApiClient
     */
    public static function getClient(string $api_key, array $options = [])
    {
        return new ApiClient($api_key, $options);
    }

    /**
     * Get an instance of the Mock Client
     *
     * @return MockClient
     */
    public static function getMockClient()
    {
        return new MockClient();
    }

    /**
     * Get an instance of the Mail class
     *
     * @return Mail
     */
    public static function prepareMail()
    {
        return new Mail();
    }

    /**
     * Send a Mailable item to SendGrid
     *
     * @param Mailable $mail_item A Mail class instance implementing the Mailable contract
     *
     * @return HttpResponse
     */
    public static function send(Mailable $mail_item)
    {
        return $mail_item->send($this->client);
    }
}
