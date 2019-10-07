<?php
require_once ('guzzle-class.php');
require_once ('data-api.php');


class WatchlistAPI extends WP_REST_Controller
{
    protected $namespace;
    protected $table_name;
    protected $version;

    public function __construct()
    {
        $this->namespace = 'watchlist-api';
        $this->table_name = 'arby_charting';
        $this->version = 'v1';
    }

    public function registerRoutes()
    {
        $base_route = "$this->namespace/$this->version";

        register_rest_route($base_route, 'user', [
            [
                'method' => 'GET',
                'callback' => [$this, 'fetchUserWatchlist'],
            ],
        ]);

        register_rest_route($base_route, 'watchlists', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getwatchlist'],
            ],
        ]);

        register_rest_route($base_route, 'stockcharts', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getstockcharts'],
            ],
        ]);
    }

    public function respond($success = false, $data = [], $status = 500)
    {
        $data['status'] = $success ? 'ok' : 'error';
        $data['success'] = $success;
        $status = $success ? 200 : $status;
        return new WP_REST_Response($data, $status);
    }

    public function fetchUserWatchlist($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $user_id = $data['user_id'];

        $watchlist = get_user_meta($user_id, '_watchlist_instrumental', true);

        if (!$watchlist) {
            return $this->respond(false, [
                'data' => [
                    'watchlist' => [],
                ],
                'message' => 'No watchlist found.',
            ]);
        }
        
        return $this->respond(true, [
            'data' => [
                'watchlist' => array_values($watchlist) ?? [],
            ],
            'message' => 'Successfully fetched watchlist.'
        ]);
    }

    public function getwatchlist($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $stocksdata = json_decode($request->content); 

        $metadata = "";
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key = "_watchlist_instrumental" and user_id ='.$data['userid']);
        foreach ($ismytrades as $sdkey => $dsvalue) { $metadata = unserialize($dsvalue->meta_value); }
        $finalwatch = [];
        foreach ($metadata as $key => $value) {
            $key = array_search($value['stockname'], array_column($stocksdata->data, 'symbol'));
            $stockdetails = $stocksdata->data[$key];
            $value['last'] = $stockdetails->last;
            $value['change'] = $stockdetails->changepercentage;
            array_push($finalwatch, $value);
        }
        return $this->respond(true, ['data' => $finalwatch], 200);
        
    }

    public function getstockcharts($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $metadata = "";
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key = "_watchlist_instrumental" and user_id ='.$data['userid']);
        foreach ($ismytrades as $sdkey => $dsvalue) { $metadata = unserialize($dsvalue->meta_value); }
        $finalwatch = [];
        foreach ($metadata as $key => $value) {
            $stock = $value['stockname'];

            $intovals = [];
            $intovals['stock'] = $stock;
            $guzzle = new GuzzleRequest();
            $dataUrl = GetDataApiUrl();
            $authorization = GetDataApiAuthorization();
            $request = $guzzle->request("GET", "{$dataUrl}/api/v1/charts/history?symbol=".$stock.'&exchange=PSE&resolution=1D&from='. date('Y-m-d', strtotime("-20 days")) .'&to=' . date('Y-m-d'), [
                "headers" => [
                    "Content-type" => "application/json",
                    "Authorization" => "Bearer {$authorization}",
                    ]
            ]);
            
            $stocksdata = json_decode($request->content); 
            $intovals['chartdata'] = $stocksdata->data;
            array_push($finalwatch, $intovals);
        }


        return $this->respond(true, ['data' => $finalwatch], 200);
    }
}

add_action('rest_api_init', function () {
    $watchlistApi = new WatchlistAPI();
    $watchlistApi->registerRoutes();
});