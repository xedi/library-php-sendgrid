<?php

namespace Xedi\SendGrid\Clients;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Throwable;
use Xedi\SendGrid\Clients\Concerns\HandlesExceptions;
use Xedi\SendGrid\Clients\HttpResponse;
use Xedi\SendGrid\Contracts\Clients\Client as ClientContract;
use Xedi\SendGrid\Contracts\Clients\Response as ResponseContract;
use Xedi\SendGrid\Exceptions\BadDeveloperException;
use Xedi\SendGrid\Exceptions\SendGridUnreacheableException;

/**
 * Class ApiClient
 *
 * @package Xedi\SendGrid\Clients
 * @author  Chris Smith <chris@xedi.com>
 */
class ApiClient implements ClientContract
{
    use HandlesExceptions;

    /**
     * Instance of GuzzleHttp\Client
     *
     * @var GuzzleClient $client
     */
    public $client;

    /**
     * ApiClient constructor.
     *
     * @param string $api_key SendGrid API Key
     * @param array  $options Additional options to pass to GuzzleClient
     */
    public function __construct(string $api_key, array $options = [])
    {
        $this->client = new GuzzleClient(
            array_merge(
                [
                    'base_uri' => 'https://api.sendgrid.com',
                    'headers' => [
                        'Authorization' => "Bearer $api_key",
                        'Content-Type' => 'application/json'
                    ]
                ],
                $options
            )
        );
    }

    /**
     * Perform a GET request
     *
     * @param string $uri     Relative URI
     * @param array  $params  Parameters to form the QueryString
     * @param array  $headers Custom headers
     *
     * @codeCoverageIgnore
     *
     * @return ResponseContract
     */
    public function get(string $uri, array $params = [], array $headers = []): ResponseContract
    {
        return $this->makeRequest('GET', $uri, $params, $headers);
    }

    /**
     * Perform a POST request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to add to the requests body
     * @param array  $headers Custom headers
     *
     * @codeCoverageIgnore
     *
     * @return ResponseContract
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseContract
    {
        return $this->makeRequest('POST', $uri, $data, $headers);
    }

    /**
     * Perform a PATCH request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to add to the requests body
     * @param array  $headers Custom headers
     *
     * @codeCoverageIgnore
     *
     * @return ResponseContract
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseContract
    {
        return $this->makeRequest('PATCH', $uri, $data, $headers);
    }

    /**
     * Perform a DELETE request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to add to the requests body
     * @param array  $headers Custom headers
     *
     * @codeCoverageIgnore
     *
     * @return ResponseContract
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseContract
    {
        return $this->makeRequest('DELETE', $uri, $data, $headers);
    }

    /**
     * Make the Request to SendGrid
     *
     * @param string $method  HTTP Verb
     * @param string $uri     URI of the resource to interact with
     * @param array  $data    Data to send
     * @param array  $headers HTTP Headers
     *
     * @throws Xedi\Exceptions\SendGridUnreachableException
     * @throws Xedi\Exceptions\BadDeveloperException
     *
     * @return ResponseContract
     */
    protected function makeRequest(
        string $method,
        string $uri,
        array $data = [],
        array $headers = []
    ): ResponseContract {
        try {
            $response = $this->client->request(
                $method,
                $uri,
                [
                    'headers' => $headers,
                    'json' => $data
                ]
            );

            return new HttpResponse(
                (string)$response->getBody(),
                $response->getStatusCode(),
                $response->getHeaders()
            );
        } catch (ConnectException $exception) {
            throw SendGridUnreacheableException::fromConnectionException(
                $exception
            );
        } catch (ServerException $exception) {
            throw SendGridUnreacheableException::fromServerException(
                $exception
            );
        } catch (GuzzleException $exception) {
            throw $this->handleException($exception);
        } catch (Throwable $exception) {
            throw BadDeveloperException::uncaughtException($exception);
        }
    }
}
