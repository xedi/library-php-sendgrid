<?php

namespace Xedi\SendGrid\Contracts\Clients;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

interface Client
{
    /**
     * Set Client
     *
     * @param GuzzleClient $client
     *
     * @return static
     */
    public function setClient(GuzzleClient $client): self;

    /**
     * Perform a GET request
     *
     * @param  string $uri
     * @param  array  $params
     * @param  array  $headers
     *
     * @return ResponseInterface
     */
    public function get(string $uri, array $params = [], array $headers = []): ResponseInterface;

    /**
     * Perform a POST request
     *
     * @param  string $uri
     * @param  array  $data
     * @param  array  $headers
     *
     * @return ResponseInterface
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * Perform a PATCH request
     *
     * @param  string $uri
     * @param  array  $data
     * @param  array  $headers
     *
     * @return ResponseInterface
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * Perform a DELETE request
     *
     * @param  string $uri
     * @param  array  $data
     * @param  array  $headers
     *
     * @return ResponseInterface
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface;
}
