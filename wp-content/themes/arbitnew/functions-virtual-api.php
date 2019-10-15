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
    }

    public function respond($success = false, $data = [], $status = 500)
    {
        $data['status'] = $success ? 'ok' : 'error';
        $data['success'] = $success;
        $status = $success ? 200 : $status;
        return new WP_REST_Response($data, $status);
    }

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
            vttype varchar(250)
        )");

        $wpdb->query("create table if not exists arby_vt_tradelog (
            id int(10) unsigned auto_increment primary key,
            tradeid varchar(250) not null,
            volume varchar(250),
            selldate varchar(250),
            vtcategory varchar(250),
            vttype varchar(250)
        )");

        return $this->respond(true, ['data' => "success?"], 200);
    }

}

add_action('rest_api_init', function () {
    $virtualapi = new VirtualAPI();
    $virtualapi->registerRoutes();
});