<?php

require_once ('guzzle-class.php');
require_once ('data-api.php');

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

        // chart creator
        register_rest_route($base_route, 'currentallocation', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getcurrentallocation'),
            ]
        ]);

        register_rest_route($base_route, 'tradestatistics', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'gettradestatistics'),
            ]
        ]);

        register_rest_route($base_route, 'monthlyperformance', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getmonthlyperformance'),
            ]
        ]);

        register_rest_route($base_route, 'strategystatistics', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getstrategystatistics'),
            ]
        ]);

        register_rest_route($base_route, 'topstocks', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'gettopstocks'),
            ]
        ]);

        register_rest_route($base_route, 'emotionalreport', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getemotionalreport'),
            ]
        ]);

        register_rest_route($base_route, 'expensereport', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getexpensereport'),
            ]
        ]);

        register_rest_route($base_route, 'buystatus', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getbuystatus'),
            ]
        ]);

        register_rest_route($base_route, 'weekperformance', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getweekperformance'),
            ]
        ]);

        register_rest_route($base_route, 'grosproffloss', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getgrosproffloss'),
            ]
        ]);


        // data sections
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

        register_rest_route($base_route, 'buypower', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getbuypower'),
            ]
        ]);

        register_rest_route($base_route, 'allstocks', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getallstocks'),
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
        $aloccolors = array('#FF5500', '#00B4C4', '#FF008F', '#FFB700', '#CEF500', '#FB3640', '#00AAFF', '#CC0066', '#33FF99', '#FF8000', '#33FFCC', '#FB3640', '#FF2B66', '#99FF00', '#9900FF', '#FB3640', '#00B4C4', '#FF008F', '#FFB700');

        $allocations = [];
        $counter = 0;
        $cashme = 0;
        $getequiry = $wpdb->get_results('select * from arby_ledger where userid = '.$data['userid'].' order by ledid');
        foreach ($getequiry as $key => $value) {
            if($value->trantype == 'withraw' || $value->trantype == 'purchase'){ $cashme -= $value->tranamount; }
            if($value->trantype == 'selling' || $value->trantype == 'dividend' || $value->trantype == 'deposit'){ $cashme += $value->tranamount; }
        }
        $allocations[$counter]['value'] = $cashme;
        $allocations[$counter]['stock'] = 'Cash';
        $allocations[$counter]['color'] = $aloccolors[$counter];

        // $curl = curl_init();
	    // curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
        // curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $gerdqouteone = curl_exec($curl);
        // curl_close($curl);

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("POST", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $gerdqoute = json_decode($request->content);


        
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key like "_trade_%" and meta_key not in ("_trade_list") and user_id = '.$data['userid']);
        // $gerdqoute = json_decode($gerdqouteone);

        $finallive = [];
        foreach ($ismytrades as $key => $value) {
            $counter++;
            $dstock = str_replace('_trade_','',$value->meta_key);
            $trdata = unserialize($value->meta_value);
            $key = array_search($dstock, array_column($gerdqoute->data, 'symbol'));
            $stockdetails = $gerdqoute->data[$key];
            $marketprofit = $stockdetails->last * $trdata['totalstock'];
            $marketcost = $marketprofit - $this->getjurfees($marketprofit, 'sell');
            $allocations[$counter]['value'] = $marketcost;
            $allocations[$counter]['stock'] = $dstock;
            $allocations[$counter]['color'] = $aloccolors[$counter];
            
        }
        return $this->respond(true, ['data' => $allocations], 200);
    }

    public function gettradestatistics($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $win = 0;
        $loss = 0;
        $totaltrades = 0;
        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) {
            if($this->getprofits($value) > 0){ $win++; } else { $loss++; }
            $totaltrades++;
        }
        $winperc = ($win / $totaltrades) * 100;
        return $this->respond(true, ['data' => ['win' => $win, 'loss' => $loss, 'totaltrades' => $totaltrades, 'winperc' => $winperc]], 200);
    }

    public function getmonthlyperformance($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $months = ['jan' => 0,'feb' => 0,'mar' => 0,'apr' => 0,'may' => 0,'jun' => 0,'jul' => 0,'aug' => 0,'sep' => 0,'oct' => 0,'nov' => 0,'dec' => 0];
        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) {
            $trademonth = date('M', strtotime($value->tldate));
            $buytotal = $value->tlvolume * $value->tlaverageprice;
            $selltotal = $value->tlvolume * $value->tlsellprice;
            $sellnet = $selltotal - $this->getjurfees($selltotal, 'sell');
            $profit = $sellnet - $buytotal;
            $months[strtolower($trademonth)] += $profit;
        }
        return $this->respond(true, ['data' => $months], 200);
    }

    public function getstrategystatistics($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $strats = [
            'Bottom Picking' => ['total_trades' => 0,'trwin' => 0,'trloss' => 0,],
            'Breakout Play' => ['total_trades' => 0,'trwin' => 0,'trloss' => 0,],
            'Trend Following' => ['total_trades' => 0,'trwin' => 0,'trloss' => 0,],
        ];
        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) {
            $strats[$value->tlstrats]['total_trades']++;
            if($this->getprofits($value) > 0){
                $strats[$value->tlstrats]['trwin']++;
            } else {
                $strats[$value->tlstrats]['trloss']++;
            }
        }
        $winners = max(array_column($strats, 'trwin'));
        $loosers = max(array_column($strats, 'trloss'));
        $winname = "";
        $lossname = "";
        foreach ($strats as $skey => $svalue) {
            if($svalue['trwin'] == $winners){ $winname = $skey; }
            if($svalue['trloss'] == $loosers){ $lossname = $skey; }
        }
        return $this->respond(true, ['data' => $strats, 'wins' => $winname, 'loss' => $lossname], 200);
    }

    public function gettopstocks($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $topstocks = [];
        $buttomstocks = [];
        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) {
            $myprofit = $this->getprofits($value);
            $value->profit = $myprofit;
            if($myprofit > 0){
                array_push($topstocks, $value);
            } else {
                array_push($buttomstocks, $value);
            }
        }

        return $this->respond(true, ['data' => ['top' => $topstocks, 'buttom' => $buttomstocks]], 200);
    }

    public function getemotionalreport($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $tremo = [
            'Neutral' => ['total_trades' => 0,'trwin' => 0,'trloss' => 0],
            'Greedy' => ['total_trades' => 0,'trwin' => 0,'trloss' => 0],
            'Fearful' => ['total_trades' => 0,'trwin' => 0,'trloss' => 0]
        ];
        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) {
            $tremo[$value->tlemotions]['total_trades']++;
            if($this->getprofits($value) > 0){
                $tremo[$value->tlemotions]['trwin']++;
            } else {
                $tremo[$value->tlemotions]['trloss']++;
            }
        }

        return $this->respond(true, ['data' => $tremo], 200);
    }

    public function getexpensereport($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $allcost = [];
        $allcost['commissions'] = 0;
        $allcost['vat'] = 0;
        $allcost['transferfee'] = 0;
        $allcost['sccp'] = 0;
        $allcost['salestax'] = 0;
        $months = ['jan' => 0,'feb' => 0,'mar' => 0,'apr' => 0,'may' => 0,'jun' => 0,'jul' => 0,'aug' => 0,'sep' => 0,'oct' => 0,'nov' => 0,'dec' => 0];

        $gettradelogsd = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($gettradelogsd as $key => $value) {
            $funmarketval = $value->tlsellprice * $value->tlvolume;
            $dmonth = date('M', strtotime($value->tldate));

            $dpartcommission = $funmarketval * 0.0025;
            $dcommission = ($dpartcommission > 20 ? $dpartcommission : 20);
            $dtax = $dcommission * 0.12;
            $dtransferfee = $funmarketval * 0.00005;
            $dsccp = $funmarketval * 0.0001;
            $dsell = $funmarketval * 0.006;

            $allcost['commissions'] += $dcommission;
            $allcost['vat'] += $dtax;
            $allcost['transferfee'] += $dtransferfee;
            $allcost['sccp'] += $dsccp;
            $allcost['salestax'] += $dsell;

            $months[strtolower($dmonth)] += $this->getjurfees($funmarketval, 'sell');
        }

        return $this->respond(true, ['data' => ['bycoms' => $allcost, 'months' => $months]], 200);
    }

    public function getbuystatus($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $volumelist = [];
        $valuelist = [];
        for ($i=0; $i < 20; $i++) { 
            array_push($volumelist, 0);
            array_push($valuelist, 0);
        }
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key like "_trade_%" and meta_key not in ("_trade_list") and user_id = '.$data['userid'].' order by umeta_id DESC');
        foreach ($ismytrades as $key => $value) {
            $meta_value = unserialize($value->meta_value);
            $volumelist[$key] += $meta_value['totalstock'];
            $valuelist[$key] += $meta_value['aveprice'];
        }

        return $this->respond(true, ['data' => ['volume' => $volumelist, 'value' => $valuelist]], 200);
    }

    public function getweekperformance($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $profits = ['mon' => 0,'tue' => 0,'wed' => 0,'thu' => 0,'fri' => 0];
        $gettradelogsd = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($gettradelogsd as $key => $value) {
            $weekday = date('D', strtotime($value->tldate));
            $profits[strtolower($weekday)] += $this->getprofits($value);
        }

        return $this->respond(true, ['data' => $profits], 200);
    }

    public function getgrosproffloss($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $grosspl = [];
        for ($i=0; $i < 20; $i++) {array_push($grosspl, 0);}
        $gettradelogsd = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate DESC');
        foreach ($gettradelogsd as $key => $value) {
            $grosspl[$key] += $this->getprofits($value);
        }
        return $this->respond(true, ['data' => $grosspl], 200);
    }

    // data sections
    public function getliveportfolio($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $equity = 0;
        $getequiry = $wpdb->get_results('select * from arby_ledger where userid = '.$data['userid'].' order by ledid');
        foreach ($getequiry as $key => $value) {
            if($value->trantype == 'withraw' || $value->trantype == 'purchase'){
                $equity -= $value->tranamount;
            }
            if($value->trantype == 'selling' || $value->trantype == 'dividend' || $value->trantype == 'deposit'){
                $equity += $value->tranamount;
            }
        }

        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
        
        // curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $gerdqouteone = curl_exec($curl);
        // curl_close($curl);

        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("POST", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $gerdqoute = json_decode($request->content);

        // $gerdqouteone = file_get_contents('https://arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
        
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key like "_trade_%" and meta_key not in ("_trade_list") and user_id = '.$data['userid']);
        // $gerdqoute = json_decode($gerdqouteone);

        $finallive = [];
        foreach ($ismytrades as $key => $value) {
            if($value->meta_value != ""){
                $dstock = str_replace('_trade_','',$value->meta_key);
                $trdata = unserialize($value->meta_value);
                $key = array_search($dstock, array_column($gerdqoute->data, 'symbol'));
                $stockdetails = $gerdqoute->data[$key];

                // get marketvals
                $totalcost = $trdata['totalstock'] * $trdata['aveprice'];
                $marketprofit = $stockdetails->last * $trdata['totalstock'];
                $marketcost = $marketprofit - $this->getjurfees($marketprofit, 'sell');
                $profit = $marketcost - $totalcost;

                $equity += $marketcost;
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
            
        }

        return $this->respond(true, ['data' => $finallive, 'equity' => $equity], 200);
    }

    public function getportfoliosnap($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $information = [];
        $information['capital'] = 0;
        $information['deposit'] = 0;
        $information['withraw'] = 0;
        $ismytrades = $wpdb->get_results('select * from arby_ledger where userid = '.$data['userid'].' order by ledid');
        foreach ($ismytrades as $key => $value) {
            if($key == 0){ $information['capital'] = $value->tranamount; }
            if($value->trantype == 'deposit'){
                $information['deposit'] += $value->tranamount;
            }
            if($value->trantype == 'withraw'){
                $information['withraw'] += $value->tranamount;
            }
        }
        $information['profit'] = 0;
        $getprofits = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($getprofits as $key => $value) {
            $buytotal = $value->tlvolume * $value->tlaverageprice;
            $selltotal = $value->tlvolume * $value->tlsellprice;
            $sellnet = $selltotal - $this->getjurfees($selltotal, 'sell');
            $profit = $sellnet - $buytotal;
            $information['profit'] += $profit;
        }

        $information['profperc'] = ($information['profit'] / $information['capital']) * 100;


        
        return $this->respond(true, ['data' => $information], 200);
    }

    public function gettradelogs($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        $finaltrade = [];
        $totalprofit = 0;
        foreach ($ismytrades as $key => $value) {
            $volume = str_replace(",", "", $value->tlvolume);
            $buytotal = $volume * $value->tlaverageprice;
            $selltotal = $volume * $value->tlsellprice;
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

    public function getbuypower($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $cashme = 0;
        $getequiry = $wpdb->get_results('select * from arby_ledger where userid = '.$data['userid'].' order by ledid');
        foreach ($getequiry as $key => $value) {
            if($value->trantype == 'withraw' || $value->trantype == 'purchase'){ $cashme -= $value->tranamount; }
            if($value->trantype == 'selling' || $value->trantype == 'dividend' || $value->trantype == 'deposit'){ $cashme += $value->tranamount; }
        }

        return $this->respond(true, ['data' => $cashme], 200);
    }

    public function getallstocks($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $guzzle = new GuzzleRequest();
        $dataUrl = GetDataApiUrl();
        $authorization = GetDataApiAuthorization();
        $request = $guzzle->request("POST", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE", [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "Bearer {$authorization}",
                ]
        ]);
        $stocks = json_decode($request->content);

        // $xmlData = file_get_contents('https://arbitrage.ph/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
        // $stocks = json_decode($xmlData);
        return $this->respond(true, ['data' => $stocks->data], 200);
    }

}
// Register API endpoints
add_action('rest_api_init', function () {
    $JournalAPI = new JournalAPI();
    $JournalAPI->registerRoutes();
    
});

?>