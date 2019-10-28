<?php

require_once ('guzzle-class.php');

class ArbitrageAPI extends WP_REST_Controller
{
    protected $method;
    protected $options = [];
    protected $url;

    /**
     * Sets form data
     *
     * @param array $data
     * @return GuzzleRequest
     */
    public function setFormData(array $data = [])
    {
        $this->options['form_params'] = $data;
        return $this;
    }

    /**
     * Sets headers, merging the added headers with data passed here
     *
     * @param array $headers
     * @return GuzzleRequest
     */
    public function setHeaders(array $headers = [])
    {
        $this->options['headers'] = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * @param string $method
     * @return GuzzleRequest
     */
    protected function setMethod($method = 'GET')
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Sets the multipart form data
     *
     * @param array $data
     * @return GuzzleRequest
     */

    public function setMultipart(array $data = [])
    {
        $this->options['multipart'] = $data;
        return $this;
    }

    /**
     * @param array $options
     * @return GuzzleRequest
     */
    public function setOptions(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * @param string $uri
     * @return GuzzleRequest
     */
    public function setUri(string $uri = '')
    {
        $this->url = "https://dev-api.arbitrage.ph/$uri";
        return $this;
    }

    protected function request()
    {
        $client = new GuzzleRequest();
        try {
            $response = $client->request($this->method, $this->url, $this->options);
        } catch (RequestException $e) {
            // networking error
            $response = $e->getRequest();
            $this->status_code = 408;

            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $this->content = $response->content;
            }
            return $this;
        } catch (ClientException $e) {
            // 400 level errors
            $response = $e->getResponse();
        } catch (ServerException $e) {
            // 500 level errors
            $response = $e->getResponse();
        }

        return json_decode($response->content);
    }

    protected function respond($success = false, $data = [], $status = 500)
    {
        $data['status'] = $status;
        $status = $success ? 200 : $status;
        return new WP_REST_Response($data, $status);
    }
}