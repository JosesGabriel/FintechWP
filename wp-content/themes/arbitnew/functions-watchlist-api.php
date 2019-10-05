<?php

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

        $gerdqouteone = file_get_contents('https://arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
        $stocksdata = json_decode($gerdqouteone);

        $metadata = "";
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key = "_watchlist_instrumental" and user_id ='.$data['userid']);
        foreach ($ismytrades as $sdkey => $dsvalue) { $metadata = unserialize($dsvalue->meta_value); }
        $finalwatch = [];
        foreach ($metadata as $key => $value) {
            $key = array_search($value['stockname'], array_column($stocksdata->data, 'symbol'));
            $stockdetails = $stocksdata->data[$key];
            $value['last'] = $stockdetails->last;
            $value['changepercentage'] = $stockdetails->change;
            array_push($finalwatch, $value);
        }
        return $this->respond(true, ['data' => $finalwatch], 200);
        
    }
}

add_action('rest_api_init', function () {
    $watchlistApi = new WatchlistAPI();
    $watchlistApi->registerRoutes();
});