<?php

namespace Xedi\SendGrid\Clients;

use Xedi\SendGrid\Clients\MockResponse;
use Xedi\SendGrid\Contracts\Clients\Client as ClientContract;
use Xedi\SendGrid\Contracts\Clients\Response;

/**
 * Class MockClient
 * @package Xedi\SendGrid\Clients
 */
class MockClient implements ClientContract
{
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
