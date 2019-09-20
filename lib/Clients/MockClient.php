<?php

namespace Xedi\SendGrid\Clients;

use Xedi\SendGrid\Clients\MockResponse;
use Xedi\SendGrid\Contracts\Clients\Client as ClientContract;
use Xedi\SendGrid\Contracts\Clients\Response as ResponseContract;

/**
 * Class MockClient
 *
 * @package Xedi\SendGrid\Clients
 * @author  Chris Smith <chris@xedi.com>
 */
class MockClient implements ClientContract
{
    /**
     * Perform a GET request
     *
     * @param string $uri     Relative URI
     * @param array  $params  Parameters to be added as QueryString
     * @param array  $headers Custom Headers
     *
     * @return ResponseContract
     */
    public function get(string $uri, array $params = [], array $headers = []): ResponseContract
    {
    }

    /**
     * Perform a POST request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return ResponseContract
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseContract
    {
    }

    /**
     * Perform a PATCH request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return ResponseContract
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseContract
    {
    }
    /**
     * Perform a DELETE request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return ResponseContract
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseContract
    {
    }
}
