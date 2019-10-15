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

        $wpdb->query("create table myguests (
            id int(6) unsigned auto_increment primary key,
            firstname varchar(30) not null,
            lastname varchar(30) not null,
            email varchar(50),
            reg_date timestamp default current_timestamp on update current_timestamp
            )");
    }

}

add_action('rest_api_init', function () {
    $virtualapi = new VirtualAPI();
    $virtualapi->registerRoutes();
});