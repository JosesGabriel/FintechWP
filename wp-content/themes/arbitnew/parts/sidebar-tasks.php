<?php
global $current_user;
$user = wp_get_current_user();
$userid = get_current_user_id();
//if ($_GET['ruadmin'] == "yeah"){
  //$all_meta_for_user = get_user_meta($userid);
  //print_r( $all_meta_for_user );
//}
?>
<style>
.todos_box ul li a {
	color: #ecf0f1;
    font-size: 13px;
    font-family: Roboto, sans-serif;
    font-weight: 400;
}
.todos_box {
	margin: 2px 0 0 0;
    padding: 15px 15px 10px 15px;
    background-color: #142c46;
    border-radius: 5px;
}
.todos_box a i {
	opacity:0.3 !important;
	margin-right: 2px;
}
.arbit-checked i {
	opacity:1 !important;
}
li.arbit-checked {
	font-size: 13px;
    font-family: Roboto, sans-serif;
	/*color: #25ae5f !important;*/
	font-weight: 500 !important;
	line-height: 24px;
}
</style>
<?php 

$profile_id = um_profile_id();
// $friendstotalinit = UM()->Friends_API()->api()->count_friends( $profile_id );
$friendstotal = UM()->Friends_API()->api()->count_friends( $profile_id );
//$friendstotal = count($friendreqs);
$coverhphotoactive = um_profile( 'cover_photo' );
$profilepicactive = um_profile( 'profile_photo' );
if (!$coverhphotoactive || !$profilepicactive || $friendstotal < 3){ ?>

<div class="todos_box" style="display: none;">
  <div class="todos_box-inner">
	  <div class="to-top-title">Complete your Profile</div>
	  <div class="to-content-part to-back-back">
		  <div class="content-inner-part">
            <?php //echo $friendstotal; ?>
				<ul>
                	
                    <?php if(!$coverhphotoactive){ ?>
                    	<li class="arbit-checked"><a href="<?php echo get_home_url(); ?>/user/<?php 
                    		echo $user->user_login; ?>/?profiletab=main&um_action=edit&arbitaction=editcover"><i class="far fa-check-square"></i> Change cover photo</a>
                        </li>
                    <?php }else{ ?>
                    	<li class="arbit-checked">
                    		<!--<i class="fas fa-check-square"></i>-->
                    		<img src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/images/Checkbox.svg" width="8%">
                    		Cover photo updated</li>
                    <?php } ?>
                    
                    <?php if(!$profilepicactive){ ?>
                    	<li class="arbit-checked"><a href="<?php echo get_home_url(); ?>/user/<?php 
                    		echo $user->user_login; ?>/?profiletab=main&um_action=edit&arbitaction=editphoto"><i class="far fa-check-square"></i> Change profile photo</a>
                        </li>
                    <?php }else{ ?>
                    	<li class="arbit-checked">
                    		<!--<i class="fas fa-check-square"></i> -->
                    		<img src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/images/Checkbox.svg" width="8%">
                    		Profile photo updated</li>
                    <?php } ?>
                    
                    
					<?php if ($friendstotal < 3){ ?>
						<li><a href="<?php echo get_home_url(); ?>/member-directory/"><i class="far fa-check-square"></i> Mingle with <?php
							
							$initval = 3;
							$remainingtoadd = ($initval - $friendstotal);
							if ($remainingtoadd == 3){
								$pphrase = $remainingtoadd.' peers';
							}elseif ($remainingtoadd == 2) {
								$pphrase = $remainingtoadd.' more peers';
							}else{
								$pphrase = $remainingtoadd.' more peer';
							}
							echo $pphrase;
						?></a></li>
					<?php } ?>
					
                </ul>
		  </div>
	  </div>
  </div>
</div>
<hr class="style14 style13">
<?php } ?>