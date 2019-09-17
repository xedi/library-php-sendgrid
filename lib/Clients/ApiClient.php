<?php

namespace Xedi\SendGrid\Clients;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Xedi\SendGrid\Clients\HttpResponse;
use Xedi\SendGrid\Contracts\Client as ClientContract;
use Xedi\SendGrid\Contracts\Response;

/**
 * Class ApiClient
 * @package Xedi\SendGrid\Clients
 */
class ApiClient implements ClientContract\Client
{
    /**
     * @var GuzzleClient $client
     */
    private $client;

    /**
     * ApiClient constructor.
     *
     * @param string $api_key
     * @param array  $options
     */
    public function __construct(string $api_key, array $options = [])
    {
        $this->client = new GuzzleClient(
            array_merge(
                [
                    'base_uri' => 'https://api.sendgrid.com/v3',
                    'headers' => [
                        'Authorization' => "Bearer $api_key"
                    ]
                ],
                $options
            )
        );
    }

    /**
     * @param string $uri
     * @param array  $params
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function get(string $uri, array $params = [], array $headers = []): ResponseInterface
    {

        return $this->client->get($uri, $params);
    }

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface
    {

        return $this->client->post($uri, $data);
    }

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface
    {

        return $this->client->patch($uri, $data);
    }

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface
    {

        return $this->client->delete($uri, $data);
    }
}
