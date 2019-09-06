<?php

add_action('arbitrage_um_activity_after_wall_post_published', 'arbitrage_social_post_api_create');
add_action('arbitrage_um_activity_after_wall_post_updated', 'arbitrage_social_post_api_create');
/**
 * Creates or updates a post in social api
 */
function arbitrage_social_post_api_create($data) {
    extract($data);
    $user_id = get_current_user_id();
    $wall_id = $user_id == $wall_id ? 0 : arbitrage_api_get_user_uuid($wall_id);
    $account_user_id = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);

    $data = [
        'wall_id' => $wall_id,
        'wall_type' => ($wall_id === 0 ? '' : 'user'),
        'user_id' => $account_user_id,
        'content' => $_POST['_post_content'],
        'visibility' => 'public',
        'status' => 'active',
    ];

    $url = 'api/social/posts' . ($social_post_id ? "/$social_post_id/update" : '');

    $response = arbitrage_api_curl($url, $data);

    if ($response && !$social_post_id) {
        $social_post_id = $response['post']['id'];
        add_post_meta($post_id, 'social_api_post_id', $social_post_id, true);
    }
    
    // check if has a photo
    $gcs_url = get_post_meta($post_id, '_photo_gcs_url', true);
    if ($gcs_url) {
        arbitrage_api_curl("api/social/posts/$social_post_id/attachments", [
            'user_id' => $account_user_id,
            'url' => $gcs_url,
        ]);
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
add_action('wp_insert_comment', function ($comment_id) {
    $user_id = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $comment = get_comment($comment_id);

    $social_post_id = get_post_meta($comment->comment_post_ID, 'social_api_post_id', true);

    $comment_parent = $comment->comment_parent;

    if ($comment_parent) {
        $comment_parent = get_comment_meta($comment_parent, 'social_api_comment_id', true);
    }

    $data = [
        'parent_id' => $comment_parent,
        'user_id' => $user_uuid,
        'content' => $comment->comment_content,
    ];

    $url = "api/social/posts/$social_post_id/comments";

    $response = arbitrage_api_curl($url, $data);

    if ($response) {
        add_comment_meta($comment_id, 'social_api_comment_id', $response['comment']['id'], true);
    }
});

/**
 * Update a comment in social api
 */
add_action('edit_comment', function ($comment_id, $comment_data) {
    $user_id = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $comment = get_comment($comment_id);

    $social_post_id = get_post_meta($comment->comment_post_ID, 'social_api_post_id', true);

    $social_comment_id = get_comment_meta($comment_id, 'social_api_comment_id', true);

    $data = [
        'user_id' => $user_uuid,
        'content' => $comment->comment_content,
    ];

    $url = "api/social/posts/$social_post_id/comments/$social_comment_id/update";

    $response = arbitrage_api_curl($url, $data);
});

/**
 * Delete a comment in social api
 */
add_action('delete_comment', function ($comment_id, $comment) {
    $user_id = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $comment = get_comment($comment_id);

    $social_post_id = get_post_meta($comment->comment_post_ID, 'social_api_post_id', true);
    $social_comment_id = get_comment_meta($comment_id, 'social_api_comment_id', true);

    $data = [
        "user_id" => $user_uuid,
    ];

    $url = "api/social/posts/$social_post_id/comments/$social_comment_id/delete";

    $response = arbitrage_api_curl($url, $data);
});

/**
 * Bull a post in social api
 */
add_action('um_activity_after_wall_post_bulled', function ($post_id, $user_id) {
    $user_id = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);

    $data = [
        'user_id' => $user_uuid,
    ];

    $url = "api/social/posts/$social_post_id/bull";

    arbitrage_api_curl($url, $data);
});

/**
 * Unbull a post in social api
 */
add_action('um_activity_after_wall_post_unbulled', function ($post_id, $user_id) {
    $user_id = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);

    $data = [
        'user_id' => $user_uuid,
    ];

    $url = "api/social/posts/$social_post_id/unbull";

    arbitrage_api_curl($url, $data);
});

/**
 * Bear a post in social api
 */
add_action('um_activity_after_wall_post_beared', function ($post_id, $user_id) {
    $user_id = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);

    $data = [
        'user_id' => $user_uuid,
    ];

    $url = "api/social/posts/$social_post_id/bear";

    arbitrage_api_curl($url, $data);
});

/**
 * Unbear a post in social api
 */
add_action('um_activity_after_wall_post_unbeared', function ($post_id, $user_id) {
    $user_id = get_current_user_id();
    $user_uuid = arbitrage_api_get_user_uuid($user_id);
    $social_post_id = get_post_meta($post_id, 'social_api_post_id', true);

    $data = [
        'user_id' => $user_uuid,
    ];

    $url = "api/social/posts/$social_post_id/unbear";

    arbitrage_api_curl($url, $data);
});