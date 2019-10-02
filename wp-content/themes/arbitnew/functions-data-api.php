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

         //region stocks
         $stock_route = 'stocks';
         //region market depth
         $market_depth_route = 'market-depth';

         register_rest_route($base_route, "{$stock_route}/${$market_depth_route}/latest/bidask", [
             [
                 'methods' => WP_REST_Server::READABLE,
                 'callback' => array($this, 'getLatestMarketDepth'),
             ],
         ]);
         register_rest_route($base_route, "{$stock_route}/${$market_depth_route}/latest/full-depth", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getLatestFullDepth'),
            ],
        ]);
        register_rest_route($base_route, "{$stock_route}/${$market_depth_route}/latest/top-depth", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getLatestTopDepth'),
            ],
        ]);
         //endregion market depth

         //region stock info
         register_rest_route($base_route, "{$stock_route}/list", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getStocksList'),
            ],
        ]);
         //endregion stock info

         //region stock history
         $stock_history_route = 'history';

        register_rest_route($base_route, "{$stock_route}/${$stock_history_route}/latest", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getLatestStockHistory'),
            ],
        ]);
        register_rest_route($base_route, "{$stock_route}/${$stock_history_route}/latest-active-date", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getLatestActiveDate'),
            ],
        ]);
         //endregion stock history

         //region trade
        $trade_route = 'trades';

        register_rest_route($base_route, "{$stock_route}/${$trade_route}/latest", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getLatestTrades'),
            ],
        ]);
         //endregion trade
         //endregion stocks
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
   
        //region forward request
        $result = $this->sendViaCurl("{$this->dataBaseUrl}/charts/history?symbol={$data['symbol']}&exchange={$data['exchange']}&resolution={$data['resolution']}&from={$data['from']}&to={$data['to']}");
        //endregion forward request

        return json_decode($request);
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