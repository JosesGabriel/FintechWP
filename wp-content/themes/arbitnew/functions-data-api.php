<?php
require_once ('data-api.php');
require_once ('guzzle-class.php');

class DataAPI extends WP_REST_Controller
{
    protected $dataBaseUrl;
    protected $namespace;
    protected $version;
    protected $table_name;
    protected $guzzleClient;
    public $currentUser;
    public $client_secret;


    public function __construct()
    {
        $this->guzzleClient = new GuzzleRequest();
        $this->dataBaseUrl = 'data-api.arbitrage.ph';
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
                 'methods' => WP_REST_Server::CREATABLE,
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
                 'methods' => WP_REST_Server::CREATABLE,
                 'callback' => [$this, 'getForwardedResponse'],
             ],
         ]);
         register_rest_route($base_route, "{$stock_route}/{$market_depth_route}/latest/full-depth", [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
        register_rest_route($base_route, "{$stock_route}/{$market_depth_route}/latest/top-depth", [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
         //endregion market depth

         //region stock info
        register_rest_route($base_route, "{$stock_route}/list", [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
         //endregion stock info

         //region stock history
         $stock_history_route = 'history';

        register_rest_route($base_route, "{$stock_route}/{$stock_history_route}/latest", [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
        register_rest_route($base_route, "{$stock_route}/{$stock_history_route}/latest-active-date", [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'getForwardedResponse'],
            ],
        ]);
         //endregion stock history

         //region trade
        $trade_route = 'trades';

        register_rest_route($base_route, "{$stock_route}/{$trade_route}/latest", [
            [
                'methods' => WP_REST_Server::CREATABLE,
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

    public function forwardRequest(){
        //set the forward url
        $currentUrl = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $forwardUrl = str_replace("{$_SERVER['HTTP_HOST']}/wp-json/{$this->namespace}","{$this->dataBaseUrl}/api",$currentUrl);

        $request = $this->guzzleClient->request("GET", $forwardUrl, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$this->client_secret}",
                ]
            ]);

        return json_decode($request->content);
    }
     
    public function getForwardedResponse($request)
    {
        $isUserLoggedIn =  json_decode($this->currentUser)->is_user_login;

        //TODO: sample code for guzzle request
        //region test
        // $response = $this->guzzleClient->request("GET", "https://data-api.arbitrage.ph/api/v1/stocks/history/latest-active-date", [
        //     "headers" => [
        //         "Content-type" => "application/json",
        //         "Authorization" => "Bearer {$this->client_secret}",
        //         ]
        //     ]);

        // return json_decode($response->getBody());
        //endregion test

        //verify if user is logged in
        if (!$isUserLoggedIn) { 
            return $this->respond(false, [
                'message' => 'Unauthorized access.',
            ], 401);
        }
   
        //region forward request
        $result = $this->forwardRequest();
        //endregion forward request

        return $result;
    }

}

// Register API endpoints
add_action('rest_api_init', function () {
    $dataApi = new DataAPI();
    $dataApi->currentUser = GetCurrentUser();
    $dataApi->client_secret = GetDataApiAuthorization();
    $dataApi->registerRoutes();
});