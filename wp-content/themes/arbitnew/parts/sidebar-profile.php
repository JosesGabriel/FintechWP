<?php

	global $current_user;
	// $user = wp_get_current_user();
    $userid = get_current_user_id();

  $unametype = get_user_meta($userid, 'disname', true);

  // echo $unametype;
  // $name = ($unametype == "" || $unametype == 'rn' ? um_user('first_name') . " " . um_user('last_name') : "" );


$profile_id = um_profile_id();

 $friendstotal1 = UM()->Friends_API()->api()->count_friends( $profile_id );
//$friendreqs = UM()->Friends_API()->api()->friend_reqs_sent( $profile_id );

$friendstotal = (int) preg_replace('/[^0-9]/', '', $friendstotal1);
$coverhphotoactive = um_profile( 'cover_photo' );
$profilepicactive = um_profile( 'profile_photo' );




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
              <a href="<?php echo get_home_url(); ?>/user/"><div class="user-image" style="background: url('<?php echo esc_url( get_avatar_url( $userid ) ); ?>') no-repeat center center;width: 29px;height: 29px;">&nbsp;</div>
              </a>
          </div>
          <div class="right-image">

                  <div class="onto-user-name">
                      <a href="<?php echo get_home_url(); ?>/user" style="color:#fff;"><span><?php echo um_user( 'first_name' ) . " " . um_user( 'last_name' ); ?></span></a>
                      <div class="arb_smalltxt">@<?php echo um_user('nickname'); ?></div>
                  </div>

          </div>
      </div>
      <div class="side-content">
          <div class="side-content-inner sidebariconssocial">
              <ul class="sidebariconssocial-child">
				  <li class="one" style="margin-top: 3px;"><a href="<?php echo get_home_url(); ?>/"><img src="<?php echo get_home_url(); ?>/svg/layout-2.svg">	<span>Social Wall</span></a></li>
                  <li class="twos"><a href="/chart/"><img src="<?php echo get_home_url(); ?>/svg/bar-chart-2.svg">
					  <span>Interactive Chart</span></a></li>
                  <li class="three"><a href="/journal/"><img src="<?php echo get_home_url(); ?>/svg/edit1-2.svg">
					  <span>Trading Journal</span></a></li>
                  <li class="four"><a href="/watchlist/"><img src="<?php echo get_home_url(); ?>/svg/binoculars5-2.svg">
					  <span>Watcher & Alerts</span></a></li>
                  <li class="seven"><a href="<?php echo get_home_url(); ?>/game/"><img src="<?php echo get_home_url(); ?>/svg/play-station-4.svg" class="icon-game">
            <span>Games</span></a></li>
                  <li class="five"><a id="vyndue--link" href="https://vyndue.com/userview/im"><img src="<?php echo get_home_url(); ?>/svg/vyndue-newlogo1-1.svg">
            <span>Vyndue</span></a></li>

            <div class="m-separator"></div>
            <span class="menu-title-calc">Power Tools</span>
                  <li class="seven calc-menu-buysell"><a><img src="<?php echo get_home_url(); ?>/svg/BuySellCalculators-3.svg">
            <span>Buy/Sell Calculators</span></a></li>
                  <li class="seven calc-menu-var"><a><img src="<?php echo get_home_url(); ?>/svg/think-3.svg">
            <span>VAR Calculator</span></a></li>
                  <li class="seven calc-menu-avprice"><a><img src="<?php echo get_home_url(); ?>/svg/AveragePriceCalculator1-3.svg">
            <span>Average Price Calculator</span></a></li>
              </ul>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">

  jQuery(document).ready(function(){

        // jQuery('input[type="checkbox"]').click(function(){
        //     if(jQuery(this).is(":checked")){
        //         jQuery(".dslideapps").hide();
        //         jQuery(".spinmenow").show();

        //         jQuery('.true-name a').hide();
        //         jQuery('.show-name').show();
        //         jQuery('.trading-name').text('Displaying trading name');

        //         jQuery.ajax({
        //             method: "GET",
        //             url: "<?php echo get_home_url(); ?>/apipge/?daction=changeto&toname=tn",
        //             // url: 'https://api2.pse.tools/api/quotes',
        //             dataType: 'json',
        //             data: {
        //             'action' : 'my_custom_action'
        //             },
        //             success: function(data) {

        //                 jQuery(".dslideapps").show();
        //                 jQuery(".spinmenow").hide();

        //             }
        //         });
        //     }
        //     else if(jQuery(this).is(":not(:checked)")){
        //         jQuery(".dslideapps").hide();
        //         jQuery(".spinmenow").show();

        //         jQuery('.true-name a').show();
        //         jQuery('.show-name').hide();
        //         jQuery('.trading-name').text('Displaying real name');

        //         jQuery.ajax({
        //             method: "GET",
        //             url: "<?php echo get_home_url(); ?>/apipge/?daction=changeto&toname=rn",
        //             // url: 'https://api2.pse.tools/api/quotes',
        //             dataType: 'json',
        //             data: {
        //             'action' : 'my_custom_action'
        //             },
        //             success: function(data) {

        //                 jQuery(".dslideapps").show();
        //                 jQuery(".spinmenow").hide();

        //             }
        //         });
        //     }
        // });

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
