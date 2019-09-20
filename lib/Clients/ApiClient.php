<?php

namespace Xedi\SendGrid\Clients;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Xedi\SendGrid\Clients\HandlesExceptions;
use Xedi\SendGrid\Clients\HttpResponse;
use Xedi\SendGrid\Contracts\Clients\Client as ClientContract;
use Xedi\SendGrid\Contracts\Clients\Response as ResponseContract;
use Xedi\SendGrid\Exceptions\SendGridUnreacheable as SendGridUnreacheableException;

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
    private $client;

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
                    'base_uri' => 'https://api.sendgrid.com/v3',
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
     * Set Client
     *
     * @param GuzzleClient $client A GuzzleClient instance
     *
     * @return static
     */
    public function setClient(GuzzleClient $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Perform a GET request
     *
     * @param string $uri     Relative URI
     * @param array  $params  Parameters to form the QueryString
     * @param array  $headers Custom headers
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
     * @return ResponseContract
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseContract
    {
        return $this->makeRequest('POST', $uri, $params, $headers);
    }

    /**
     * Perform a PATCH request
     *
     * @param string $uri     Relative URI
     * @param array  $data    Data to add to the requests body
     * @param array  $headers Custom headers
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
     *                        TODO: Document Exception Types
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
                array_merge(
                    [
                        'headers' => $headers
                    ],
                    $params
                )
            );

            return new HttpResponse((string) $response->getBody());
        } catch (ConnectException $exception) {
            throw SendGridUnreacheableException::fromConnectionException(
                $exception
            );
        } catch (GuzzleException $exception) {
            throw $this->handleException($exception);
        } catch (Throwable $exception) {
            // TODO: Developer Exception
        }
    }
}
