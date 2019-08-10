<?php

// delete profile photo
add_action('um_after_remove_profile_photo', function ($user_id) {
    $user_uuid = arbitrage_api_get_user_uuid($user_id);

    $data = [
        'id' => $user_uuid,
        'profile_image' => null,
    ];

    $response = arbitrage_api_curl('api/users/update', $data);
});