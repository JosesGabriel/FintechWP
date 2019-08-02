<?php

add_action('um_activity_after_wall_post_published', 'arbitrage_social_post_api_create');
add_action('um_activity_after_wall_post_updated', 'arbitrage_social_post_api_create');
/**
 * Creates or updates a post in social api
 */
function arbitrage_social_post_api_create($post_id, $user_id, $wall_id) {
    $user_id = get_current_user_id();
    $account_user_id = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);

    $data = [
        'wall_id' => 0,
        'user_id' => $account_user_id,
        'content' => $_POST['_post_content'],
        'visibility' => 'public',
        'status' => 'active',
    ];

    $url = 'api/social/posts' . ($social_post_id ? '/' . $social_post_id : '');
    $method = $social_post_id ? 'PUT' : 'POST';

    $response = arbitrage_api_curl($url, $data, $method);

    if ($response && !$social_post_id) {
        add_post_meta($post_id, 'social_api_post_id', $response['post']['id'], true);
    }
}

/**
 * Deletes a post in social api
 */
add_action('before_delete_post', function ($post_id) {
    $user_id = get_post_field('post_author', $post_id);
    $uuid = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);

    if ($social_post_id) {

        $data = [
            'user_id' => $uuid,
        ];

        $response = arbitrage_api_curl("api/social/posts/$social_post_id", $data);
    }
});