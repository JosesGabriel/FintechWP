<?php

class JournalAPI extends WP_REST_Controller
{
    protected $namespace;
    protected $version;
    protected $table_name;

    public function __construct()
    {
        $this->version = 'v1';
        $this->namespace = 'journal-api';
        $this->table_name = 'arby_charting';
        $this->table_indicators = 'arby_chart_indicators';
    }

    public function registerRoutes()
    {
        $base_route = "$this->namespace/$this->version";

        register_rest_route($base_route, 'currentallocation', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getcurrentallocation'),
            ]
        ]);

        register_rest_route($base_route, 'liveportfolio', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getliveportfolio'),
            ]
        ]);

        register_rest_route($base_route, 'portfoliosnap', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getportfoliosnap'),
            ]
        ]);

        register_rest_route($base_route, 'tradelogs', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'gettradelogs'),
            ]
        ]);

        register_rest_route($base_route, 'ledger', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getledger'),
            ]
        ]);
    }

    // generic information
    public function respond($success = false, $data = [], $status = 500)
    {
        $data['status'] = $success ? 'ok' : 'error';
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

    public function getprofits($data)
    {
        $marketvals = $data->tlvolume * $data->tlaverageprice;
        $selltotal = $data->tlvolume * $data->tlsellprice;
        $selldata = $selltotal - $this->getjurfees($selltotal, 'sell');
        $profit = $selldata - $marketvals;

        return $profit;
    }


    // getters
    public function getcurrentallocation($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $win = 0;
        $loss = 0;

        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) {
            if($this->getprofits($value) > 0){ $win++; } else { $loss++; }
        }
        return $this->respond(true, ['data' => ['win' => $win, 'loss' => $loss]], 200);
    }

    public function getliveportfolio($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, 'https://dev-v1.arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
        
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $gerdqouteone = curl_exec($curl);
        curl_close($curl);
        
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key like "_trade_%" and meta_key not in ("_trade_list") and user_id = '.$data['userid']);
        $gerdqoute = json_decode($gerdqouteone);
        // var_dump($gerdqouteone);
        $finallive = [];
        foreach ($ismytrades as $key => $value) {
            $dstock = str_replace('_trade_','',$value->meta_key);
            $trdata = unserialize($value->meta_value);
            $key = array_search($dstock, array_column($gerdqoute->data, 'symbol'));
            $stockdetails = $gerdqoute->data[$key];

            // get marketvals
            $totalcost = $trdata['totalstock'] * $trdata['aveprice'];
            $marketprofit = $stockdetails->last * $trdata['totalstock'];
            $marketcost = $marketprofit - $this->getjurfees($marketprofit, 'sell');
            $profit = $marketcost - $totalcost;

            $dlivetrade = [];
            $dlivetrade['stock'] = $dstock;
            $dlivetrade['position'] = $trdata['totalstock'];
            $dlivetrade['aveprice'] = $trdata['aveprice'];
            $dlivetrade['totalcost'] = $totalcost;
            $dlivetrade['marketvalue'] = $marketcost;
            $dlivetrade['profit'] = $profit;
            $dlivetrade['profitperc'] = ($profit / $totalcost) * 100;
            $dlivetrade['livedetails'] = $stockdetails;

            $dlivetrade['strategy'] = $trdata['data'][0]['strategy'];
            $dlivetrade['tradeplan'] = $trdata['data'][0]['tradeplan'];
            $dlivetrade['emotion'] = $trdata['data'][0]['emotion'];
            $dlivetrade['tradingnotes'] = $trdata['data'][0]['tradingnotes'];
            $dlivetrade['boardlot'] = $trdata['data'][0]['boardlot'];
            $dlivetrade['outcome'] = ($profit > 0 ? "Winning" : "Loosing");
            array_push($finallive, $dlivetrade);
        }

        return $this->respond(true, ['data' => $finallive], 200);
    }

    public function getportfoliosnap($request)
    {
        global $wpdb;
        $data = $request->get_params();


        
        return $this->respond(true, ['test'], 200);
    }

    public function gettradelogs($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        $finaltrade = [];
        $totalprofit = 0;
        foreach ($ismytrades as $key => $value) {
            $buytotal = $value->tlvolume * $value->tlaverageprice;
            $selltotal = $value->tlvolume * $value->tlsellprice;
            $sellnet = $selltotal - $this->getjurfees($selltotal, 'sell');
            $profit = $sellnet - $buytotal;
            $value->buyvalue = $buytotal;
            $value->sellvalue = $sellnet;
            $value->profit = $profit;
            $value->perc = ($profit / $buytotal) * 100;
            $value->outcome = ($profit > 0 ? 'Winning' : 'Lossing');
            $totalprofit += $profit;
            array_push($finaltrade, $value);
        }
        return $this->respond(true, ['data' => $finaltrade, 'totalprofit' => $totalprofit], 200);
    }

    public function getledger($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $totaldebit = 0;
        $totalcredit = 0;
        $ledger = [];
        $dledger = $wpdb->get_results('select * from arby_ledger where userid = '.$data['userid'].' and trantype in ("deposit", "withraw", "dividend") order by ledid');
        $ending = 0;
        foreach ($dledger as $key => $value) {
            if($value->trantype == "deposit" || $value->trantype == "dividend"){
                $totalcredit += $value->tranamount;
                $ending += $value->tranamount;
            } else {
                $totaldebit += $value->tranamount;
                $ending -= $value->tranamount;
            }
            $value->ending = $ending;
            $value->nicedate = date("F d, Y", strtotime($value->date));
            $value->showtext = ($value->trantype == 'deposit' ? 'Deposit Funds' : ($value->trantype == 'withraw' ?  "Withdrawal" : "Dividend Income"));
            array_push($ledger, $value);
        }
        return $this->respond(true, ['data' => $ledger, 'debit' => $totaldebit, 'creadit' => $totalcredit], 200);
    }


}
// Register API endpoints
add_action('rest_api_init', function () {
    $JournalAPI = new JournalAPI();
    $JournalAPI->registerRoutes();
    
});

?>