<?php

add_action('rest_api_init', function () {
    register_rest_route('charts/v1', 'charts/', array(
        'method' => 'POST',
        'callback' => 'charting_api_save',
    ));
});

function charting_api_save(WP_REST_Request $request) 
{
    global $wpdb;
    $data = $request->get_params();
    $data['status'] = 'ok';
    return new WP_REST_Response( $data, '200' );
}