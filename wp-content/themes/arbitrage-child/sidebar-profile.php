<?php 

	global $current_user;
	$user = wp_get_current_user();
  $userid = get_current_user_id();
	$cdnorlocal = get_home_url();

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
              <a href="/user/<?php echo $value['user_nicename']; ?>"><div class="user-image" style="background: url('<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>') no-repeat center center;width: 29px;height: 29px;">&nbsp;</div>
              </a>
          </div>
          <div class="right-image">

                  <div class="onto-user-name">
                    <a href="/user/<?php echo $value['user_nicename']; ?>" style="color:#fffffe; <?php echo ($unametype == "" || $unametype == 'rn' ? '' : 'display:none;'); ?>">
                      <?php echo um_user('first_name') . " " . um_user('last_name'); ?>
                    </a>
                    <i class="hidemeplease dslideapps" style="margin: 0;font-size: 14px;float: right;color: #d8d8d8;"><label class="switch">
                      <input type="checkbox" id="realname" <?php echo ($unametype == "" || $unametype == 'rn' ? '' : 'checked="checked"'); ?>>
                      <span class="slider round"></span>
                    </label></i>
                    <i class="fas fa-spinner fa-spin spinmenow" style="margin: 0;font-size: 14px;float: right;color: #d8d8d8;display: none;"></i>
                    <div class="show-name" style="<?php echo ($unametype == "" || $unametype == 'rn' ? 'display:none;' : 'display:block;'); ?>">
                      <span><?php echo um_user('nickname'); ?></span>
                    </div>

                  </div>

                  <div class="onto-user-name trading-name" style="text-transform: none !important;font-size: 11px;"><?php echo ($unametype == "" || $unametype == 'rn' ? 'Displaying real name' : 'Displaying trading name'); ?></div>
                  <!-- <?php echo um_user('nickname'); ?> -->
          </div>
      </div>
      <div class="side-content">
          <div class="side-content-inner sidebariconssocial">
              <ul style="margin-top: 10px; font-family: Helvetica, Arial, sans-serif; font-weight: 600;">
                  <li class="one" style="margin-top: 8px;"><a href="/"><img src="<?php echo $cdnorlocal; ?>/svg/layout.svg">Social Wall</a></li>
                  <li class="twos"><a href="/chart/"><img src="<?php echo $cdnorlocal; ?>/svg/bar-chart.svg">Interactive Chart</a></li>
                  <li class="three"><a href="/journal/"><img src="<?php echo $cdnorlocal; ?>/svg/edit1.svg">Trading Journal</a></li>
                  <li class="four"><a href="/watchlist/"><img src="<?php echo $cdnorlocal; ?>/svg/binoculars5.svg">Watcher & Alerts</a></li>		
                  <li class="five"><a href="https://vyndue.com/"><img src="<?php echo $cdnorlocal; ?>/svg/ico_messager_blue.svg">Vyndue Messenger</a></li>										
                  <li class="six dpowerdown">
                    <a href="#" class="powertools"><img src="<?php echo $cdnorlocal; ?>/svg/think.svg">Power Tools 
                      <i class="fas fa-ellipsis-h sddropps"></i></a>
                    <div class="ddroplace">
                      <div class="ddropinner">
                        <ul>
                          <li><a>Buy/Sell Calculators</a></li>
                          <li><a>VAR Calculator</a></li>
                          <li><a>Average Price Calculator</a></li>
                        </ul>
                      </div>
                    </div>
                  </li>
                  <li class="seven"><a href="https://game.arbitrage.ph/game"><img src="<?php echo $cdnorlocal; ?>/svg/play-station.svg">Games</a></li>
              </ul>
          </div>
      </div>
  </div>
</div>

<hr class="style14 style13">

<script type="text/javascript">
  // $activetab1 = '/';
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

                jQuery.ajax({
                    method: "GET",
                    url: "/apipge/?daction=changeto&toname=tn",
                    dataType: 'json',
                    data: {
                    'action' : 'my_custom_action'
                    },
                    success: function(data) {

                        jQuery(".dslideapps").show();
                        jQuery(".spinmenow").hide();

                    }
                });
            }
            else if(jQuery(this).is(":not(:checked)")){
                jQuery(".dslideapps").hide();
                jQuery(".spinmenow").show();

                jQuery('.true-name a').show();
                jQuery('.show-name').hide();
                jQuery('.trading-name').text('Displaying real name');

                jQuery.ajax({
                    method: "GET",
                    url: "/apipge/?daction=changeto&toname=rn",
                    dataType: 'json',
                    data: {
                    'action' : 'my_custom_action'
                    },
                    success: function(data) {

                        jQuery(".dslideapps").show();
                        jQuery(".spinmenow").hide();

                    }
                });
            }
        });

        jQuery('.sddropps').click(function(e){
          e.preventDefault();
          
          if (jQuery(this).hasClass('isopened')) {
            jQuery(this).removeClass('isopened');
            jQuery(this).parents('.dpowerdown').find('.ddroplace').addClass('openme').hide('fast'); 
          }else{
            jQuery(this).addClass('isopened');
            jQuery(this).parents('.dpowerdown').find('.ddroplace').addClass('openme').show('fast');
          }
        });
    });

  jQuery(document).ready(function(){
    var pageURL = jQuery(location).attr("href");
    if(pageURL == '/'){
      jQuery('.side-content ul .one').addClass('active');
    }else if(pageURL == '/chart/'){
      jQuery('.side-content ul .twos').addClass('active');
    }else if(pageURL == '/journal/'){
      jQuery('.side-content ul .three').addClass('active');
    }else if(pageURL == '/watchlist/'){
      jQuery('.side-content ul .four').addClass('active');
    }else if(pageURL == 'https://vyndue.com/'){
      jQuery('.side-content ul .five').addClass('active');
    }else if(pageURL == '/tools/'){
      jQuery('.side-content ul .six').addClass('active');
    }else if(pageURL == '/game/'){
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