<?php
/*
 * Template Name: API Page
 * Template page for Watchlist Page Platform
 */

header('Content-Type: application/json');

global $wpdb;

$charts_table = 'arby_charting';

/**
 * TRADINGVIEW CHARTS
 */
if (isset($_POST['tv_save_chart'])) {
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
}

function respond($success = false, $data = [])
{
    $data['status'] = $success ? 'ok' : 'error';
    echo json_encode(array_push($data, $status));
    die();
}