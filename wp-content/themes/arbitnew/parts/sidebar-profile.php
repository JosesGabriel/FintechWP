<?php

global $current_user;
$userid = get_current_user_id();
$unametype = get_user_meta($userid, 'disname', true);
$profile_id = um_profile_id();
$friendstotal1 = UM()->Friends_API()->api()->count_friends( $profile_id );
$friendstotal = (int) preg_replace('/[^0-9]/', '', $friendstotal1);
$coverhphotoactive = um_profile( 'cover_photo' );
$profilepicactive = um_profile( 'profile_photo' );
$login_username = um_user('um_user_profile_url_slug_user_login');
$display_username = filter_var($login_username, FILTER_VALIDATE_EMAIL) ? '' : "@$login_username";

if ($coverhphotoactive && $profilepicactive && $friendstotal >= 3){
  $num = 100;
}else if((!$coverhphotoactive && $profilepicactive && $friendstotal >= 3) || ($coverhphotoactive && !$profilepicactive && $friendstotal >= 3) || ($coverhphotoactive && $profilepicactive && $friendstotal < 3)){
  $num = 66;
}else if((!$coverhphotoactive && !$profilepicactive && $friendstotal >= 3) || ($coverhphotoactive && !$profilepicactive && $friendstotal < 3)|| (!$coverhphotoactive && $profilepicactive && $friendstotal < 3)){
  $num = 33;
}else{
  $num = 0;
}
?>
<div class="left-user-details">
  <div class="left-user-details-inner">
      <div class="side-header">
          <div class="left-image">
              <a href="/user/"><div class="user-image" style="background: url('<?php echo esc_url( get_avatar_url( $userid ) ); ?>') no-repeat center center;width: 29px;height: 29px;">&nbsp;</div>
              </a>
          </div>
          <div class="right-image">
              <div class="onto-user-name">
                  <a href="/user" style="color:#fff;"><span><?php echo um_user( 'first_name' ) . " " . um_user( 'last_name' ); ?></span></a>
                  <div class="arb_smalltxt"><?php echo $display_username; ?></div>
              </div>
              <div class="close-leftsidebar">
              </div>
          </div>
      </div>
      <div class="side-content">
          <div class="side-content-inner sidebariconssocial">
              <ul class="sidebariconssocial-child">
				  <li class="one" style="margin-top: 3px;"><a href="/"><img src="/svg/layout-2.svg">	<span>Social Wall</span></a></li>
                  <li class="twos"><a href="/chart/"><img src="/svg/bar-chart-2.svg">
					  <span>Interactive Chart</span></a></li>
                  <li class="three"><a href="/journal/"><img src="/svg/edit1-2.svg">
					  <span>Trading Journal</span></a></li>
                  <li class="four"><a href="/watchlist/"><img src="/svg/binoculars5-2.svg">
					  <span>Watcher & Alerts</span></a></li>
                  <li class="seven"><a href="/game/"><img src="/svg/play-station-4.svg" class="icon-game">
            <span>Games</span></a></li>
                  <li class="five"><a id="vyndue--link" class="vyndueverify" href="https://vyndue.com/#/login" target="_blank" rel="noopener noreferrer"><img src="/svg/vyndue-newlogo1-1.svg">
            <span>Vyndue</span></a></li>

            <div class="m-separator"></div>
            <span class="menu-title-calc">Power Tools</span>
                  <li class="seven calc-menu-buysell"><a><img src="/svg/BuySellCalculators-3.svg">
            <span>Buy/Sell Calculators</span></a></li>
                  <li class="seven calc-menu-var"><a><img src="/svg/think-3.svg">
            <span>VAR Calculator</span></a></li>
                  <li class="seven calc-menu-avprice"><a><img src="/svg/AveragePriceCalculator1-3.svg">
            <span>Average Price Calculator</span></a></li>
              </ul>
          </div>
      </div>
  </div>
</div>



<script type="text/javascript">

  jQuery(document).ready(function(){
        if(jQuery('.um-profile').hasClass('topbannerprofile')){
          jQuery('.side-completenessbox').css("display","none");
        }else{
          jQuery('.side-completenessbox').css("display","block");
        }

        jQuery('.info-circle').click(function(){
          if($('.todos_box').css('display') == 'none'){
              jQuery('.todos_box').slideDown();
          }else {
              jQuery('.todos_box').slideUp();
          }
        });
    });

  jQuery(document).ready(function(){
    var pageURL = jQuery(location).attr("href");
    if(pageURL == '<?php echo get_home_url(); ?>/'){
      jQuery('.side-content ul .one').addClass('active');
    }else if(pageURL == '<?php echo get_home_url(); ?>/chart/'){
      jQuery('.side-content ul .twos').addClass('active');
    }else if(pageURL == '<?php echo get_home_url(); ?>/journal/'){
      jQuery('.side-content ul .three').addClass('active');
    }else if(pageURL == '<?php echo get_home_url(); ?>/watchlist/'){
      jQuery('.side-content ul .four').addClass('active');
    }else if(pageURL == '<?php echo get_home_url(); ?>/vyndue/'){
      jQuery('.side-content ul .five').addClass('active');
    }else if(pageURL == '<?php echo get_home_url(); ?>/tools/'){
      jQuery('.side-content ul .six').addClass('active');
    }else if(pageURL == '<?php echo get_home_url(); ?>/game/'){
      jQuery('.side-content ul .seven').addClass('active');
    }

  });
</script>


