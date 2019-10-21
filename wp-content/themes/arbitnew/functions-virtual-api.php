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

        register_rest_route($base_route, 'buyvalues', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getbuyvalues'],
            ],
        ]);

        register_rest_route($base_route, 'marketdepth', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getmarketdepth'],
            ],
        ]);

        register_rest_route($base_route, 'stockstosell', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getstockstosell'],
            ],
        ]);

        register_rest_route($base_route, 'toselldetails', [
            [
                'method' => 'GET',
                'callback' => [$this, 'gettoselldetails'],
            ],
        ]);

        register_rest_route($base_route, 'sellstock', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getsellstock'],
            ],
        ]);

        register_rest_route($base_route, 'buypower', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getbuypower'],
            ],
        ]);

        register_rest_route($base_route, 'performance', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getperformance'],
            ],
        ]);

        register_rest_route($base_route, 'dstock', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getdstock'],
            ],
        ]);

        register_rest_route($base_route, 'liveportfolio', [
            [
                'method' => 'GET',
                'callback' => [$this, 'getliveportfolio'],
            ],
        ]);

        register_rest_route($base_route, 'tradelogs', [
            [
                'method' => 'GET',
                'callback' => [$this, 'gettradelogs'],
            ],
        ]);

        register_rest_route($base_route, 'deletedata', [
            [
                'method' => 'GET',
                'callback' => [$this, 'deletedata'],
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
            userid varchar(250) not null,
            stock varchar(250) not null,
            volume varchar(250) not null,
            averageprice varchar(250) not null,
            emotion varchar(250) not null,
            strategy varchar(250) not null,
            tradeplan varchar(250) not null,
            tradenotes varchar(250) not null,
            sellprice varchar(250) not null,
            buydate varchar(250) not null,
            profit varchar(250) not null,
            profitperc varchar(250) not null
        )");

        return $this->respond(true, ['data' => "success?"], 200);
    }

    // pusher
    public function pushLiveTrade($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $sql = "select * from arby_vt_live where stockname = '".$data['stockname']."' and userid = ".$data['userid'];
        $insertlive = $wpdb->get_results($sql);
        if(!empty($insertlive)){
            $oldinfo = $insertlive[0];
            $oldmarketvals = $oldinfo->volume * $oldinfo->buyprice;
            $newmarketvals = $data['buyprice'] * $data['volume'];
            $newmarketvals = $newmarketvals + $this->getjurfees($newmarketvals, 'buy');
            $upvolume = $oldinfo->volume + $data['volume'];
            $averageprice = ($oldmarketvals + $newmarketvals) / $upvolume;

            $sql = "update arby_vt_live set buyprice = '".$averageprice."', volume = '".$upvolume."', buydate = '".$data['buydate']."' where id = ".$oldinfo->id;
            $insertlive = $wpdb->query($sql);
            return $this->respond(true, ['data' => "updated buy"], 200);
        } else {
            $sql = "insert into arby_vt_live (stockname, buyprice, volume, emotion, strategy, tradeplan, tradenotes, buydate, vtcategory, vttype, userid) values ('".$data['stockname']."', '".$data['buyprice']."', '".$data['volume']."', '".$data['emotion']."', '".$data['strategy']."', '".$data['tradeplan']."', '".$data['tradenotes']."', '".$data['buydate']."', '".$data['category']."', '".$data['type']."', '".$data['userid']."')";
            $insertlive = $wpdb->query($sql);
            if($insertlive){
                
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

        
        return $this->respond(true, ['data' => $insertlive], 200);
    }

    //getters
    public function getbuyvalues($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $returningdata = [];

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $dstockdata = json_decode($request->content);
        $returningdata['stockinfo'] = $dstockdata->data;

        return $this->respond(true, ['data' => $dstockdata->data], 200);
    }

    public function getmarketdepth($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $stockname = strtoupper($data['stock']);
        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/market-depth/latest/full-depth?exchange=PSE&symbol=".$stockname, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $dstockdata = json_decode($request->content);



        return $this->respond(true, ['data' => $dstockdata->data], 200);
    }

    public function getstockstosell($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $listofstocks = [];
        $sql = "select * from arby_vt_live where userid = ".$data['userid'];
        $insertlive = $wpdb->get_results($sql);
        foreach ($insertlive as $key => $value) { array_push($listofstocks, $value->stockname); }
        $dstocks = array_unique($listofstocks);
        return $this->respond(true, ['data' => $dstocks], 200);
    }

    public function gettoselldetails($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE&symbol=".$data['stock'], [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $dstockdata = json_decode($request->content);
                
        $dstock = [];
        $dstock['stock'] = $data['stock'];
        $dstock['emotion'] = "";
        $dstock['strategy'] = "";
        $dstock['tradeplan'] = "";
        $dstock['tradenotes'] = "";
        $dstock['volume'] = "";
        $dstock['averageprice'] = "";
        $dstock['datainfo'] = $dstockdata->data;

        $totalaspertrade = 0;
        $sql = "select * from arby_vt_live where stockname = '".$data['stock']."' and vttype = 'vt' and userid = ".$data['userid'];
        $insertlive = $wpdb->get_results($sql);
        foreach ($insertlive as $key => $value) {
            $marketvals = $value->buyprice * $value->volume;
            $totalaspertrade += ($marketvals + $this->getjurfees($marketvals, 'buy'));
            $dstock['volume'] += $value->volume;
            $dstock['emotion'] = $value->emotion;
            $dstock['strategy'] = $value->strategy;
            $dstock['tradeplan'] = $value->tradeplan;
            $dstock['tradenotes'] = $value->tradenotes;
        }
        $dstock['averageprice'] = $totalaspertrade / $dstock['volume'];

        return $this->respond(true, ['data' => $dstock], 200);
    }

    public function getsellstock($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $sql = "select * from arby_vt_live where stockname = '".$data['stock']."' and vttype = 'vt' and userid = ".$data['userid'];
        $insertlive = $wpdb->get_results($sql);

        $stockdetails = $insertlive[0];

        $remainingstocks = $stockdetails->volume - $data['volume'];

        $marketvals = $data['averageprice'] * $data['volume'];
        $sellvals = $data['sellprice'] * $data['volume'];
        $sellcost = $sellvals - $this->getjurfees($sellvals, 'sell');
        $profit = $sellcost - $marketvals;
        $profperc = ($profit / $marketvals) * 100;
        

        if($remainingstocks >= 0){
            $sql = "insert into arby_vt_tradelog (userid, stock, volume, averageprice, emotion, strategy, tradeplan, tradenotes, sellprice, buydate, profit, profitperc) values ('".$data['userid']."','".$data['stock']."','".$data['volume']."','".$data['averageprice']."','".$data['emotion']."','".$data['strategy']."','".$data['tradeplan']."','".$data['tradenotes']."','".$data['sellprice']."','".$data['buydate']."','".$profit."','".$profperc."')";
            if($remainingstocks == 0){
                $updatelivetrade = "delete from arby_vt_live where id = ".$stockdetails->id;
            } else {
                $updatelivetrade = "update arby_vt_live set volume = '".$remainingstocks."' where id = ".$stockdetails->id;
            }
            $insertlive = $wpdb->query($sql);
            $insertlive = $wpdb->query($updatelivetrade);
            
            
            return $this->respond(true, ['data' => 'Done Selling'], 200);
        } else {
            return $this->respond(true, ['data' => 'cant sell'], 200);
        }

        

        
    }

    public function getbuypower($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $initialmoney = 100000;

        $checkliveportfolio = "select * from arby_vt_live where vttype = 'vt' and userid = ".$data['userid'];
        $insertlive = $wpdb->get_results($checkliveportfolio);  
        $liveammount = 0;
        foreach ($insertlive as $key => $value) {
            $totaltr = $value->buyprice * $value->volume;
            $liveammount += $totaltr;
        }

        $getliveportfolio = "select * from arby_vt_tradelog where userid = ".$data['userid'];
        $liveport = $wpdb->get_results($getliveportfolio);  
        $trammount = 0;
        foreach ($liveport as $key => $value) {
            $totaltr = $value->sellprice * $value->volume;
            $trammount += $totaltr;
        }

        $totalbuy = ($initialmoney - $liveammount) + $trammount;

        
        return $this->respond(true, ['data' => $totalbuy], 200);
    }

    public function getperformance($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $gerdqoute = json_decode($request->content);

        $perinfo = [];
        $perinfo['capital'] = 100000;

        $gettradelogs = "select * from arby_vt_tradelog where userid = ".$data['userid'];
        $tradelogsinfo = $wpdb->get_results($gettradelogs);  
        $perinfo['realized'] = 0;
        $moneymoves = 0;
        foreach ($tradelogsinfo as $key => $value) {
            $sellprice = $value->sellprice * $value->volume;
            $perinfo['realized'] += $value->profit;
            $moneymoves += $sellprice;
        }

        $liveportfolio = "select * from arby_vt_live where vttype = 'vt' and userid = ".$data['userid'];
        $liveportfolioinfo = $wpdb->get_results($liveportfolio);  
        $perinfo['unrealize'] = 0;
        $buytotal = 0;
        foreach ($liveportfolioinfo as $key => $value) {
            $stock = $value->stockname;
            $key = array_search($stock, array_column($gerdqoute->data, 'symbol'));
            $uneqt = $value->volume * $gerdqoute->data[$key]->last;
            $totaltr = $value->buyprice * $value->volume;

            $profit = $uneqt - $totaltr;

            $buytotal += $totaltr;
            $perinfo['unrealize'] += $profit;
        }

        $perinfo['equity'] = ($perinfo['capital'] + $perinfo['realized'] + $perinfo['unrealize']);

        $profs = $perinfo['equity'] - $perinfo['capital'];
        $perinfo['percentage'] = ($profs / $perinfo['capital']) * 100;

        $perinfo['buypower'] = ($perinfo['capital'] - $buytotal) + $perinfo['realized'];
        

        return $this->respond(true, ['data' => $perinfo], 200);
    }

    public function getdstock($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE&symbol=".$data['stock'], [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $gerdqoute = json_decode($request->content);

        return $this->respond(true, ['data' => $gerdqoute->data], 200);
    }

    public function getliveportfolio($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();

        $liveportfolio = "select * from arby_vt_live where vttype = 'vt' and userid = ".$data['userid'];
        $liveportfolioinfo = $wpdb->get_results($liveportfolio);

        $dstock = [];
        $listofstocks = [];
        foreach ($liveportfolioinfo as $key => $value) {
            $marketvals = $value->buyprice * $value->volume;
            $totalaspertrade += ($marketvals + $this->getjurfees($marketvals, 'buy'));
            $dstock['stockid'] = $value->id;
            $dstock['stockname'] = $value->stockname;
            $dstock['volume'] += $value->volume;
            $dstock['emotion'] = $value->emotion;
            $dstock['strategy'] = $value->strategy;
            $dstock['tradeplan'] = $value->tradeplan;
            $dstock['tradenotes'] = $value->tradenotes;
            $dstock['averageprice'] = $totalaspertrade / $dstock['volume'];
            $dstock['buyprice'] = $value->buyprice;

            $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE&symbol=".$value->stockname, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
            ]);
            $dstockdata = json_decode($request->content);
            $dstock['datainfo'] = $dstockdata->data;

            array_push($listofstocks, $dstock);
        }       
        return $this->respond(true, ['data' => $listofstocks], 200);
    }

     public function gettradelogs($details)
    {
        global $wpdb;
        $data = $details->get_params();

        $tradelogs = "select * from arby_vt_tradelog where userid = ".$data['userid'];
        $tradelogsinfo = $wpdb->get_results($tradelogs);

        $dstock = [];
        $listofstocks = [];
        foreach ($tradelogsinfo as $key => $value) {
             $dstock['stockname'] = $value->stock;
             $dstock['volume'] = $value->volume;
             $dstock['averageprice'] = $value->averageprice;
             $dstock['emotion'] = $value->emotion;
             $dstock['strategy'] = $value->strategy;
             $dstock['tradeplan'] = $value->tradeplan;
             $dstock['tradenotes'] = $value->tradenotes;
             $dstock['sellprice'] = $value->sellprice;
             $dstock['buydate'] = $value->buydate;
             $dstock['profit'] = $value->profit;
             $dstock['profitperc'] = $value->profitperc;
             array_push($listofstocks, $dstock);
        }
        return $this->respond(true, ['data' => $listofstocks], 200);
    }

    public function deletedata($details)
    {
        global $wpdb;
        $data = $details->get_params();
        $liveportfolio = "delete from arby_vt_live where id = ".$data['id']." and userid = ".$data['userid'];
       if($wpdb->query($liveportfolio)){
            return $this->respond(true, ['data' => 'Successfully deleted'], 200);
        }else{
            return $this->respond(true, ['data' => 'Error'], 200);
        }
    }

}

add_action('rest_api_init', function () {
    $virtualapi = new VirtualAPI();
    $virtualapi->registerRoutes();
});