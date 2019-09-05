<?php
$user = wp_get_current_user();
$cdnorlocal = get_home_url();
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.um-icon-android-close').addClass('fas fa-times');
        jQuery('.um-icon-android-close').removeClass('um-icon-android-close');
    });
</script>
<header id="main-header" class="dashboard-header">
    <div class="header-dashboard">
        <div class="header-dashboard-inner">
            <div class="left-header-part">
                <div class="left-header-inner">
                    <div class="logo-image">
                        <a href="/"><img src="https://storage.arbitrage.ph/dev/2019/04/arb_fav_bigger.png"></a>
                    </div>
                    <div class="searchbar">
                        <div class="inner-seatch">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <?php
                                $search_term = get_search_query();
                                echo do_shortcode("[et_pb_search admin_label='Search Arbitrage...' background_layout='light' text_orientation='left' exclude_pages='off' exclude_posts='off' hide_button='off' /]");
                             ?>

                            <script>
                                jQuery(document).ready(function(e) {
                                    jQuery(".inner-seatch input[type='text']").val("     <?php if (!$search_term){ echo "Search"; } else { echo $search_term; } ?>");
                                    jQuery(".inner-seatch input[type='text']").click(function(s){
                                        s.preventDefault();
                                        jQuery(".inner-seatch input[type='text']").val("");
                                        jQuery(".searchbar").animate({
                                            width: "75%"
                                        },500);
                                        jQuery("i.fa.fa-search").animate({
											right: "8px",
                                        },500);
                                    });

                                    jQuery(".inner-seatch input[type='text']").blur(function(){
                                        jQuery(".searchbar").animate({
                                            width: "180px"
                                        },500);
                                        jQuery("i.fa.fa-search").animate({
                                            right: "88%"
                                        },500, function(){
                                            jQuery(".inner-seatch input[type='text']").val("     Search");
                                        });
                                    });

                                });
                            </script>
							
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-header-part">
                <div class="right-header-inner">
                    <!-- <div class="optsdropdown">

                    </div> -->

                    <ul class="main-drops">
                        <div class="main-user-name" id="main-user-name">
                             <div class="ontotools">
                                <a><img src="<?php $cdnorlocal ?>/svg/menu.svg" style="width: 17px;display: inline-block;vertical-align: top;margin-top: 4px;"></a>
                            </div>
                        </div>
                        <ul id="droppouts" style="box-shadow: 0px 2px 4px 1px rgba(7, 13, 19, 0.52);">
                            <li><a href="#">Buy/Sell Calculator</a></li>
                            <li><a href="#">VAR Calculator</a></li>
                            <li><a href="#">Average Price Calculator</a></li>
                            <li><a href="<?php echo get_home_url(); ?>/multicharts/">Multichart</a></li>
                        </ul>
                    </ul>

                    <div class="ontomitif">
                        <div class="um-notification-b right" data-show-always="1">
                            <img src="<?php $cdnorlocal ?>/svg/bell.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 3px;">
                            <span class="um-notification-live-count count-0 counter" style="display: none !important;">0</span>
                            <span class="um-notification-live-count count-0 countx_max" style="display: none;"></span>
                        </div>
                    </div>
					
                    <div class="dmessagepart" <?php if(is_page(2457)){ ?>style="padding-right:0;"<?php } ?>>
                    	<?php if(!is_page(2457)){ ?>
                            <div class="dmessagepart-wrap" data-show-always="1">
                                <a href="https://arbitrage.ph/vyndue/"><img src="<?php echo $cdnorlocal; ?>/svg/vyndue-newlogo-white.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top:3px"></a>
                                <span class="vyndue-notification" style="display: none;">0</span>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <ul class="main-drop">
                        <div class="main-user-name" id="main-user-name">
                            <div class="header-image">
                                <div class="user-image" style="background: url('<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>') no-repeat center center;">&nbsp;</div>
                            </div>
                            
                        </div>
                        <ul id="droppouts" style="">
                            <li><a href="https://arbitrage.ph/user/<?php echo um_user('user_login') ?>/?profiletab=main&amp;um_action=edit" class="real_url">Edit Profile</a></li>
                            <li><a href="<?php echo get_home_url(); ?>/user/">My Account</a></li>
                            <hr class="style14 style15">
                            <li class="onto-last-element"><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
                        </ul>
                        
                    </ul>
        
                     <div class="right-slider-menu" >
                        <img id="right-slider-icon" src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/images/menu.svg" width="22px">
                    </div>
                    <div id="right-menu" class="right-slider-menu1"></div>

                    <div class="opennotification">
                        <div class="notifinnerbase">
                        </div>
                    </div>

                   

                </div>
            </div>
            <br class="clear">
        </div>
        <div class="border-colored"></div>
    </div>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script type="text/javascript">
            jQuery("ul.main-drop .main-user-name").click(function(e){
                event.stopPropagation();
                var isopen = jQuery("ul.main-drop > ul").hasClass("dropopen");

                if (isopen) {
                    jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
                } else {
                    jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
                    jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
                    jQuery("ul.main-drop > ul").show().addClass("dropopen");
                }

            });

            jQuery("ul.main-drops .main-user-name").click(function(e){
                event.stopPropagation();
                var isopen = jQuery("ul.main-drops > ul").hasClass("dropopen");

                if (isopen) {
                    jQuery("ul.main-drops > ul").hide().removeClass("dropopen");

                } else {
                    jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
                    jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
                    jQuery("ul.main-drops > ul").show().addClass("dropopen");
                }

            });

            jQuery(".ontomitif").click(function(e){
                event.stopPropagation();
                var isopen = jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hasClass("dropopen");
                if (isopen) {
                    jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
                } else {
                    jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
                    jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
                    jQuery(".opennotification .notifinnerbase").empty();
                    jQuery(".um-notification-live-feed").clone().appendTo(".opennotification .notifinnerbase");
                    jQuery(".opennotification .notifinnerbase .um-notification-live-feed").show().addClass("dropopen");
                    
                    jQuery(".um-notification span.b2 .um-faicon-thumbs-up").append('<img src="https://arbitrage.ph/assets/svg/ico_bullish_no_ring_notification.svg">');
                    jQuery(".um-notification span.b2 .um-faicon-thumbs-up").removeClass();
                    jQuery(".um-notification span.b2 .um-faicon-thumbs-up").empty();

                    jQuery(".um-notification span.b2 .um-faicon-thumbs-down").append('<img src="https://arbitrage.ph/assets/svg/ico_bearish_no_ring_notification.svg">');
                    jQuery(".um-notification span.b2 .um-faicon-thumbs-down").removeClass();
                    jQuery(".um-notification span.b2 .um-faicon-thumbs-down").empty();
            }
                //
                // var dnotifs =
                // $(".notifinnerbase").append('');

            });


        jQuery(document).on("click", function () {
            jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
            jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
            jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
        });

        jQuery(document).ready(function(){
            jQuery(".seven.calc-menu-buysell, ul.main-drops > ul li:first-child").on("click", function () {
                event.stopPropagation();
                 var openthis = jQuery("#showplease").hasClass("dropthiss");
                 if ( openthis ) {
                     jQuery("#toghandle").hide().removeClass("dropthiss");
                } else {
                jQuery("#toghandle").show().addClass("dropthiss");
                }
            });
            jQuery(".seven.calc-menu-var, ul.main-drops > ul li:nth-child(2)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlings").show().addClass("dropthiss");

            });
            jQuery(".seven.calc-menu-avprice, ul.main-drops > ul li:nth-child(3)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlingers").show().addClass("dropthiss");
            });
        });
        jQuery(document).ready(function(){
            // jQuery("#toghandle").on('click', function(){
            //     jQuery("#toghandle").hide().removeClass("dropthiss");
            // });
            // jQuery("#toghandlings").on('click', function(){
            //     jQuery("#toghandlings").hide().removeClass("dropthiss");
            // });

            jQuery(".toclassclose").on('click', function(){
                jQuery("#toghandle").hide().removeClass("dropthiss");
            });
            jQuery(".toclassclosess").on('click', function(){
                jQuery("#toghandlings").hide().removeClass("dropthiss");
            });
            jQuery(".toclasscloserss").on('click', function(){
                jQuery("#toghandlingers").hide().removeClass("dropthiss");
            });
        });
        jQuery("body").on('DOMSubtreeModified', ".um-notification-live-count.counter", function(event) {
                
                var counter = parseInt($(event.target));
                jQuery(".um-notification-live-count.counter").empty();
                // $(".um-notification-live-count.countx_max").empty();
                if (counter >= 9){
                    jQuery('.um-notification-live-count.countx_max').html("9+");
                }
                // var counter = count = $(".um-notification-live-count.counter").empty();
                // console.log('pre if', counter, count, event.target)
                // var numbercount = '10';
                // var count = counter;
                
                // console.log('after', count);
                
                
            });
    </script>
</header>
<!-- #main-header -->
