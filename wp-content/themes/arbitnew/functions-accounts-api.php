<?php

class AccountsAPI extends ArbitrageAPI
{
    protected $namespace;
    protected $primary_key;
    protected $version;

    public function __construct()
    {
        $this->version = 'v1';
        $this->namespace = 'accounts-api';
        $this->primary_key = 'user_uuid';
    }

    public function registerRoutes()
    {
        $base_route = "$this->namespace/$this->version";

        register_rest_route($base_route, 'user', [
            [
                'methods' => 'GET',
                'callback' => array($this, 'fetchUser'),
            ],
        ]);
    }

    public function fetchUser($request)
    {
        $data = $request->get_params();

        //region Data validation
        if (!isset($data['id'])) {
            return $this->respond(false, [
                'message' => 'The id is not set or invalid.',
            ]);
        }
        //endregion Data validation

        $request = $this->setMethod('GET')
            ->setUri("/api/users/{$data['id']}")
            ->request();

        return $request;
    }
}

// Register API endpoints
add_action('rest_api_init', function () {
    $accounts_api = new AccountsAPI();
    $accounts_api->registerRoutes();
});