<?php

namespace Xedi\SendGrid\Contracts\Client;

use Xedi\SendGrid\Contracts\Response;

interface Client {
    public function get(string $uri, array $params = [], array $headers = []): Response;

    public function post(string $uri, array $data = [], array $headers = []): Response;

    public function patch(string $uri, array $data = [], array $headers = []): Response;

    public function delete(string $uri, array $data = [], array $headers = []): Response;
}
