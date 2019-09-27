<?php

namespace Xedi\SendGrid\Contracts\Clients;

use GuzzleHttp\Client as GuzzleClient;
use Xedi\SendGrid\Contracts\Clients\Response;

/**
 * Client Contract
 *
 * @package Xedi\SendGrid\Contracts\Clients
 * @author  Chris Smith <chris@xedi.com>
 */
interface Client
{
    /**
     * Perform a GET request
     *
     * @param string $uri     Relative URI
     * @param array  $params  Parameters to be added as QueryString
     * @param array  $headers Custom Headers
     *
     * @return Response
     */
    public function get(string $uri, array $params = [], array $headers = []): Response;

    /**
     * Perform a POST request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return Response
     */
    public function post(string $uri, array $data = [], array $headers = []): Response;

    /**
     * Perform a PATCH request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return Response
     */
    public function patch(string $uri, array $data = [], array $headers = []): Response;

    /**
     * Perform a DELETE request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to be added to the requests body
     * @param array  $headers Custom Headers
     *
     * @return Response
     */
    public function delete(string $uri, array $data = [], array $headers = []): Response;
}
