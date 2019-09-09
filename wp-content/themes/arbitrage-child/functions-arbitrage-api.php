<?php

function arbitrage_api_get_user_uuid($user_id) {
    return get_user_meta($user_id, 'user_uuid', true);
}

function arbitrage_api_curl_multipart($uri = '', $data = [], $files = [], $method = 'POST', $headers = []) {
    $headers[] = 'Content-Type:multipart/form-data';
    return arbitrage_api_curl($uri, $data, $method, $headers);
}

function arbitrage_api_curl($uri = '', $data = [], $method = 'POST', $headers = []) {
    $valid_methods = ['DELETE', 'GET', 'POST', 'PUT'];
    $eol = "\r\n";

    if (!in_array($method, $valid_methods)) {
        ob_start();
        echo "CUSTOM ERROR LOG ====================================================$eol";
        echo "functions-arbitrage-api.php => function arbitrage_api_curl $eol";
        echo "INVALID METHOD: Given method was " . $method;
        echo "END CUSTOM ERROR LOG ====================================================$eol";
        $contents = ob_get_contents();
        ob_end_clean();
        error_log($contents);
        return false;
    }

    $error = null;
    $curl = curl_init();
    if (!empty($headers)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($curl, CURLOPT_URL, "https://dev-api.arbitrage.ph/$uri");
    curl_setopt($curl, CURLOPT_RESOLVE, ['dev-api.arbitrage.ph:443:35.247.145.199']);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    if (!$response) {
        $error = curl_error($curl);
    }
    $info = curl_getinfo($curl);
    curl_close($curl);

    if (!$response) {
        ob_start();
        echo "CUSTOM ERROR LOG ====================================================$eol";
        echo "functions-arbitrage-api.php => function arbitrage_api_curl $eol $eol";
        echo "\$uri $eol";
        var_dump($uri, true);
        echo $eol . $eol;
        echo "\$data $eol";
        var_dump($data, true);
        echo $eol . $eol;
        echo "\$error $eol";
        var_dump($error, true);
        echo $eol . $eol;
        echo "\$response $eol";
        var_dump($response, true);
        echo $eol . $eol;
        echo "\$info $eol";
        var_dump($info, true);
        echo $eol . $eol;
        echo "END CUSTOM ERROR LOG ====================================================$eol";
        $contents = ob_get_contents();
        ob_end_clean();

        error_log($contents);

        return false;
    }

    $response = json_decode($response, true);

    if (!$response['success']) {
        ob_start();
        echo "CUSTOM ERROR LOG ====================================================$eol";
        echo "functions-arbitrage-api.php => function arbitrage_api_curl $eol $eol";
        echo "\$uri $eol";
        var_dump($uri);
        echo $eol . $eol;
        echo '$data' . $eol;
        var_dump($data);
        echo $eol . $eol;
        echo '$response' . $eol;
        var_dump($response);
        echo $eol . $eol;
        echo '$info' . $eol;
        var_dump($info);
        echo $eol . $eol;
        echo "END CUSTOM ERROR LOG ====================================================$eol";
        $contents = ob_get_contents();
        ob_end_clean();

        error_log($contents);
        return false;
    }

    return $response['data'];
}

function arbitrage_api_verify_user($user_id) {
    $uuid = arbitrage_api_get_user_uuid($user_id);

    if ($uuid != '') {
        $response = arbitrage_api_curl("api/users/$uuid/verify", []);
    }
}

function arbitrage_api_upload_to_gcs($filepath = '') {
    $info = pathinfo($filepath);
    $filename = $info['basename'];
    $mime = wp_check_filetype($filename);

    $file_data = new CURLFILE($filepath, $mime['type'], $filename);
    $data = [
        'file' => $file_data,
    ];

    return arbitrage_api_curl_multipart('api/storage/upload', $data, 'POST');
}