<?php

class DataAPI extends WP_REST_Controller
{
    protected $dataBaseUrl;
    protected $namespace;
    protected $version;
    protected $table_name;
    protected $client_secret ;

    public function __construct()
    {
        $this->dataBaseUrl = 'https://data-api.arbitrage.ph/api/v1';
        $this->client_secret = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRfbmFtZSI6IjRSQjErUjQ5MyJ9.SZzdF4-L3TwqaGxfb8sR-xeBWWHmGyM4SCuBc1ffWUs';
        $this->version = 'v1';
        $this->namespace = 'data-api';
    }

    public function registerRoutes()
    {
        $base_route = "{$this->namespace}/{$this->version}";

         //region charts
         $chart_route = 'charts';

         register_rest_route($base_route, "{$chart_route}/history", [
             [
                 'methods' => WP_REST_Server::READABLE,
                 'callback' => array($this, 'getOhlcHistory'),
             ],
         ]);
         //endregion charts
    }

    public function sendViaCurl($url){
        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer {$this->client_secret}",
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:34.92.99.210']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result);
    }
        
    public function getOhlcHistory($request)
    {
        $data = $request->get_params();
   
        //region Data validation
        if (!isset($data['symbol'])) {
            return $this->respond(false, [
                'message' => 'The symbol is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['exchange'])) {
            return $this->respond(false, [
                'message' => 'The exchange is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['resolution'])) {
            return $this->respond(false, [
                'message' => 'The resolution is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['from'])) {
            return $this->respond(false, [
                'message' => 'The from date is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['to'])) {
            return $this->respond(false, [
                'message' => 'The to date is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region forward request
        $result = $this->sendViaCurl("{$this->dataBaseUrl}/charts/history?symbol={$data['symbol']}&exchange={$data['exchange']}&resolution={$data['resolution']}&from={$data['from']}&to={$data['to']}");
        //endregion forward request

        return $result;
    }

    public function getTemplate($request)
    {
        global $wpdb;
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['client'])) {
            return $this->respond(false, [
                'message' => 'The client is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['user']) ||
            !is_numeric($data['user'])) {
            return $this->respond(false, [
                'message' => 'The user is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Behavioral change
        if (isset($data['chart'])) {
            $id = $data['chart'];

            $chart = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id));
            return $this->respond(true, [
                'data' => $chart
            ], 200);
        }
        //endregion Behavioral change

        //region Data retrieval
        $charts = $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->table_name WHERE user_id = %d AND client_id = %s", [$data['user'], $data['client']]));
        //endregion Data retrieval

        return $this->respond(true, [
            'data' => $charts
        ], 200);
    }
}

// Register API endpoints
add_action('rest_api_init', function () {
    $dataApi = new DataAPI();
    $dataApi->registerRoutes();
});