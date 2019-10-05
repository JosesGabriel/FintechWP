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
        $metadata = "";
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key = "_watchlist_instrumental" and user_id ='.$data['userid']);
        foreach ($ismytrades as $key => $value) {
            $metadata = unserialize($value->meta_value);
        }
        
        
        return $this->respond(true, ['data' => $metadata], 200);
        
    }
}

add_action('rest_api_init', function () {
    $watchlistApi = new WatchlistAPI();
    $watchlistApi->registerRoutes();
});