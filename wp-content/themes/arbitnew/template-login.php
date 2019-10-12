<?php
	/*
	* Template Name: Login Page
	*/
// get_header();'
$homeurlgen = get_home_url();
echo is_user_logged_in();
if ( is_user_logged_in() ) {
	header("Location: ".$homeurlgen."/");
	die();
}
global $current_user;
$user = wp_get_current_user();

require("login/header-files.php");

$setrand = rand(1,12);
$get_bgfimage = "loginbg".$setrand.".jpg";
?>
<style>/* Overrides */
	@import url('https://fonts.googleapis.com/css?family=Raleway:400,900');
	html {background: url("<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>") 50% 0 no-repeat #2c3e50 fixed;}
	.forgotpass-wrapper .um-col-alt .um-center {
		display: inline-block;
		margin: 0;
		text-align: center;
		align-items: center;
		width: 190px;
		height: 36px;
		position: relative;
		box-sizing: border-box;
		background: url(<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>) 50% 0 no-repeat transparent fixed;
		background-clip: padding-box; 
		border: solid 2px transparent;
		border-radius: 35px;
		-webkit-transition: all 0.5s ease;
		transition: all 0.5s ease;
	}
	.um-register .um-col-alt .um-center {
		display: inline-block;
		margin: 10px 10px 0;
		text-align: center;
		align-items: center;
		width: 190px;
		height: 36px;
		position: relative;
		box-sizing: border-box;
		background: url(<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>) 50% 0 no-repeat transparent fixed;
		background-clip: padding-box; 
		border: solid 2px transparent;
		border-radius: 35px;
		-webkit-transition: all 0.5s ease;
		transition: all 0.5s ease;
	}
	.um-login .um-col-alt .um-center {
		display: inline-block;
		margin: 10px 10px 0;
		text-align: center;
		align-items: center;
		width: 190px;
		height: 36px;
		position: relative;
		box-sizing: border-box;
		background: url(<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>) 50% 0 no-repeat transparent fixed;
		background-clip: padding-box; 
		border: solid 2px transparent;
		border-radius: 35px;
		-webkit-transition: all 0.5s ease;
		transition: all 0.5s ease;
	}
	.login-submit {
		display: inline-block;
		margin: 15px 10px 0;
		text-align: center;
		align-items: center;
		width: 190px;
		height: 36px;
		position: relative;
		box-sizing: border-box;
		background: url(<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>) 50% 0 no-repeat transparent fixed;
		background-clip: padding-box; 
		border: solid 2px transparent;
		border-radius: 35px;
		-webkit-transition: all 0.5s ease;
		transition: all 0.5s ease;
	}
	.prtnr_signup,
	.prtnr_login {
		display:inline-block;
		margin:20px 10px 0;
		text-align:center;
		align-items: center;
		width: 50px;
		height: 50px;
		position: relative;
		box-sizing: border-box;
		background: url(<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>) 50% 0 no-repeat transparent fixed;
		background-clip: padding-box; 
		border: solid 2px transparent;
		border-radius: 35px;
		-webkit-transition: all 0.5s ease;
		transition: all 0.5s ease;
	}
	span.for_pass {
		display: inline;
		padding: 0px 0 20px;
		font-size: 12px;
		text-align: center;
		color: #fff;
		cursor: pointer;
	}
	span.for_pass:hover {
		text-decoration: none;
		color: #d8d8d8;
	}
	span.for_remember {
		display: inline;
		padding: 0px 0 20px;
		font-size: 12px;
		text-align: center;
		color: #fff;
		cursor: pointer;
	}
	span.for_remember:hover {
		text-decoration: none;
		color: #d8d8d8;
	}
	.tochecked_cont {
		display: block;
		position: relative;
		margin: 0 auto;
		text-align: center;
	}
</style>
<div class="ondashboardpage_login">
	<div class="ondashboardpage_login_inner">
        <img src="<?php echo $homeurlgen; ?>/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:102px;">
        <div class="rlewaylogo"> <?php echo $force_show ?? ''; ?></div>
        <div class="arb_circle_btns">
            <a class="prtnr_login" href="#">
            	<img src="<?php echo $homeurlgen; ?>/svg/user-key.svg" class="login">
                <span>Login</span>
            </a>
            <a class="prtnr_signup" href="#">
            	<img src="<?php echo $homeurlgen; ?>/svg/user-plus.svg" class="signup">
                <span>Sign Up</span>
            </a>
        </div>
		<div class="email_pass_reset_cont">
			<form id="email_pass_reset">

				<span class="label_pls">Please enter your email address below</span><br>
				<input type="email" required class="email-info" id="email_info"><br>

				<input type="submit" value="Reset" id="email_btn_info">
			</form>
		</div>
		<div class="confirmed_cont">
			<span class="label_pls">You have successfully reset your password! Please check your email.</span><br>
			<a class="backto-login" href>Back to login</a>
		</div>
		<div class="error_message"><span class="label_pls"></span></div>
		
        <div class="login-form-wrapper">
            <div class="login-form" style="display: none;">
                
                  <div class="forgotpass-wrapper">
                        <div class="arb_forgpass_back"><a href="<?php echo $homeurlgen; ?>/login/" class="hidepassreset">Back to Login</a></div>
                  </div>
                
                    <div id="loginform" class="hidefromreset" style="position: relative; z-index: 9;">
                    <?php echo do_shortcode('[ultimatemember form_id="10"]');?>
                    <p class="ordash"><span style="letter-spacing:-3px;margin-right: 7px;">---------------- </span> or <span style="letter-spacing:-3px"> ----------------</span></p>
                    
					<?php #if(isset($_GET['active'])){ ?>
						<?php #echo do_shortcode('[ultimatemember_social_login id=3218]');?>
					<?php #} ?>
					<a class="prtnr_signup" id="switch_signup" href="#">
						<img src="<?php echo $homeurlgen; ?>/svg/user-plus.svg" class="signup">
						<span>Sign Up</span>
					</a>
                </div>
                
            </div>
        </div>
					
      <div class="signup-form-wrapper">
          <div class="signup-form" style="display: none;">
              <div class="row" style="margin:0;">
                <div class="left-login-form-inner">
                	<?php //if(isset($_GET['active'])){ ?>
                        <?php echo do_shortcode('[ultimatemember form_id="9"]');?>
                    <?php //} ?>
                    
                   <p class="ordash"><span style="letter-spacing:-3px;margin-right: 7px;">---------------- </span> or <span style="letter-spacing:-3px"> ----------------</span></p>
                    <?php #if(isset($_GET['active'])){ ?>
						<?php #echo do_shortcode('[ultimatemember_social_login id=3218]');?>
                    <?php #} ?>

                    <a class="prtnr_login" id="switch_login" href="#">
						<img src="<?php echo $homeurlgen; ?>/svg/user-key.svg" class="login">
						<span>Login</span>
					</a>
                </div>
              </div>
          </div>
      </div>
      
    </div>
</div>

<div class="ico_posbott_signup">
    
</div>
<div class="ico_posbott_login">
	
</div>

<div class="arb_copy">Arbitrage &copy; <?php echo date("Y"); ?></div>

<style type="text/css">/* Strong  */



	
</style> 
<script type="text/javascript">
	jQuery(document).ready(function(){ 
		$(".login-form-wrapper a.um-button.um-alt.um-button-social.um-button-facebook").appendTo(".login-form-wrapper .ordash");
		$(".signup-form-wrapper a.um-button.um-alt.um-button-social.um-button-facebook").appendTo(".signup-form-wrapper .ordash");
		jQuery('a.um-button.um-alt.um-button-social.um-button-facebook').html('<i class="um-faicon-facebook"></i>');
		jQuery( '<div class="forgpasslnk"><span style="color: #949798;font-size: 11px;"></span><a href="<?php echo $homeurlgen; ?>/password-reset/?b=<?php echo $setrand; ?>" class="showpassreset">Forgot Password?</a></div>' ).insertAfter( ".um-login .um-field-c .um-field-checkbox" );
		jQuery(".um-register .um-field-type_password:last-child").addClass("confirmpasscls");
		jQuery("#user_password-9").addClass("arbtriggerpass");
		jQuery(".um-register .um-col-1").append("<div class='arb_accept'>By clicking Sign Up, you agree to our <a href='<?php echo get_home_url(); 
		?>/terms/' class='fancybox-iframe'>Terms</a> & <a href='<?php echo get_home_url(); ?>/policies/' class='fancybox-iframe'>Policies</a></div>");
		jQuery(".forgotpass-wrapper .um-field-block div").html("Please enter your email address below");
		jQuery(".forgotpass-wrapper #username_b").attr("placeholder", "Email Address");
		jQuery(".um-col-alt-b a.um-link-alt").hide();
		jQuery("#loginform .um-form .um-row .um-col-1").append("<div class='tochecked_cont'><span class='for_remember'>Remember me | </span><span class='for_pass'>Forgot your password?</span></div>");
	
		
		jQuery(".hidepassreset").click(function(){
			jQuery(".forgotpass-wrapper").fadeOut(400, function(){
				jQuery(".hidefromreset").fadeIn(400);
			});
		});

		jQuery(".for_pass").click(function(){
			jQuery(".login-form").fadeOut(300, function(){
				jQuery(".email_pass_reset_cont").fadeIn(400);
			});
		});


		jQuery(".prtnr_login").click(function(){
			jQuery(".arb_circle_btns").fadeOut(400, function(){
				jQuery(".login-form").fadeIn(400, function(){
					jQuery(".ico_posbott_signup").fadeIn(400);
				});
			});
		});
		
		jQuery(".prtnr_signup").click(function(){
			jQuery(".arb_circle_btns").fadeOut(400, function(){
				jQuery(".signup-form").fadeIn(400, function(){
					jQuery(".ico_posbott_login").fadeIn(400);
				});
			});
		});
		
		jQuery("#switch_signup").click(function(){
			jQuery(".login-form").fadeOut(300, function(){
				jQuery(".signup-form").fadeIn(800);
			});
			
			jQuery(".email_pass_reset_cont").fadeOut(300, function(){
			});
			jQuery(".confirmed_cont").fadeOut(300, function(){
			});
			jQuery(".error_message").fadeOut(300, function(){
			});
			
			jQuery(".ico_posbott_signup").fadeOut(300, function(){
				jQuery(".ico_posbott_login").fadeIn(300);
			});
		});
		
		jQuery("#switch_login").click(function(){
			jQuery(".signup-form").fadeOut(300, function(){
				jQuery(".login-form").fadeIn(800);
			});
			
			jQuery(".ico_posbott_login").fadeOut(300, function(){
				jQuery(".ico_posbott_signup").fadeIn(300);
			});
		});
		
		jQuery(".arbtriggerpass").focusin(function(){
			jQuery(".um-register .um-field-type_password").animate({
				width: "50%",
			}, function(){
				jQuery(".confirmpasscls").animate({width: "50%"});
				jQuery(".confirmpasscls").append("<style>.um-register .um-field-type_password {width: 50% !important;}</style>");
			});	
		});
		
		if ( jQuery(".um-login .um-field div").hasClass("um-field-error") ){
			jQuery('.arb_circle_btns').css('display','none'); 
			jQuery('.prtnr_login').trigger('click'); 
			jQuery('.um-field:first-child .um-field-error').html('<span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Please enter your email address')
		}
		
		if ( jQuery(".um-register .um-field div").hasClass("um-field-error") ){
			jQuery('.arb_circle_btns').css('display','none'); 
			jQuery('.prtnr_signup').trigger('click'); 
		}
		
		jQuery(".um-form-field.um-error").focusin(function(){
			jQuery(".um-field-error").fadeOut('fast');
		});
		
		jQuery(".um-button-social").attr('onClick','FBPopup(this.href); return false');
		function FBPopup(url) {
			popupWindow = window.open(url,'popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
		}
		
	})
	.on('submit', '#email_pass_reset', function (e) {
            
            var email = jQuery("#email_info").val();
            var hasvalemail = jQuery("#email_info").val().length;

            var url = "<?php echo $homeurlgen; ?>/apipge/?daction=email_pass_reset&email="+email;
            jQuery.ajax({
                'url': url,
                'method': 'GET',
                'data': '',
                'dataType': 'json',
                'success': function (response) {
                    if (response.success) {
                        jQuery(".email_pass_reset_cont").hide();
                        jQuery(".confirmed_cont").show();
                        return;
                    }
                    jQuery('.error_message').show();
                    return;
                }
            })
            e.preventDefault();
        });;
</script>

<?php require("login/footer-files.php"); ?>