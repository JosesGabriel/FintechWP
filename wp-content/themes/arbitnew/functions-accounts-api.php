<?php

// update profile or cover after resize
add_filter('um_ajax_resize_image', function ($output) {
    extract( $_REQUEST );

    if (in_array($key, ['profile_photo','cover_photo'])) {

        $response = arbitrage_api_upload_to_gcs($output['image']['source_path']);

        if ($response) {
            $user_uuid = arbitrage_api_get_user_uuid( get_current_user_id() );
            $key = (explode('_', $key))[0] . '_image';

            $data = [
                $key => $response['file']['url'],
            ];
    
            arbitrage_api_curl_multipart("api/users/$user_uuid/update", $data);
        }
    }

    return $output;
});

// delete profile photo
add_action('um_after_remove_profile_photo', function ($user_id) {
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $response = arbitrage_api_curl("api/users/$user_uuid/profile_image/delete", $data);
}, 10, 1);

// delete cover photo
add_action('um_after_remove_cover_photo', function ($user_id) {
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $response = arbitrage_api_curl("api/users/$user_uuid/cover_image/delete", $data);
}, 10, 1);