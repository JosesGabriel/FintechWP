<?php

require_once ABSPATH . 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

/**
 * Class GuzzleRequest
 *
 * @package Arbitrage\Http\Request
 */
class GuzzleRequest
{
    protected
        $client;

    public
        $content,
        $response,
        $status_code;

    /**
     * GuzzleRequest constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Send synchronous promise-based Guzzle request
     * @return GuzzleRequest
     */
    public function request($method, $url, $headers=[])
    {
        try {
            $promise = $this->client->requestAsync($method, $url, $headers);
            $response = $promise->wait();
        } catch (RequestException $e) {
            // networking error
            $response = $e->getRequest();
            $this->status_code = 408;

            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $this->content = $response->getBody()->getContents();
            }
            return $this;
        } catch (ClientException $e) {
            // 400 level errors
            $response = $e->getResponse();
        } catch (ServerException $e) {
            // 500 level errors
            $response = $e->getResponse();
        }

        $this->response = $response;
        $this->content = $response->getBody()->getContents();
        $this->status_code = $response->getStatusCode();

        return $this;
    }
    //endregion Helpers
}
