<?php

namespace Xedi\SendGrid\Clients;

use GuzzleHttp\Client as GuzzleClient;
use Xedi\SendGrid\Clients\HttpResponse;
use Xedi\SendGrid\Contracts\Client as ClientContract;
use Xedi\SendGrid\Contracts\Response;

class ApiClient implements ClientContract
{
    private $client;

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
        ]);
    }

    public function get(string $uri, array $params = [], array $headers = []): Response
    {

    }

    public function post(string $uri, array $data = [], array $headers = []): Response
    {

    }

    public function patch(string $uri, array $data = [], array $headers = []): Response
    {

    }

    public function delete(string $uri, array $data = [], array $headers = []): Response
    {

    }
}
