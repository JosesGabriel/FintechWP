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
        
        register_rest_route($base_route, 'tradestats', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'gettradestats'),
            ]
        ]);

        register_rest_route($base_route, 'monthperformance', [ // get method
            [
                'methods' => 'GET',
                'callback' => array($this, 'getmonthperformance'),
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
    public function gettradestats($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $win = 0;
        $loss = 0;
        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) { if($this->getprofits($value) > 0){ $win++; } else { $loss++; } }
        $totaltrades = $win + $loss;
        $winperc = ($win / $totaltrades) * 100;
        return $this->respond(true, ['data' => ['win' => $win, 'loss' => $loss, 'totaltrades' => $totaltrades, 'totalperc' => $winperc]], 200);
    }

    public function getcurrentallocation($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $ismytrades = $wpdb->get_results('select * from arby_usermeta where meta_key like "_trade_%" and meta_key not in ("_trade_list") and user_id ='.$data['userid']);
        return $this->respond(true, $ismytrades, 200);
    }

    public function getmonthperformance($request)
    {
        global $wpdb;
        $data = $request->get_params();
        $profitsmonths = ['jan' => 0,'feb' => 0,'mar' => 0,'apr' => 0,'may' => 0,'jun' => 0,'jul' => 0,'aug' => 0,'sep' => 0,'oct' => 0,'nov' => 0,'dec' => 0];
        $ismytrades = $wpdb->get_results('select * from arby_tradelog where isuser = '.$data['userid'].' order by tldate');
        foreach ($ismytrades as $key => $value) {
            $profitsmonths[strtolower(date('M', strtotime($value->tldate)))] += ($value->tlvolume * $value->tlsellprice);
        }
        return $this->respond(true, ['data' => $profitsmonths], 200);
    }



}
// Register API endpoints
add_action('rest_api_init', function () {
    $JournalAPI = new JournalAPI();
    $JournalAPI->registerRoutes();
    
});