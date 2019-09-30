<?php
    $user = wp_get_current_user();
    $cdnorlocal = get_home_url();
?>
<header id="main-header" class="dashboard-header">
    <div class="header-dashboard">
        <div class="header-dashboard-inner">
            <div class="left-header-part">
                <div class="left-header-inner">
                    <div class="logo-image">
                        <a href="/"><img src="/wp-content/themes/arbitrage-child/images/arblogo_svg1.svg" style="width: 33px;"></a>
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
                                    jQuery(".inner-seatch input[type='text']").val("<?php if (!$search_term){ echo "Search"; } else { echo $search_term; } ?>");
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
                                <a href="/vyndue/"><img src="<?php echo $cdnorlocal; ?>/svg/vyndue-newlogo-white.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top:3px"></a>
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
                            <li><a href="/user/<?php echo um_user('user_login') ?>/?profiletab=main&amp;um_action=edit" class="real_url">Edit Profile</a></li>
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
</header>
<!-- #main-header -->
