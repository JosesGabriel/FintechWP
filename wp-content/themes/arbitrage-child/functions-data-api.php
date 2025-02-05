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
        $this->dataBaseUrl = 'data-api.arbitrage.ph';
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
                 'callback' => [$this, 'getForwardedResponse'],
             ],
         ]);
         //endregion charts

         //region stocks
         $stock_route = 'stocks';
         //region market depth
         $market_depth_route = 'market-depth';

        register_rest_route($base_route, "{$stock_route}/{$market_depth_route}/latest/bidask", [
             [
                 'methods' => WP_REST_Server::READABLE,
                 'callback' => [$this, 'getForwardedResponse'],
             ],
         ]);
         register_rest_route($base_route, "{$stock_route}/{$market_depth_route}/latest/full-depth", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
        register_rest_route($base_route, "{$stock_route}/{$market_depth_route}/latest/top-depth", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
         //endregion market depth

         //region stock info
        register_rest_route($base_route, "{$stock_route}/list", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
         //endregion stock info

         //region stock history
         $stock_history_route = 'history';

        register_rest_route($base_route, "{$stock_route}/{$stock_history_route}/latest", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
        register_rest_route($base_route, "{$stock_route}/{$stock_history_route}/latest-active-date", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
         //endregion stock history

         //region trade
        $trade_route = 'trades';

        register_rest_route($base_route, "{$stock_route}/{$trade_route}/latest", [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
         //endregion trade
         //endregion stocks
    }

    public function respond($success = false, $data = [], $status = 500)
    {
        $data['status'] = $success ? 'ok' : 'error';
        $status = $success ? 200 : $status;
        return new WP_REST_Response($data, $status);
    }

    public function sendViaCurl(){
        //set the headers
        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer {$this->client_secret}",
        ];
        
        //set the forward url
        $currentUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $forwardUrl = str_replace("{$_SERVER[HTTP_HOST]}/wp-json/{$this->namespace}","{$this->dataBaseUrl}/api",$currentUrl);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $forwardUrl);
        curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:34.92.99.210']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result);
    }
        
    public function getForwardedResponse($request)
    {
        //verify if user is logged in
        //TODO: enable logged in verification
        // if (!is_user_logged_in()) { 
        //     return $this->respond(false, [
        //         'message' => 'Unauthorized access.',
        //         'parameters' => $data,
        //     ], 401);
        // }

        $data = $request->get_params();
   
        //region forward request
        $result = $this->sendViaCurl();
        //endregion forward request

        return $result;
    }

}

// Register API endpoints
add_action('rest_api_init', function () {
    $dataApi = new DataAPI();
    $dataApi->registerRoutes();
});