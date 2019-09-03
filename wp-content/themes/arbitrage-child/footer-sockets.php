<?php

$user_id = get_current_user_id();
// function is_user_logged_in() {
//     $user_id = get_current_user_id();
if ($user_id !== 0) {
    $uuid = get_user_meta($user_id, 'user_uuid', true);
    $secret = get_user_meta($user_id, 'user_secret', true);
    // var_dump($secret);
?>
<script>
    // the element you want to observe. change the selector to fit your use case
    var img = document.querySelector('.um-profile-photo-img img')

    if (img) {
        // ensures this works for some older browsers
        MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

        new MutationObserver(function onSrcChange(){
            jQuery.ajax({
                url: 'https://vyndue.com/api/user/update_avatar',
                method: 'POST',
                data: {
                    user_secret: '<?php echo $secret ?>',
                    avatar_url: jQuery('.um-profile-photo-img img').attr('src'),
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {

                    }
                },
            });
        })
        .observe(img,{attributes:true,attributeFilter:["src"]})
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
<script>
    var io = io('https://socket.vyndue.com');
    
    io.on('connect', function (socket) {
        io.emit('arbitrage:connect', {user: "<?php echo $secret ?>"})
    })

    io.on('arbitrage:logout', function (data) {
        if (data.user_secret == '<?php echo $secret ?>') {
            location.href = '<?php echo get_home_url() ?>'
        }
    })

    //region Friends
    io.on('arbitrage:friend_request', function (data) {
        // if (data.approver.id == '') {
        //     jQuery.toast(`${data.requester.full_name} has requested to add you as a friend.`)
        // }
    });

    io.on('arbitrage:friend_approval', function (data) {
        // if (data.approver.id == '') {
        //     jQuery.toast(`${data.requester.full_name} are now friends.`)
        // } else if (data.requester.id == '') {
        //     jQuery.toast(`${data.approver.full_name} has accepted your friend request.`)
        // }
    });
    //endregion Friends

    //region Vyndue
    io.on("arbitrage:mention", function (data) {
        // jQuery.toast(`Mentioned by ${data.sender}`)
    });

    io.on('arbitrage:new_message', function (data) {
        // jQuery.toast(`${data.sender} has sent a message`)
        updateVyndueNotifications(parseInt(getVyndueNotifications()) + 1)
    })
    //endregion Vyndue

    //region Posts
    io.on('arbitrage:bull_post', function (data) {
        updatePostActivity(data, data.bull_count, 'bullish')
    })

    io.on('arbitrage:bear_post', function (data) {
        updatePostActivity(data, data.bear_count, 'bearish')
    })

    io.on('arbitrage:post_comment', function (data) {
        if (data.poster_id == '') {
            // jQuery.toast({
            //     text: `${data.commenter.full_name} has commented on your post`,
            //     onClick: function () {
            //         window.location.href = data.link
            //     },
            // })
        }
    })
    //endregion Posts

    io.on('notifyMentionUser', function (data) {
        
    })


    function updatePostActivity(data, $count, $type) {
        var $post = jQuery('#postid-' + data.post_id)
        
        $post.find('.um-activity-' + $type + ' .dnumof')
            .text($count)

        if (data.poster_id == '<?php echo $user_id ?>' &&
            data.action_user_id != '<?php echo $user_id ?>') {
            var count_up = data.count_up ? '' : 'un';

            // only show toast if upvote
            if (data.count_up) {
                // jQuery.toast(`${data.action_user_name} ${count_up}${$type}ed your post.`)
            }
        }
    }
</script>
<?php
}
?>