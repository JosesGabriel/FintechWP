<?php

// add_action('um_activity_after_wall_comment_published', function ($comment_id, $comment_parent, $post_id, $user_id) {
add_action('um_activity_after_wall_comment_published_socket', function ($data) {

    $commenter = [
        'id' => $data['commenter_id'],
        'full_name' => ucwords(get_user_meta($data['commenter_id'], 'full_name', true)),
    ];

    $poster_id = (int) get_post_meta($data['post_id'], '_user_id', true);

    $link = get_site_url() . '/?' . parse_url($data['link'], PHP_URL_QUERY);

    do_action('wall_comment_socket', [
        'commenter' => $commenter,
        'poster_id' => $poster_id,
        'link' => $link,
    ]);

}, 10, 2);