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

    $url = 'api/social/posts' . ($social_post_id ? "/$social_post_id/update" : '');

    $response = arbitrage_api_curl($url, $data);

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

        $response = arbitrage_api_curl("api/social/posts/$social_post_id/delete", $data);
    }
});

/**
 * Create a comment in social api
 */
add_action('um_activity_after_wall_comment_published', function ($comment_id, $comment_parent, $post_id, $user_id) {
    $user = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);
    $comment = get_comment_text($comment_id);
    $social_comment_id = get_comment_meta($comment_id, 'social_api_comment_id', true);

    if ($comment_parent != 0) {
        $comment_parent = get_comment_meta($comment_parent, 'social_api_comment_id', true);
    }

    $data = [
        'post_id' => $social_post_id,
        'parent_id' => $comment_parent,
        'user_id' => $user_uuid,
        'content' => $comment,
    ];

    // check if this is an already existing comment in Social API
    // if yes, update 
    $url = "api/social/posts/$social_post_id/comments" . ($social_comment_id ? "/$social_comment_id/update" : "");

    $response = arbitrage_api_curl($url, $data);

    if ($response) {
        add_comment_meta($comment_id, 'social_api_comment_id', $response['comment']['id'], true);
    }
});