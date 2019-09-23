<?php

namespace Xedi\SendGrid\Contracts\Clients;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Client Contract
 *
 * @internal
 * @package  Xedi\SendGrid\Contracts\Clients
 * @author   Chris Smith <chris@xedi.com>
 */
interface Client
{
    /**
     * Set Client
     *
     * @param GuzzleClient $client HTTP Client
     *
     * @return static
     */
    public function setClient(GuzzleClient $client): self;

    /**
     * Perform a GET request
     *
     * @param string $uri     Relative URI
     * @param array  $params  Parameters to be added as QueryString
     * @param array  $headers Custom Headers
     *
     * @return ResponseInterface
     */
    public function get(string $uri, array $params = [], array $headers = []): ResponseInterface;

    /**
     * Perform a POST request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return ResponseInterface
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * Perform a PATCH request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return ResponseInterface
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * Perform a DELETE request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return ResponseInterface
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface;
}
