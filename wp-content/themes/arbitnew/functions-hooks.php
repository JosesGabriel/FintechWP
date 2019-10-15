<?php

add_action('user_register', 'myplugin_registration_save', 10, 1);
function myplugin_registration_save($user_id)
{
    global $wpdb;

    $secret = $_POST['nickname-9'] . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    add_user_meta($user_id, 'user_secret', $secret);

    //region Set POST data
    $data = http_build_query([
        'first_name' => $_POST['first_name-9'],
        'last_name' => $_POST['last_name-9'],
        'email' => $_POST['user_email-9'],
        'password' => $_POST['user_password-9'],
        'user_secret' => $secret,
    ]);
    //endregion Set POST data

    $api_data = [
        'first_name' => $_POST['first_name-9'],
        'last_name' => $_POST['last_name-9'],
        'username' => $_POST['nickname-9'],
        'email' => $_POST['user_email-9'],
        'password' => $_POST['user_password-9'],
        'password_confirmation' => $_POST['user_password-9'],
        'profile_image' => '',
    ];

    // //region call api
    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/create');
    // curl_setopt($curl, CURLOPT_POST, 1);
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($curl);
    // curl_close($curl);
}

// add_action('um_friends_after_user_friend', 'vyndue_add_friend', 10, 2);
// function vyndue_add_friend($user_1, $user_2)
// {
//     //region get users
//     $user_email_1 = (get_userdata($user_1))->user_email;
//     $user_email_2 = (get_userdata($user_2))->user_email;
//     //endregion get users

//     //region set post data
//     $data = http_build_query([
//         'requester' => $user_email_1,
//         'responder' => $user_email_2,
//     ]);
//     //endregion set post data

//     //region call api
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/add_friend');
//     curl_setopt($curl, CURLOPT_POST, 1);
//     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($curl);
//     curl_close($curl);
//     //endregion call api
// }

// add_action('um_friends_after_user_unfriend', 'vyndue_remove_friend', 10, 2);
// function vyndue_remove_friend($user_1, $user_2)
// {
//     //region get users
//     $user_email_1 = (get_userdata($user_1))->user_email;
//     $user_email_2 = (get_userdata($user_2))->user_email;
//     //endregion get users

//     //region set post data
//     $data = http_build_query([
//         'requester' => $user_email_1,
//         'responder' => $user_email_2,
//     ]);
//     //endregion set post data

//     //region call api
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/remove_friend');
//     curl_setopt($curl, CURLOPT_POST, 1);
//     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($curl);
//     curl_close($curl);
//     //endregion call api
// }

// add_action('profile_update', 'vyndue_user_update', 10, 2);
// function vyndue_user_update($user_id, $old_user_data)
// {
//     //region get users
//     $user = get_userdata($user_id);
//     //endregion get users

//     //region data validation
//     $update = [
//         'email_id' => $old_user_data->user_email,
//         'first_name' => $user->first_name,
//         'last_name' => $user->last_name,
//     ];

//     if ($user->user_email !== $old_user_data->user_email) {
//         $update['email'] = $user->user_email;
//     }
//     //endregion data validation

//     //region set post data
//     $data = http_build_query($update);
//     //endregion set post data
    
//     //region call api
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/update');
//     curl_setopt($curl, CURLOPT_POST, 1);
//     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($curl);
//     curl_close($curl);
//     //endregion call api
// }

// add_action('um_change_password_process_hook', 'vyndue_password_update', 10, 2);
// function vyndue_password_update($post)
// {
//     $user_id = get_current_user_id();
//     $user = get_userdata($user_id);

//     $data = http_build_query([
//         'email_id' => $user->user_email,
//         'password' => $_POST['user_password'],
//     ]);

//     //region call api
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, 'https://vyndue.com/api/user/update');
//     curl_setopt($curl, CURLOPT_POST, 1);
//     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($curl);
//     curl_close($curl);
//     //endregion call api
// }