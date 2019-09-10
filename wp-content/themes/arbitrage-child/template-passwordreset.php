<?php
	/*
	* Template Name: Password Confirmation
	*/

// get_header();
// $setrand = rand(1,12);
// $get_bgfimage = "loginbg".$setrand.".jpg";
?>

<div class="ondashboardpage_login">
	<div class="ondashboardpage_login_inner">
        <img src="<?php echo $homeurlgen; ?>/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:102px;">
        <form id="pass-reset">
            <Label>Old Password</Label>
            <input type="text" required class="pass-info">

            <Label>New Password</Label>
            <input type="text" required class="pass-info">

            <Label>Confirm New Password</Label>
            <input type="text" required class="pass-info">

            <input type="button" value="Update Password" id="pass-btn-info">
        </form>
    </div>
</div>


<div class="arb_copy">Arbitrage &copy; <?php echo date("Y"); ?></div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		// jQuery('a.um-button.um-alt.um-button-social.um-button-facebook').html('<i class="um-faicon-facebook"></i>');
		// jQuery( '<div class="forgpasslnk"><span style="color: #949798;font-size: 11px;"></span><a href="<?php echo $homeurlgen; ?>/password-reset/?b=<?php echo $setrand; ?>" class="showpassreset">Forgot Password?</a></div>' ).insertAfter( ".um-login .um-field-c .um-field-checkbox" );
		// jQuery(".um-register .um-field-type_password:last-child").addClass("confirmpasscls");
		// jQuery("#user_password-9").addClass("arbtriggerpass");
		// jQuery(".um-register .um-col-1").append("<div class='arb_accept'>By clicking Signing Up, you agree to our <a href='<?php echo get_home_url(); 
		// ?>/terms/' class='fancybox-iframe'>Terms</a> & <a href='<?php echo get_home_url(); ?>/policies/' class='fancybox-iframe'>Policies</a></div>");
		// jQuery(".forgotpass-wrapper .um-field-block div").html("Please enter your email address below");
		// jQuery(".forgotpass-wrapper #username_b").attr("placeholder", "Email Address");
		// jQuery(".um-col-alt-b a.um-link-alt").hide();
		
		/* jQuery(".showpassreset").click(function(){
			jQuery(".hidefromreset").fadeOut(400, function(){
				jQuery(".forgotpass-wrapper").fadeIn(400);
			});
		}); */
		
		// jQuery(".hidepassreset").click(function(){
		// 	jQuery(".forgotpass-wrapper").fadeOut(400, function(){
		// 		jQuery(".hidefromreset").fadeIn(400);
		// 	});
		// });
		
		// jQuery(".prtnr_login").click(function(){
		// 	jQuery(".arb_circle_btns").fadeOut(400, function(){
		// 		jQuery(".login-form").fadeIn(400, function(){
		// 			jQuery(".ico_posbott_signup").fadeIn(400);
		// 		});
		// 	});
		// });
		
		// jQuery(".prtnr_signup").click(function(){
		// 	jQuery(".arb_circle_btns").fadeOut(400, function(){
		// 		jQuery(".signup-form").fadeIn(400, function(){
		// 			jQuery(".ico_posbott_login").fadeIn(400);
		// 		});
		// 	});
		// });
		
		// jQuery("#switch_signup").click(function(){
		// 	jQuery(".login-form").fadeOut(300, function(){
		// 		jQuery(".signup-form").fadeIn(800);
		// 	});
			
		// 	jQuery(".ico_posbott_signup").fadeOut(300, function(){
		// 		jQuery(".ico_posbott_login").fadeIn(300);
		// 	});
		// });
		
		// jQuery("#switch_login").click(function(){
		// 	jQuery(".signup-form").fadeOut(300, function(){
		// 		jQuery(".login-form").fadeIn(800);
		// 	});
			
		// 	jQuery(".ico_posbott_login").fadeOut(300, function(){
		// 		jQuery(".ico_posbott_signup").fadeIn(300);
		// 	});
		// });
		
		// jQuery(".arbtriggerpass").focusin(function(){
		// 	jQuery(".um-register .um-field-type_password").animate({
		// 		width: "50%",
		// 	}, function(){
		// 		jQuery(".confirmpasscls").animate({width: "50%"});
		// 		jQuery(".confirmpasscls").append("<style>.um-register .um-field-type_password {width: 50% !important;}</style>");
		// 	});	
		// });
		
		// if ( jQuery(".um-login .um-field div").hasClass("um-field-error") ){
		// 	jQuery('.arb_circle_btns').css('display','none'); 
		// 	jQuery('.prtnr_login').trigger('click'); 
		// 	jQuery('.um-field:first-child .um-field-error').html('<span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Please enter your email address')
		// }
		
		// if ( jQuery(".um-register .um-field div").hasClass("um-field-error") ){
		// 	jQuery('.arb_circle_btns').css('display','none'); 
		// 	jQuery('.prtnr_signup').trigger('click'); 
		// }
		
		// jQuery(".um-form-field.um-error").focusin(function(){
		// 	jQuery(".um-field-error").fadeOut('fast');
		// });
		
		// jQuery(".um-button-social").attr('onClick','FBPopup(this.href); return false');
		// function FBPopup(url) {
		// 	popupWindow = window.open(url,'popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
		// }
		
	});
</script>

<?php //get_footer();