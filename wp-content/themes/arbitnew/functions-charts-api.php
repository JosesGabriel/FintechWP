<?php

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
        $this->table_indicators = 'arby_chart_indicators';
    }

    public function registerRoutes()
    {
        $base_route = "$this->namespace/$this->version";

        register_rest_route($base_route, 'charts', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getTemplate'),
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'saveTemplate'),
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'deleteTemplate'],
            ],
        ]);

        register_rest_route($base_route, 'study_templates', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'getIndicators'),
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'saveIndicator'),
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'deleteIndicator'],
            ],
        ]);
    }

    public function respond($success = false, $data = [], $status = 500)
    {
        $data['status'] = $success ? 'ok' : 'error';
        $status = $success ? 200 : $status;
        return new WP_REST_Response($data, $status);
    }

    public function deleteIndicator($request)
    {
        global $wpdb;
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['client'])) {
            return $this->respond(false, [
                'message' => 'The client is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['user']) ||
            !is_numeric($data['user'])) {
            return $this->respond(false, [
                'message' => 'The user is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['template'])) {
            return $this->respond(false, [
                'message' => 'The template is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Data deletion
        $delete = $wpdb->delete($this->table_indicators, [
            'client_id' => $data['client'],
            'user_id' => $data['user'],
            'name' => $data['template'],
        ]);

        if ($delete === false) {
            return $this->respond(false, [
                'message' => 'An error has occurred while deleting the chart.',
                'parameters' => $data,
            ], 500);
        }
        //endregion Data deletion

        return $this->respond(true, [], 200);
    }

    public function getIndicators($request){
        global $wpdb;
        $data = $request->get_params();

         //region Data validation
         if (!isset($data['client'])) {
            return $this->respond(false, [
                'message' => 'The client is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['user']) ||
            !is_numeric($data['user'])) {
            return $this->respond(false, [
                'message' => 'The user is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Behavioral change
        if (isset($data['template'])) {
            $indicator = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_indicators WHERE user_id = %d AND client_id = %s AND name = %s LIMIT 1", [$data['user'], $data['client'], $data['template']]));
            return $this->respond(true, [
                'data' => $indicator,
            ], 200);
        }
        //endregion Behavioral change

        //region Data retrieval
        $indicators = $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->table_indicators WHERE user_id = %d AND client_id = %s", [$data['user'], $data['client']]));
        //endregion Data retrieval

        return $this->respond(true, [
            'data' => $indicators,
        ], 200);
    }

    public function saveIndicator($request)
    {
        global $wpdb;
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['client'])) {
            return $this->respond(false, [
                'message' => 'The client is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['user']) ||
            !is_numeric($data['user'])) {
            return $this->respond(false, [
                'message' => 'The user is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['name'])) {
            return $this->respond(false, [
                'message' => 'The name is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['content'])) {
            return $this->respond(false, [
                'message' => 'The content is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Data insertion
        $wpdb->insert(
            $this->table_indicators,
            [
                'user_id' => $data['user'],
                'client_id' => $data['client'],
                'name' => $data['name'],
                'content' => $data['content'],
            ],
            [
                '%d', '%s', '%s', '%s'
            ]
        );

        $id = $wpdb->insert_id;

        if ($id == 0) {
            return $this->respond(false, [
                'message' => 'An error has occurred while saving to the database.',
            ], 500);
        }
        //endregion Data insertion

        return $this->respond(true, [
            'id' => $id,
        ]); 
    }

    public function deleteTemplate($request)
    {
        global $wpdb;
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['client'])) {
            return $this->respond(false, [
                'message' => 'The client is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['user']) ||
            !is_numeric($data['user'])) {
            return $this->respond(false, [
                'message' => 'The user is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['chart']) ||
            !is_numeric($data['chart'])) {
            return $this->respond(false, [
                'message' => 'The chart is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Data deletion
        $delete = $wpdb->delete($this->table_name, ['id' => $data['chart']]);

        if ($delete === false) {
            return $this->respond(false, [
                'message' => 'An error has occurred while deleting the chart.',
                'parameters' => $data,
            ], 500);
        }
        //endregion Data deletion

        return $this->respond(true, [], 200);
    }

    public function getTemplate($request)
    {
        global $wpdb;
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['client'])) {
            return $this->respond(false, [
                'message' => 'The client is not defined.',
                'parameters' => $data,
            ], 417);
        }

        if (!isset($data['user']) ||
            !is_numeric($data['user'])) {
            return $this->respond(false, [
                'message' => 'The user is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Behavioral change
        if (isset($data['chart'])) {
            $id = $data['chart'];

            $chart = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $id));
            return $this->respond(true, [
                'data' => $chart
            ], 200);
        }
        //endregion Behavioral change

        //region Data retrieval
        $charts = $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->table_name WHERE user_id = %d AND client_id = %s", [$data['user'], $data['client']]));
        //endregion Data retrieval

        return $this->respond(true, [
            'data' => $charts
        ], 200);
    }

    public function saveTemplate($request)
    {
        global $wpdb;
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['name'])) {
            return $this->respond(false, [
                'message' => 'The name is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['content'])) {
            return $this->respond(false, [
                'message' => 'The content is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['symbol'])) {
            return $this->respond(false, [
                'message' => 'The symbol is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['resolution'])) {
            return $this->respond(false, [
                'message' => 'The resolution is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['client'])) {
            return $this->respond(false, [
                'message' => 'The client is not defined.',
                'parameters' => $data,
            ], 417);
        }
    
        if (!isset($data['user']) ||
            !is_numeric($data['user'])) {
            return $this->respond(false, [
                'message' => 'The user is not defined.',
                'parameters' => $data,
            ], 417);
        }
        //endregion Data validation

        //region Data insertion
        $wpdb->insert(
            $this->table_name,
            [
                'user_id' => $data['user'],
                'client_id' => $data['client'],
                'name' => $data['name'],
                'content' => $data['content'],
                'symbol' => $data['symbol'],
                'resolution' => $data['resolution'],
                'timestamp' => time(),
            ],
            [
                '%d', '%s', '%s', '%s', '%s', '%s', '%d'
            ]
        );

        $id = $wpdb->insert_id;

        if ($id == 0) {
            return $this->respond(false, [
                'message' => 'An error has occurred while saving to the database.',
            ], 500);
        }
        //endregion Data insertion

        return $this->respond(true, [
            'id' => $id,
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

// Register API endpoints
add_action('rest_api_init', function () {
    $chartsApi = new ChartsAPI();
    $chartsApi->registerRoutes();
});