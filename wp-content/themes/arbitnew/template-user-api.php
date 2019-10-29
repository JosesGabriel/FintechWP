<?php
/**
 * Template Name: User API
 */

function generateUUIDV4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

$user = wp_get_current_user();

//region Existence check
if (!$user->ID) {
    echo json_encode([
        'message' => 'Unauthorized access',
        'status' => 403,
        'success' => false,
    ]);
}
//endregion Existence check

global $wpdb;

$uuid = get_user_meta($user->ID, 'user_uuid', true);

if ($uuid == '') {
    $uuid = generateUUIDV4();

    update_user_meta($user->ID, 'user_uuid', $uuid);
}

$data = [
    'uuid' => $uuid,
    'name' => $user->display_name,
    'avatar' => "https://arbitrage.ph/wp-content/uploads/ultimatemember/$user->ID/profile_photo-80x80.jpg"
];

echo json_encode([
    'data' => [
        'user' => $data,
    ],
    'message' => 'Successfully fetch current user.',
    'status' => 200,
    'success' => true,
]);