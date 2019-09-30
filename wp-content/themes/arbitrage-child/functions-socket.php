<?php

require_once ABSPATH . 'vendor/autoload.php';

use Predis\Client;
use Goez\SocketIO\Emitter;

$client = new Client();
$emitter = new Emitter($client);

//region User
add_action('wp_logout', function () use ($emitter) {
    $user_id = get_current_user_id();
    $secret = get_user_meta($user_id, 'user_secret', true);
    $emitter->emit('arbitrage:logout', ['user_secret' => $secret]);
});

add_action('init', function () use ($emitter) {
    if (isset($_GET)) {
        if (isset($_GET['action']) && $_GET['action'] == 'logout') {
            $user_id = get_current_user_id();
            
            if ($user_id) {
                $secret = get_user_meta($user_id, 'user_secret', true);
                $emitter->emit('arbitrage:logout', ['user_secret' => $secret]);
            }
        }
    }
});
//endregion User

//region Posts
//region Wall Post

//endregion Wall Post

//region Wall Comment
add_action('wall_comment_socket', function ($data) use ($emitter) {
    $emitter->emit('arbitrage:post_comment', $data);
});
//endregion Wall Comment

//region Post Bullish
add_action('um_activity_after_wall_post_bulled_socket', function ($data) use ($emitter) {
    $emitter->emit('arbitrage:bull_post', $data);
});

add_action('um_activity_after_wall_post_unbulled_socket', function ($data) use ($emitter) {
    $emitter->emit('arbitrage:bull_post', $data);
});
//endregion Post Bullish

//region Post Bearish
add_action('um_activity_after_wall_post_beared_socket', function ($data) use ($emitter) {
    $emitter->emit('arbitrage:bear_post', $data);
});

add_action('um_activity_after_wall_post_unbeared_socket', function ($data) use ($emitter) {
    $emitter->emit('arbitrage:bear_post', $data);
});
//endregion Post Bearish
//endregion Posts

//region Friends
// friend request
add_action('um_friends_after_user_friend_request_socket', function ($data) use ($emitter) {
    $emitter->emit('arbitrage:friend_request', $data);
});

// friend approval
add_action('um_friends_after_user_friend_socket', function ($data) use ($emitter) {
    $emitter->emit('arbitrage:friend_approval', $data);
});
//endregion Friends
