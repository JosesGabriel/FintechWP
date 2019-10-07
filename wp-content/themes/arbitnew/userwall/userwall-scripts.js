(function ($) {
    
    $(document).ready(function () {
        $.ajax({
            url: '/apipge/?daction=user-posts-count&user-id=<?php echo $profile_id ?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                let count = 0;
                if (response.success) {
                    count = response.data.posts_count;
                }
                $('.profile_post_count').html(count);
            }
        })

        $.ajax({
            url: '/apipge/?daction=user-peers-count&user-id=<?php echo $profile_id ?>',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                let html = '<span class="um-ajax-count-friends">0</span>';
                if (response.success) {
                    html = response.data.peers_count;
                }
                $('.profile_peers_count').html(html)
            }
        })
    });

})(jQuery);