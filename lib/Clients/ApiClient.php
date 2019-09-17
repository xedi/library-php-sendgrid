<?php

namespace Xedi\SendGrid\Clients;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Xedi\SendGrid\Clients\HandlesExceptions;
use Xedi\SendGrid\Clients\HttpResponse;
use Xedi\SendGrid\Contracts\Client as ClientContract;
use Xedi\SendGrid\Contracts\Response as ResponseInterface;
use Xedi\SendGrid\Contracts\Response;
use Xedi\SendGrid\Exceptions\SendGridUnreacheable as SendGridUnreacheableException;

/**
 * Class ApiClient
 * @package Xedi\SendGrid\Clients
 */
class ApiClient implements ClientContract\Client
{
    use HandlesExceptions;

    /**
     * @var GuzzleClient $client
     */
    private $client;

    /**
     * ApiClient constructor.
     *
     * @param string $api_key
     * @param array  $options
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
     * @param string $uri
     * @param array  $params
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function get(string $uri, array $params = [], array $headers = []): ResponseInterface
    {
        return $this->makeRequest('GET', $uri, $params, $headers);
    }

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->makeRequest('POST', $uri, $params, $headers);
    }

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->makeRequest('PATCH', $uri, $data, $headers);
    }

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->makeRequest('DELETE', $uri, $data, $headers);
    }

    /**
     * Make the Request to SendGrid
     *
     * @param  string $method  HTTP Verb
     * @param  string $uri     URI of the resource to interact with
     * @param  array  $data    Data to send
     * @param  array  $headers HTTP Headers
     *
     * @todo Document Exception Types
     *
     * @return ResponseInterface
     */
    protected function makeRequest(
        string $method,
        string $uri,
        array $data = [],
        array $headers = []
    ): ResponseInterface {
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
