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



}
// Register API endpoints
add_action('rest_api_init', function () {
    $JournalAPI = new JournalAPI();
    $JournalAPI->registerRoutes();
    
});