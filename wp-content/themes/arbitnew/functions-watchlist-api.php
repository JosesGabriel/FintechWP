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

        register_rest_route($base_route, 'gettrending', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getgettrending'],
            ],
        ]);

        register_rest_route($base_route, 'hasfb', [
            [
                'method' => 'GET',
                'callback' => [$this, 'gethasfb'],
            ],
        ]);
        
        register_rest_route($base_route, 'fbuser', [
            [
                'method' => 'POST',
                'callback' => [$this, 'addfbuser'],
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

    public function gethasfb($request)
    {
        global $wpdb;
        $data = $request->get_params();
        
        $stockss;
        $whattodo = false;
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where user_id ='.$data['userid']);
        $username = array_search('um_user_profile_url_slug_user_login', array_column($ismytrades, 'meta_key'));
        $username = $ismytrades[$username]->meta_value;
        $ssjet = array_search('_uid_facebook', array_column($ismytrades, 'meta_key'));
        if($ssjet){
            $guzzle = new GuzzleRequest();
            $request = $guzzle->request("GET", "https://im.arbitrage.ph/_matrix/client/r0/profile/@".$username.":im.arbitrage.ph", [
                "headers" => [
                    "Content-type" => "application/json",
                    ]
            ]);
            $stockss = json_decode($request->content);
            if(isset($stockss->errcode)){
                $whattodo = true;
            }
        }
        $ifhasbo = ($whattodo ? "gopop" : "nopop");
        return $this->respond(true, ['data' => $ifhasbo, 'username' => $username], 200);
    }

    public function addfbuser($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $info = json_encode([
            'username' => $data['username'],
            'password' => $data['password'],
            'bind_email' => false,
            'auth' => ['type' => 'm.login.dummy'],
        ]);
    
        $guzzle = new GuzzleRequest();
        $request = $guzzle->request("POST", "https://im.arbitrage.ph/_matrix/client/r0/register?kind=user", [
            "headers" => [
                "Content-type" => "application/json"
            ],
            "body" => $info
        ]);

        return $this->respond(true, ['data' => $info], 200);
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

        // $gerdqouteone = file_get_contents('https://arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
        // $stocksdata = json_decode($gerdqouteone);

        $metadata = "";
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key = "_watchlist_instrumental" and user_id ='.$data['userid']);
        foreach ($ismytrades as $sdkey => $dsvalue) { $metadata = unserialize($dsvalue->meta_value); }
        $finalwatch = [];
        foreach ($metadata as $key => $value) {
            $getbidask = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/market-depth/latest/full-depth?exchange=PSE&symbol=".$value['stockname'], [
                "headers" => [
                    "Content-type" => "application/json",
                    "Authorization" => "Bearer {$authorization}",
                    ]
            ]);
            $dbidasklist = json_decode($getbidask->content);

            $key = array_search($value['stockname'], array_column($stocksdata->data, 'symbol'));
            $stockdetails = $stocksdata->data[$key];
            $value['last'] = $stockdetails->last;
            $value['change'] = $stockdetails->changepercentage;
            $value['bidask'] = $dbidasklist->data;
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

    public function getgettrending($request)
    {
        global $wpdb;
        $data = $request->get_params();


        $count = 0;
        $counter = 0;
        $stock_watched[0][0] = '';
        //$stock_watched[0][1] = 1;

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

        $watchlist = $wpdb->get_results('select meta_value from arby_usermeta where meta_key = "_watchlist_instrumental" ');
        foreach ($watchlist as $mkey => $mvalue) { 
            $metadata = unserialize($mvalue->meta_value); 
            $count_watchlist = 1; 
            foreach ($metadata as $key => $value) {      
                $x = 0;
                if($counter == 0) {          
                        $stock_watched[$count][0] = $value['stockname'];
                        $count++;                  
                }else{
                    for ($i=0; $i < $count ; $i++) { 
                            if($stock_watched[$i][0] == $value['stockname'] && $value['stockname'] != ''){ 
                                if($stock_watched[$i][1] != '' ? $stock_watched[$i][1]++ : $stock_watched[$i][1] =  $count_watchlist );
                                $x = 1; 
                            }
                    }
                    if($x == 0){
                        $stock_watched[$count][0] = $value['stockname'];
                        $count++;
                    }
                }
            }
            $counter++;
        }
        
        usort($stock_watched, function($a, $b) { return $b[1] <=> $a[1]; });
        $newlist = [];
        $topten = array_slice($stock_watched, 0, 10);
        foreach ($topten as $key => $value) {
            $key = array_search($value[0], array_column($stocksdata->data, 'symbol'));
            $stockdetails = $stocksdata->data[$key];
            $value[2] = $stockdetails->description;
            array_push($newlist, $value);
        }

        return $this->respond(true, ['data' => $newlist], 200);
    }
}

add_action('rest_api_init', function () {
    $watchlistApi = new WatchlistAPI();
    $watchlistApi->registerRoutes();
});