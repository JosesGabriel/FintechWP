<?php

function arbitrage_api_get_user_uuid($user_id) {
    return get_user_meta($user_id, 'user_uuid', true);
}

function arbitrage_api_curl($uri = '', $data = [], $method = 'POST') {
    $valid_methods = ['DELETE', 'GET', 'POST', 'PUT'];

    if (!in_array($method, $valid_methods)) {
        error_log('CUSTOM ERROR LOG ====================================================');
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl');
        error_log('INVALID METHOD: Given method was ' . $method);
        error_log('END CUSTOM ERROR LOG ====================================================');
        return false;
    }

    $error = null;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://dev-api.arbitrage.ph/$uri");
    curl_setopt($curl, CURLOPT_RESOLVE, ['dev-api.arbitrage.ph:443:35.247.145.199']);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    if (!$response) {
        $error = curl_error($curl);
    }
    curl_close($curl);

    if (!$response) {
        error_log('CUSTOM ERROR LOG ====================================================');
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl $uri');
        error_log(print_r($uri, true));
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl $data');
        error_log(print_r($data, true));
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl $error');
        error_log(print_r($error, true));
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl $response');
        error_log(print_r($response, true));
        error_log('END CUSTOM ERROR LOG ====================================================');

        return false;
    }

    $response = json_decode($response, true);

    if (!$response['success']) {
        error_log('CUSTOM ERROR LOG ====================================================');
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl $uri');
        error_log(print_r($uri, true));
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl $data');
        error_log(print_r($data, true));
        error_log('functions-arbitrage-api.php => function arbitrage_api_curl $response');
        error_log(print_r($response, true));
        error_log('END CUSTOM ERROR LOG ====================================================');
        
        return false;
    }

    return $response['data'];
}

function arbitrage_api_verify_user($user_id) {
    $uuid = arbitrage_api_get_user_uuid($user_id);

    if ($uuid != '') {
        $response = arbitrage_api_curl('api/user/verify', ['id' => $uuid]);
    }
}