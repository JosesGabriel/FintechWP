<?php
$chartsApi = new ChartsAPI;

add_action('rest_api_init', $chartsApi->registerRoutes());

class ChartsAPI extends WP_REST_Controller
{
    protected $namespace;
    protected $version;
    protected $table_name;

    public function __construct()
    {
        $this->version = 'v1';
        $this->namespace = 'charts-api';
        $this->table_name = 'arby_charting';
    }

    public function registerRoutes()
    {
        $base_route = "$this->namespace/$this->version";

        register_rest_route($base_route, 'charts', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'getTemplate'],
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'saveTemplate'],
            ],
        ]);
    }

    public function respond($success = false, $data = [], $status = 500)
    {
        $data['status'] = $success ? 'ok' : 'error';
        $status = $success ? 200 : $status;
        return new WP_REST_Response($data, $status);
    }

    public function getTemplate($request)
    {
        global $wpdb;
        $data = $request->get_params();

        $this->respond(true, [
            'test' => true,
        ], 200);
    }

    public function saveTemplate($request)
    {
        global $wpdb;
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['name'])) {
            $this->respond(false, [
                'message' => 'The name is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['content'])) {
            $this->respond(false, [
                'message' => 'The content is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['symbol'])) {
            $this->respond(false, [
                'message' => 'The symbol is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['resolution'])) {
            $this->respond(false, [
                'message' => 'The resolution is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['client_id'])) {
            $this->respond(false, [
                'message' => 'The client_id is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['user_id']) ||
            !is_numeric($data['user_id'])) {
            $this->respond(false, [
                'message' => 'The user_id is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Data insertion
        $wpdb->insert(
            $this->table_name,
            compact($data)
        );
        //endregion Data insertion

        $this->respond(true, [
            'id' => $wpdb->insert_id,
        ]); 
    }
}

function charting_api_save(WP_REST_Request $request) 
{
    global $wpdb;
    $data = $request->get_params();
    $data['status'] = 'ok';
    return new WP_REST_Response( $data, '200' );
}