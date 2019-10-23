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
    span#span_login_rememberme{
        color: #fff;
        margin-left: 20px;
        line-height: 2;
        font-weight: normal;
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
					<label for="rememberme" class="inline um-field-checkbox-option">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" style="display:block !important;"/> <?php _e( 'Keep me signed in', 'ultimate-member' ); ?>
					</label>
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

<?php 
require("login/login-scripts.php"); 
require("login/footer-files.php"); 
?>