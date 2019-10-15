<?php
require_once ('guzzle-class.php');
require_once ('data-api.php');


class VirtualAPI extends WP_REST_Controller
{
    protected $namespace;
    protected $table_name;
    protected $version;

    public function __construct()
    {
        $this->namespace = 'virtual-api';
        $this->table_name = 'arby_charting';
        $this->version = 'v1';
    }

    public function registerRoutes()
    {
        $base_route = "$this->namespace/$this->version";

        register_rest_route($base_route, 'initvirtual', [
            [
                'method' => 'GET',
                'callback' => [$this, 'initvirtual'],
            ],
        ]);

        register_rest_route($base_route, 'livetrade', [
            [
                'method' => 'POST',
                'callback' => [$this, 'pushLiveTrade'],
            ],
        ]);

        register_rest_route($base_route, 'virtualdata', [
            [
                'method' => 'POST',
                'callback' => [$this, 'getVirtualData'],
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

    // recursive functions
    public function getjurfees($funmarketval, $funtype){
        // Commissions
        $dpartcommission = $funmarketval * 0.0025;
        $dcommission = ($dpartcommission > 20 ? $dpartcommission : 20);
        // TAX
        $dtax = $dcommission * 0.12;
        // Transfer Fee
        $dtransferfee = $funmarketval * 0.00005;
        // SCCP
        $dsccp = $funmarketval * 0.0001;
        $dsell = $funmarketval * 0.006;

        if ($funtype == 'buy') {
            $dall = $dcommission + $dtax + $dtransferfee + $dsccp;
        } else {
            $dall = $dcommission + $dtax + $dtransferfee + $dsccp + $dsell;
        }
        return $dall;
    }

    // initialize
    public function initvirtual()
    {
        global $wpdb;

        $wpdb->query("create table if not exists arby_vt_live (
            id int(10) unsigned auto_increment primary key,
            stockname varchar(250) not null,
            buyprice varchar(250) not null,
            volume varchar(250) not null,
            emotion varchar(250),
            strategy varchar(250),
            tradeplan varchar(250),
            tradenotes varchar(250),
            buydate varchar(250),
            vtcategory varchar(250),
            vttype varchar(250),
            userid int(10)
        )");

        $wpdb->query("create table if not exists arby_vt_tradelog (
            id int(10) unsigned auto_increment primary key,
            tradeid varchar(250) not null,
            volume varchar(250),
            selldate varchar(250),
            vtcategory varchar(250),
            vttype varchar(250),
            userid int(10)
        )");

        return $this->respond(true, ['data' => "success?"], 200);
    }

    // pusher
    public function pushLiveTrade($details)
    {
        global $wpdb;
        $data = $details->get_params();
        // save information
        $sql = "insert into arby_vt_live (stockname, buyprice, volume, emotion, strategy, tradeplan, tradenotes, buydate, vtcategory, vttype, userid) values ('".$data['stockname']."', '".$data['buyprice']."', '".$data['volume']."', '".$data['emotion']."', '".$data['strategy']."', '".$data['tradeplan']."', '".$data['tradenotes']."', '".$data['buydate']."', '".$data['category']."', '".$data['type']."', '".$data['userid']."')";
        $insertlive = $wpdb->query($sql);
        if($insertlive){
            // return data
            $marketvalue = $data['volume'] * $data['buyprice'];
            $totalcost = $marketvalue - $this->getjurfees($marketvalue, 'sell');
            $data['marketvals'] = $marketvalue;
            $profit = $totalcost - $marketvalue;

            $profitperc = ($profit / $marketvalue) * 100;
            $data['profit'] = $profit;
            $data['profitperc'] = $profitperc;

            return $this->respond(true, ['data' => $data], 200);
        } else {
            return $this->respond(true, ['error' => 'inserting not successful'], 400);
        }
        
    }

    public function getVirtualData($request)
    {
        $data = $request->get_params();
        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();

        $request = $guzzle->request("POST", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE&symbol=".$data['stockname'], [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $stocksdata = json_decode($request->content);
        $intovals['virtualdata'] = $stocksdata->data;
        array_push($finalwatch, $intovals);

        return $this->respond(true, ['data' => $finalwatch], 200);

    }

}

add_action('rest_api_init', function () {
    $virtualapi = new VirtualAPI();
    $virtualapi->registerRoutes();
});