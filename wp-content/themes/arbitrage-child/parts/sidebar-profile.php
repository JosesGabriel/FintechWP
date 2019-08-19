<?php

	global $current_user;
	$user = wp_get_current_user();
    $userid = get_current_user_id();

  $unametype = get_user_meta($userid, 'disname', true);

  // echo $unametype;
  $name = "";
  if ($unametype == "" || $unametype == 'rn') {
    $name = um_user('first_name') . " " . um_user('last_name');
  } else {
    $name = "";
  }
?>
<div class="left-user-details">
  <div class="left-user-details-inner">
      <div class="side-header">
          <div class="left-image">
              <a href="<?php echo get_home_url(); ?>/user/<?php echo $value['user_nicename']; ?>"><div class="user-image" style="background: url('<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>') no-repeat center center;width: 29px;height: 29px;">&nbsp;</div>
              </a>
          </div>
          <div class="right-image">

                  <div class="onto-user-name true-name">
                    <!-- <a href="<?php //echo get_home_url(); ?>/user/<?php // echo $value['user_nicename']; ?>" style="color:#fffffe; 
                    <?php // echo ($unametype == "" || $unametype == 'rn' ? '' : 'display:none;'); ?>">
                      <?php // echo um_user('first_name') . " " . um_user('last_name'); ?>
                    </a> -->

                    <!-- <i class="hidemeplease dslideapps" style="margin: 0;font-size: 14px;float: right;color: #d8d8d8;"><label class="switch">
                      <input type="checkbox" id="realname" <?php // echo ($unametype == "" || $unametype == 'rn' ? '' : 'checked="checked"'); ?>>
                      <span class="slider round"></span>
                    </label></i> -->

                    <!-- <i class="fas fa-spinner fa-spin spinmenow" style="margin: 0;font-size: 14px;float: right;color: #d8d8d8;display: none;"></i>
                    <div class="show-name"> -->
                      <a href="<?php echo get_home_url(); ?>/user" style="color:#fff;"><span><?php echo um_user( 'first_name' ) . " " . um_user( 'last_name' ); ?></span></a>
                      <div class="arb_smalltxt">@<?php echo um_user('nickname'); ?></div>
                    <!-- </div> -->

                    <!-- <i class="fas fa-spinner fa-spin spinmenow" style="margin: 0;font-size: 14px;float: right;color: #d8d8d8;display: none;"></i>
                    <div class="show-name" style="<?php // echo ($unametype == "" || $unametype == 'rn' ? 'display:none;' : 'display:block;'); ?>">
                      <span><?php // echo um_user('nickname'); ?></span>
                    </div> -->

                  </div>

                  <!-- <div class="onto-user-name trading-name" style="text-transform: none !important;font-size: 11px;"><?php // echo ($unametype == "" || $unametype == 'rn' ? 'Displaying real name' : 'Displaying trading name'); ?></div> -->
                  <!-- <?php // echo um_user('nickname'); ?> -->
          </div>
      </div>
	  <?php
	  	$dusersecret = get_user_meta($userid, 'user_secret', true);
	  ?>

      <div class="profile-progress">
          <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
            70%
          </div>
      </div>

      <div class="side-content">
          <div class="side-content-inner sidebariconssocial">
              <ul style="margin-top: 10px; font-family: Helvetica, Arial, sans-serif; font-weight: 600;">
				  <?php /*?><li class="zero openleftpanel active showonmobonly">
					<a href="#" style="background: #213f58 !important;">
					  <img src="<?php echo get_home_url(); ?>/svg/openleftpanel_al.svg">
					</a>
          		  </li><?php */?>
				  <li class="one" style="margin-top: 8px;"><a href="<?php echo get_home_url(); ?>/"><img src="<?php echo get_home_url(); ?>/svg/layout-1.svg">	<span>Social Wall</span></a></li>
                  <li class="twos"><a href="/chart/"><img src="<?php echo get_home_url(); ?>/svg/bar-chart-1.svg">
					  <span>Interactive Chart</span></a></li>
                  <li class="three"><a href="/journal/"><img src="<?php echo get_home_url(); ?>/svg/edit1-1.svg">
					  <span>Trading Journal</span></a></li>
                  <li class="four"><a href="/watchlist/"><img src="<?php echo get_home_url(); ?>/svg/binoculars5-1.svg">
					  <span>Watcher & Alerts</span></a></li>
                  <li class="seven"><a href="<?php echo get_home_url(); ?>/game/"><img src="<?php echo get_home_url(); ?>/svg/play-station-1.svg">
            <span>Games</span></a></li>
                  <li class="five"><a href="<?php echo get_home_url(); ?>/vyndue/"><img src="<?php echo get_home_url(); ?>/svg/vyndue-newlogo1-1.svg">
            <span>Vyndue</span></a></li>
            
            <div class="m-separator"></div>
            <span class="menu-title-calc">Power Tools</span>
                  <li class="seven calc-menu-buysell"><a><img src="<?php echo get_home_url(); ?>/svg/BuySellCalculators-1.svg">
            <span>Buy/Sell Calculators</span></a></li>
                  <li class="seven calc-menu-var"><a><img src="<?php echo get_home_url(); ?>/svg/think-1.svg">
            <span>VAR Calculator</span></a></li>
                  <li class="seven calc-menu-avprice"><a><img src="<?php echo get_home_url(); ?>/svg/AveragePriceCalculator1-1.svg">
            <span>Average Price Calculator</span></a></li>
                  <li class="seven calc-menu-multichart"><a href="/multicharts/"><img src="<?php echo get_home_url(); ?>/svg/statistics-1.svg">
            <span>Multichart</span></a></li>
                  <!-- <li class="six dpowerdown isopened">
                    <a href="#" class="powertools"><img src="<?php echo get_home_url(); ?>/svg/think.svg">
                      <span>Power Tools</span>
                        <span><i class="fas fa-ellipsis-h sddropps"></i></a></span>
                      <span>
                        <div class="ddroplace">
                          <div class="ddropinner">
                          <ul>
                            <li><a>Buy/Sell Calculators</a></li>
                            <li><a>VAR Calculator</a></li>
                            <li><a>Average Price Calculator</a></li>
                          </ul>
                          </div>
                        </div>
                      </span>
                  </li> -->
				  <?php /*?><li class="eight slideleft showonmobonly">
					<a href="#">
					  <img src="<?php echo get_home_url(); ?>/svg/slideleft.svg">
					</a>
          		  </li><?php */?>
                  <?php /*?><li class="seven"><a href="https://game.arbitrage.ph/game/activateme/<?php echo md5($dusersecret); ?>"><img src="<?php echo get_home_url(); ?>/svg/play-station.svg">Games</a></li><?php */?>
              </ul>
          </div>
      </div>
  </div>
</div>

<hr class="style14 style13">

<script type="text/javascript">
  // $activetab1 = '<?php echo get_home_url(); ?>/';
  // if()
  // jQuery('.hidemeplease').click(){
  //   jQuery('.choosename').show();
  // }
        // jQuery('.show-name').hide();
        // jQuery('.true-name a').hide();

  jQuery(document).ready(function(){

        jQuery('input[type="checkbox"]').click(function(){
            if(jQuery(this).is(":checked")){
                jQuery(".dslideapps").hide();
                jQuery(".spinmenow").show();

                jQuery('.true-name a').hide();
                jQuery('.show-name').show();
                jQuery('.trading-name').text('Displaying trading name');
                console.log('checked');

                jQuery.ajax({
                    method: "GET",
                    url: "<?php echo get_home_url(); ?>/apipge/?daction=changeto&toname=tn",
                    // url: 'https://api2.pse.tools/api/quotes',
                    dataType: 'json',
                    data: {
                    'action' : 'my_custom_action'
                    },
                    success: function(data) {

                        jQuery(".dslideapps").show();
                        jQuery(".spinmenow").hide();

                        console.log(data);
                    }
                });
            }
            else if(jQuery(this).is(":not(:checked)")){
                jQuery(".dslideapps").hide();
                jQuery(".spinmenow").show();

                jQuery('.true-name a').show();
                jQuery('.show-name').hide();
                jQuery('.trading-name').text('Displaying real name');
                console.log('unchecked');

                jQuery.ajax({
                    method: "GET",
                    url: "<?php echo get_home_url(); ?>/apipge/?daction=changeto&toname=rn",
                    // url: 'https://api2.pse.tools/api/quotes',
                    dataType: 'json',
                    data: {
                    'action' : 'my_custom_action'
                    },
                    success: function(data) {

                        jQuery(".dslideapps").show();
                        jQuery(".spinmenow").hide();

                        console.log(data);
                    }
                });
            }
        });

        // jQuery('.dpowerdown').click(function(e){
        //   e.preventDefault();

        //   if (jQuery(this).hasClass('isopened')) {
        //     jQuery(this).removeClass('isopened');
        //     jQuery(this).closest('.dpowerdown').find('.ddroplace').addClass('openme').hide('fast');
        //   }else{
        //     jQuery(this).addClass('isopened');
        //     jQuery(this).closest('.dpowerdown').find('.ddroplace').addClass('openme').show('fast');
        //   }
        // });
	  
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
<style>
.switch {
  position: relative;
  display: inline-block;
      width: 20px;
    height: 11px;
    margin: 0;
    bottom: -2px;
}
.ddroplace {
  display: none;
  margin-left: 32px;
}

.ddropinner ul li a {
    padding: 7px 0px 7px 7px;
    cursor: pointer;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #BDBDBD;
  -webkit-transition: .4s;
  transition: .4s;
  box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.75);
}

.slider:before {
  position: absolute;
  content: "";
  height: 7px;
  width: 7px;
  left: 2px;
  bottom: 2.4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  box-shadow: 0px 0px 1px 0px rgba(0,0,0,0.75);
}

input:checked + .slider {
  background-color: #8BC34A;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(8px);
  -ms-transform: translateX(8px);
  transform: translateX(8px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<style type="text/css">

  /*.hidemeplease {
    visibility: hidden;
  }
  .true-name:hover > .hidemeplease {
    visibility: visible;
    cursor: pointer;
  }*/
  .side-header .right-image {
    display: inline-block;
    width: 81%;
    font-size: 13px !important;
    font-weight: normal;
    line-height: 1.3em;
    vertical-align: top;
  }
  .sidebariconssocial li.active a {
    background: #142c46 !important;
    color:#fff !important;
    border-radius: 4px !important;
    box-shadow: 0px 1px 2px -1px rgba(4,13,23,1) !important;
  }
  .side-content ul li a:hover {
    background: #142c46 !important;
  }
  .sidebariconssocial .one .active a {
    background: none !important;
    color: #fff !important;
    /* border-radius: 4px; */
    border-right: 4px solid #e91e63;
  }
  .sidebariconssocial .twos .active a {
    background: none !important;
    color: #fff !important;
    /* border-radius: 4px; */
    border-right: 4px solid #9c27b0;
  }
  .sidebariconssocial .three .active a {
    background: none !important;
    color: #fff !important;
    /* border-radius: 4px; */
    border-right: 4px solid #00bcd4;
  }
  .sidebariconssocial .four .active a {
    background: none !important;
    color: #fff !important;
    /* border-radius: 4px; */
    border-right: 4px solid #4caf50;
  }
  .sidebariconssocial .five .active a {
    background: none !important;
    color: #fff !important;
    /* border-radius: 4px; */
    border-right: 4px solid #2196f3;
  }
  .sidebariconssocial .six .active a {
    background: none !important;
    color: #fff !important;
    /* border-radius: 4px; */
    border-right: 4px solid #ffeb3b;
  }
  .sidebariconssocial .seven .active a {
    background: none !important;
    color: #fff !important;
    /* border-radius: 4px; */
    border-right: 4px solid #f44336;
  }
  .true-name a:hover {
    text-decoration: none;
  }
</style>
