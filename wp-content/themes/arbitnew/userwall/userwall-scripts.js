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

        if (window.matchMedia('(max-width: 767px)').matches) {
            $('.right-header-inner').css('margin-right','25px');
        }

        $('.logo-image').on('click', function(){
            $('.left-dashboard-part').css('left','0');
             $('.swipecenter-area-r').css('display','block');
        });

        $('.swipecenter-area-r').on('click touchstart', function(){

            if($('.left-dashboard-part').css('left') == '0px'){
                $('.left-dashboard-part').css('left','-100%');
                $('.swipecenter-area-r').css('display','none');
            }else {
                jQuery('.right-dashboard-part').css("right","-110%");
                $('.swipecenter-area-r').css('display','none');
            }

        });

            $(".center-dashboard-part").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {
                      if (phase=="move" && direction =="right") {
                           $('.left-dashboard-part').css('left','0');
                           $('.swipecenter-area-r').css('display','block');
                           $('.right-image').find('.close-leftsidebar').css('display','block');
                           return false;
                      }

                      if (phase=="move" && direction =="left") {
                            jQuery('.right-dashboard-part').css("display","block");
                            jQuery('.right-dashboard-part').css("right","0%");
                            $('.swipecenter-area-r').css('display','block');
                            //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/cancel.svg');
                            $('#right-slider-icon').attr('width','15px');
                            $('#right-menu').removeClass();
                           
                           return false;
                      }
                      
                  }
            });

             $(".swipeleft-area-l").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {
                      
                      if (phase=="move" && direction =="left") {
                          $('.left-dashboard-part').css('left','-100%');
                          $('.swipecenter-area-r').css('display','none');
                          $('.right-image').find('.close-leftsidebar').css('display','none');
                           return false;
                      }
                  }
            });

             $(".left-dashboard-part").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {
                      
                      if (phase=="move" && direction =="left") {
                          $('.left-dashboard-part').css('left','-100%');
                          $('.swipecenter-area-r').css('display','none');
                          $('.right-image').find('.close-leftsidebar').css('display','none');
                           return false;
                      }
                  }
            });

            $(".swiperight-area-r").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {         
                      if (phase=="move" && direction =="right") {
                            jQuery('.right-dashboard-part').css("right","-110%");
                            $('.swipecenter-area-r').css('display','none');
                            //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/menu.svg');
                            $('#right-slider-icon').attr('width','20px');
                            $('#right-menu').addClass('right-slider-menu1');     
                           return false;
                      }
                  }
            });

            $(".swiperight-area-r2").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {         
                      if (phase=="move" && direction =="right") {
                            jQuery('.right-dashboard-part').css("right","-110%");
                            $('.swipecenter-area-r').css('display','none');
                            $('#right-slider-icon').attr('width','20px');
                            $('#right-menu').addClass('right-slider-menu1');     
                           return false;
                      }
                  }
            });

            $(".right-dashboard-part").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {         
                      if (phase=="move" && direction =="right") {
                            jQuery('.right-dashboard-part').css("right","-110%");
                            $('.swipecenter-area-r').css('display','none');
                            //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/menu.svg');
                            $('#right-slider-icon').attr('width','20px');
                            $('#right-menu').addClass('right-slider-menu1');     
                           return false;
                      }
                  }
            });

             $(".swipecenterl").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {

                      if (phase=="move" && direction =="left") {
                            jQuery('.right-dashboard-part').css("display","block");
                            jQuery('.right-dashboard-part').css("right","0%");
                            $('.swipecenter-area-r').css('display','block');
                            //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/cancel.svg');
                            $('#right-slider-icon').attr('width','15px');
                            $('#right-menu').removeClass();
                           
                           return false;
                      }
                      
                  }
            });
            $(".swipecenterr").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {

                      if (phase=="move" && direction =="right") {
                             $('.left-dashboard-part').css('left','0');
                             $('.swipecenter-area-r').css('display','block');
                             $('.right-image').find('.close-leftsidebar').css('display','block');  
                             return false;
                      }
                      
                  }
            });


    });

})(jQuery);