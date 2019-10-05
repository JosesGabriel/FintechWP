<?php

// if (! function_exists('vyndue_user_register')) {
    function vyndue_user_register($user_id, $args) {

        echo "test";
        exit();

        // //region Set POST data
        // $data = http_build_query([
        //     'first_name' => $_POST['first_name'],
        //     'last_name' => $_POST['last_name'],
        //     'email' => $_POST['user_email'],
        //     'password' => $_POST['user_password'],
        // ]);
        // //endregion Set POST data

        // //region call api
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/create');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($curl);
        // curl_close($curl);
        // //endregion call api

    }

    // add_action('user_register', 'vyndue_user_register');
    add_action('um_user_register', 'vyndue_user_register', 10, 2 );
// }