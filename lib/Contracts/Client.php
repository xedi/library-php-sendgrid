<?php

namespace Xedi\SendGrid\Contracts\Client;

use Psr\Http\Message\ResponseInterface;

interface Client
{

    public function get(string $uri, array $params = [], array $headers = []): ResponseInterface;

    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface;

    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface;

    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface;
}
