<?php
/*
 * Template Name: Charting API Page
 * Template page for Watchlist Page Platform
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Content-Type: application/json; charset=UTF-8');
header("Cache-Control: no-cache"); 
header("Pragma: no-cache"); 
require(getcwd().'/wp-load.php');

global $wpdb;

$charts_table = 'arby_charting';
$request_method = $_SERVER['REQUEST_METHOD'];

function respond($success = false, $data = [], $status = 500)
{
    $data['status'] = $success ? 'ok' : 'error';
    $status = $success ? 200 : $status;
    http_response_code($status);
    echo json_encode($data);
    die();
}

/**
 * TRADINGVIEW CHARTS
 */
if ($request_method === 'POST') {
    $user_id = get_current_user_id();
    $data = $_POST;
    $get = $_GET;
    //region Data validation
    if (!isset($data['name'])) {
        respond();
    }

    if (!isset($data['content'])) {
        respond();
    }

    if (!isset($data['symbol'])) {
        respond();
    }

    if (!isset($data['resolution'])) {
        respond();
    }

    if (!isset($get['client_id'])) {
        respond();
    }

    if (!isset($user_id) ||
        !is_numeric($user_id)) {
        respond();
    }
    //endregion Data validation

    $data['user_id'] = $user_id;
    $data['client_id'] = $client_id;

    //region Data insertion
    $wpdb->insert(
        $charts_table,
        compact($data)
    );
    //endregion Data insertion

    respond(true, [
        'id' => $wpdb->insert_id,
    ]);
} else if ($request_method === 'GET') {

}

respond(false, ['status' => 'No hacc ples.'], 403);