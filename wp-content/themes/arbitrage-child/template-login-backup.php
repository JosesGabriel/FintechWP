<?php
	/*
	* Template Name: Login Page
	*/
// get_header();'
$homeurlgen = get_home_url();

if ( is_user_logged_in() ) {
	header("Location: ".$homeurlgen."/");
	die();
}
global $current_user;
$user = wp_get_current_user();
get_header('login');
$setrand = rand(1,12);
$get_bgfimage = "loginbg".$setrand.".jpg";
?>
<style>/* Overrides */
@import url('https://fonts.googleapis.com/css?family=Raleway:400,900');
body, html {overflow: hidden !important;}
.um-form input[type=text], .um-form input[type=tel], .um-form input[type=number], .um-form input[type=password] {
    padding: 0 16px !important;
	font-size: 11px !important;
    height: 33px !important;
	line-height: 33px !important;
}
.login-form .login-item .login-form-field input {
    padding: 0 16px;
	height:33px;
	line-height:33px;
    border-radius: 0;
}
.login-form .login-item .login-form-title {
    margin-bottom: 6px;
    margin-left: 0;
}
.left-side-inner .paragpart {
    font-size: 18px;
    font-weight: 300;
}
.left-side-inner .paragpart strong {
	font-weight: 900 !important;
}
.login-form .login-submit input#wp-submit {
    display: block;
    cursor: pointer;
    width: 100%;
    background-color: transparent;
    border: none;
    color: #fff;
    font-size: 11px;
    height: 33px;
    line-height: 33px;
    padding: 0;
}
.um .um-form input[type=password]:active,
.um .um-form input[type=text]:active,
.um .um-form input[type=password]:focus,
.um .um-form input[type=text]:focus,
.um .um-form input[type=password],
.um .um-form input[type=text],
.login-form .login-item .login-form-field input {
    background: rgba(255,255,255,0.3);
	outline: none !important;
	color: #fff;
  	font-size:11px;
	border-radius: 50px;
	font-family:"Roboto", Arial;
	margin-bottom: 10px;
	border: none !important;
}
input#username_b:active,
input#username_b:focus,
.um .um-form input[type=password]:active,
.um .um-form input[type=text]:active,
.um .um-form input[type=password]:focus,
.um .um-form input[type=text]:focus {
	border:none !important;
}
div#um-shortcode-social-133 a.um-button.um-button-social i {margin-right: 0 !important;}
.left-side-inner {
    color: #bdc3c7;
}
.um .um-form input[type=password]::-webkit-input-placeholder,
.um .um-form input[type=text]::-webkit-input-placeholder,
.login-form .login-item .login-form-field input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #fff;
  font-size:11px;
}
.um .um-form input[type=password]::-webkit-input-placeholder,
.um .um-form input[type=text]::-webkit-input-placeholder,
.login-form .login-item .login-form-field input::-moz-placeholder { /* Firefox 19+ */
  color: #fff;
  font-size:11px;
}
.um .um-form input[type=password]::-webkit-input-placeholder,
.um .um-form input[type=text]::-webkit-input-placeholder,
.login-form .login-item .login-form-field input:-ms-input-placeholder { /* IE 10+ */
  color: #fff;
  font-size:11px;
}
.um .um-form input[type=password]::-webkit-input-placeholder,
.um .um-form input[type=text]::-webkit-input-placeholder,
.login-form .login-item .login-form-field input:-moz-placeholder { /* Firefox 18- */
  color: #fff;
  font-size:11px;
}
.um-field {
    padding: 0 0 0 0;
}
.um .um-form input[type=text], .um .um-form input[type=tel], .um .um-form input[type=number], .um .um-form input[type=password], .um .um-form textarea, .um .upload-progress, .select2-container .select2-choice, .select2-drop, .select2-container-multi .select2-choices, .select2-drop-active, .select2-drop.select2-drop-above {border: 0 !important;}
div.um .g-recaptcha {
    margin-top: 0 !important;
}
input[type=submit].um-button, input[type=submit].um-button:focus {
    vertical-align: middle !important;
    line-height: 33px !important;
    padding: 0 !important;
    background-color: transparent !important;
    height: 33px !important;
    font-size: 12px;
    cursor: pointer !important;
    width: 170px !important;
    box-shadow: none;
    text-shadow: none;
    font-family: inherit;
    outline: none !important;
    margin: 0 0 0 0 !important;
    opacity: 1;
    -webkit-appearance: none;
    min-width: 100px !important;
}
div.um .g-recaptcha {
    border-radius: 7px;
    overflow: hidden;
	height: 75px;
}
html,
.prtnr_signup,
.prtnr_login,
.forgotpass-wrapper .um-col-alt .um-center,
.um-register .um-col-alt .um-center,
.um-login .um-col-alt .um-center,
.login-submit {
	background-size:100% auto;
}
div#fancybox-content {
	border-color: #2c3e50 !important;
    background: #2c3e50 !important;
}
#fancybox-outer {
	background: #2c3e50 !important;
	box-shadow: none !important;
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    border-radius: 6px;
    overflow: hidden;
}
#fancybox-close {top: 18px;right: 18px;}
.lockedd {position:relative;}
.lockedd i.fa.fa-lock {
    top: 7px;
    position: absolute;
    right: 21px;
    font-size: 14px;
}
.rlewaylogo {
	font-family:'Raleway', sans-serif;
	font-size:20px;
	font-weight:900;
	padding:5px 0 20px;
	color:#fff;
}
html, .home body.et_cover_background {
    background-color: #354960 !important;
}
html, body, div#page-container, div#et-main-area {height: 100%;}
.um-social-login-overlay, #preloader,
html {background: url("<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>") 50% 0 no-repeat #2c3e50 fixed;}
#preloader {background-size: cover;}
html {-webkit-transition: all 0.5s ease; transition: all 0.5s ease;}
.ondashboardpage_login {
    display: table;
    width: 100%;
    height: 100%;
	-webkit-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.ondashboardpage_login_inner {
    vertical-align: top;
    padding-top: 5%;
    display: table-cell;
    text-align: center;
	position:relative;
	-webkit-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.signup-form {
	max-width: 290px;
	width:100%;
	margin:0 auto;
}
.um-login,
.login-form {
	max-width: 290px;
	width:100%;
	margin:0 auto;
}
.prtnr_login img,
.prtnr_signup img {
    width: 50px !important;
    height: 50px !important;
    padding: 5px 0 9px 0 !important;
}
.um-password .um-col-alt {
	padding-top:0;
	margin-top:0;
}
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
.forgotpass-wrapper .um-col-alt .um-center:hover {
	border-color: #fff;
}
#open-wschat {display:none !important;}
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
.um-login .um-col-alt .um-center:hover,
.um-register .um-col-alt .um-center:hover {
	border-color: #fff;
}
.um-login label.um-field-checkbox {
    top: -3px !important;
}
.um-login .um-col-alt .um-center {margin-top: -5px !important;}
.um-login .um-col-alt .um-center,
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
.um-register .um-col-alt .um-center:before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: -1;
  margin: -2px;
  border-radius: inherit;
  background: linear-gradient(to right, #ed0d85, #f15f56);
}
.um-password .um-col-alt .um-center:before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: -1;
  margin: -2px;
  border-radius: inherit;
  background: linear-gradient(to right, #2098f9, #9eefb4);
}
.um-login .um-col-alt .um-center:before,
.login-submit:before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: -1;
  margin: -2px;
  border-radius: inherit;
  background: linear-gradient(to right, #2098f9, #9eefb4);
}
.login-submit:hover {
	border-color: #fff;
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
.prtnr_signup:before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: -1;
  margin: -2px;
  border-radius: inherit;
  background: linear-gradient(to right, #ed0d85, #f15f56);
}
.prtnr_login:before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: -1;
  margin: -2px;
  border-radius: inherit;
  background: linear-gradient(to right, #2098f9, #9eefb4);
}
.prtnr_login span,
.prtnr_signup span {
    display: block;
    font-size: 11px;
    padding-top: 5px;
    position: absolute;
    width: 100%;
    color: #fff;
} 
.prtnr_signup:hover,
.prtnr_login:hover {
	border-color: #fff;
}
.login-form .login-item {
    margin-bottom: -15px;
}
.um-field-block {
    color: #fff;
    font-size: 11px;
    padding-bottom: 10px;
}
input#username_b {
	text-align:center;
}
.ondashboardpage_login_inner h3 {
    font-size: 18px;
    color: #fff;
    margin: 0 0 0 0;
    font-style: normal;
    padding: 0 0 20px 0;
}
.um-field-area {
    margin-bottom: 10px;
}
.left-login-form-inner {
    width: 100%;
}
.ordash {
	text-align:center; 
	padding:10px 0 0 !important; 
	margin-bottom:0; 
	color:#fff;
	font-size:12px;
}
.um-button-facebook span {
    display: none;
}
input#user_login, input#user_pass {
    text-align: center;
}
.ico_posbott_signup,
.ico_posbott_login {
	position:absolute;
	z-index:9999;
	bottom: 0;
	width:100%;
	padding:0 0 50px 0;
	text-align:center;
	display:none;
}
.login-form-field.groupfld {
	max-width:260px;
	margin:0 auto;
}
.um-field-type_password {
	width: 100%;
	display: inline-block;
	vertical-align: top;
}
.confirmpasscls {
    width: 0;
    margin-left: 0;
    display: inline-block;
    overflow: hidden;
    vertical-align: top;
}
.confirmpasscls input[type="password"]{
    margin-left: 4% !important;
    width: 96%;
}
.um {
    margin-bottom: 0 !important;
}
.um-field.um-field-last_name.um-field-text.um-field-type_text {
    width: 50%;
    display: inline-block;
}
.um-field.um-field-first_name.um-field-text.um-field-type_text {
    width: 50%;
    display: inline-block;
}
.um-row._um_row_1 {
    margin-bottom: -15px !important;
}
input#um-submit-btn {
    margin: 0 auto;
}
.um.um-register.um-9.uimob340 {
    margin-bottom: 0 !important;
}
.arb_circle_btns {
    position: relative;
    z-index: 9;
}
.um-half {
    width: 100%;
    float: none;
}
.um-col-alt {
    text-align: center;
    position: relative;
    z-index: 9;
}
.arb_copy {
	position:fixed;
	font-size:11px;
	color:#fff;
	bottom:25px;
	left:25px;
}
.signup-form-wrapper,
.login-form-wrapper {
    position: absolute;
    width: 100%;
}
.arb_accept {
	color:#fff;
	font-size:11px;
	text-align:center;
}
a.showpassreset {
	color:#fff !important;
	font-size:11px;
}
.arb_accept a {
	color:#fff;
	text-decoration:none;
}
.arb_forgpass label,
.arb_forgpass a {
	color:#fff;
	font-size:11px;
	text-decoration:none;
}
.arb_forgpass {
	padding-top: 10px;
}
.forgotpass-wrapper {
	display: none;
    position: relative;
    max-width: 260px;
    width: 100%;
    margin: 0 auto;
}
.forgotpass-wrapper .um-password {
	position:absolute;
	max-width: 260px;
    width: 100%;
    margin: 0 auto;
}
.um-um_password_id.um {
    max-width: 260px !important;
    margin: 0 auto;
}
.arb_forgpass_back {
	position:absolute;
	top:130px;
	width:100%;
	text-align:center;
}
.arb_forgpass_back a {
	color:#fff;
	font-size:11px;
}
.um-login .um .um-field-label {
    display: none;
}
.um-login .um-field-c .um-field-checkbox {
    margin-bottom: 0;
    font-size: 11px;
}
.um-login .um-field-c .um-field-checkbox {
    height: 21px;
    margin-bottom: 0;
    margin-top: 0 !important;
    position: relative;
    font-size: 11px;
    width: 24px;
    text-align: -webkit-auto;
    display: inline-block;
    vertical-align: top;
}
.um-login .um-field-checkbox-state i, .um-field-radio-state i {
    font-size: 20px;
    line-height: 21px;
    height: 20px;
	cursor:pointer;
}
.um-login .um-field-checkbox-option, .um-field-radio-option {
    margin: 0px 0px 0px 22px;
    color: #fff !important;
	cursor: pointer;
}
.um .um-field-checkbox.active:not(.um-field-radio-state-disabled) i {color: #4eb770;}
.forgotpass-wrapper .um-field-block div {text-align:center;}
.forgpasslnk {
	vertical-align: top;
	display:inline-block;
	line-height: 14px;
	color:#FFFFFF;
	font-size:11px;
	padding: 2px 0 0 0;
}
input#last_name-9 {
    border-radius: 0 35px 35px 0 !important;
}
input#first_name-9 {
    border-radius: 35px 0 0 35px !important;
	border-right: 1px solid rgba(255, 255, 255, 0.2) !important;
}
/* Responsive */
@media only screen and (max-width: 3200px){
	.prtnr_signup,
	.prtnr_login,
	html,
	.forgotpass-wrapper .um-col-alt .um-center,
	.um-register .um-col-alt .um-center,
	.um-login .um-col-alt .um-center,
	.login-submit {
		background-size:100% auto;
	}
}
@media only screen and (max-width: 1150px){
	.prtnr_signup,
	.prtnr_login,
	html,
	.forgotpass-wrapper .um-col-alt .um-center,
	.um-register .um-col-alt .um-center,
	.um-login .um-col-alt .um-center,
	.login-submit {
		background-size:cover;
	}
}
@media screen and (min-height: 280px){
	.ondashboardpage_login_inner {
		padding-top: 1%;
	}
}
@media screen and (min-height: 380px){
	.ondashboardpage_login_inner {
		padding-top: 1%;
	}
}
@media screen and (min-height: 480px){
	.ondashboardpage_login_inner {
		padding-top: 2%;
	}
}
@media screen and (min-height: 580px){
	.ondashboardpage_login_inner {
		padding-top: 3%;
	}
}
@media screen and (min-height: 610px){
	.ondashboardpage_login_inner {
		padding-top: 3%;
	}
}
@media screen and (min-height: 680px){
	.ondashboardpage_login_inner {
		padding-top: 6%;
	}
}
@media screen and (min-height: 780px){
	.ondashboardpage_login_inner {
		padding-top: 8%;
	}
}
@media screen and (min-height: 880px){
	.ondashboardpage_login_inner {
		padding-top: 10%;
	}
}
@media screen and (min-height: 980px){
	.ondashboardpage_login_inner {
		padding-top: 12%;
	}
}
@media screen and (min-height: 1080px){
	.ondashboardpage_login_inner {
		padding-top: 14%;
	}
}
</style>
<div class="ondashboardpage_login">
	<div class="ondashboardpage_login_inner">
    	<img src="<?php echo $homeurlgen; ?>/svg/arblogo_svg.svg" style="width:54px; height:43px;">
        <div class="rlewaylogo">ARBITRAGE <?php echo $force_show ?? ''; ?></div>
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
        
        <div class="login-form-wrapper">
            <div class="login-form" style="display: none;">
                
                  <div class="forgotpass-wrapper">
                        <div class="arb_forgpass_back"><a href="<?php echo $homeurlgen; ?>/login/" class="hidepassreset">Back to Login</a></div>
                  </div>
                
                    <div id="loginform" class="hidefromreset" style="position: relative; z-index: 9;">
                    <?php echo do_shortcode('[ultimatemember form_id="10"]');?>
                    <p class="ordash"><span style="letter-spacing:-3px;margin-right: 7px;">---------------- </span> or <span style="letter-spacing:-3px"> ----------------</span></p>
                    
					<?php #if(isset($_GET['active'])){ ?>
						<?php echo do_shortcode('[ultimatemember_social_login id=3218]');?>
                    <?php #} ?>
                </div>
                
            </div>
        </div>
    
      <div class="signup-form-wrapper">
          <div class="signup-form" style="display: none;">
              <div class="row" style="margin:0;">
                <div class="left-login-form-inner">
                	<?php if(isset($_GET['active'])){ ?>
                        <?php echo do_shortcode('[ultimatemember form_id="9"]');?>
                    <?php } ?>
                    <p class="ordash"><span style="letter-spacing:-3px;margin-right: 7px;">---------------- </span> or <span style="letter-spacing:-3px"> ----------------</span></p>
                   
						<?php echo do_shortcode('[ultimatemember_social_login id=133]');?>
          
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
    <a class="prtnr_signup" id="switch_signup" href="#">
        <img src="<?php echo $homeurlgen; ?>/svg/user-plus.svg" class="signup">
        <span>Sign Up</span>
    </a>
</div>
<div class="ico_posbott_login">
    
</div>

<div class="arb_copy">Arbitrage &copy; <?php echo date("Y"); ?></div>

<style type="text/css">/* Strong  */
div#um-shortcode-social-133 a.um-button.um-button-facebook {
    background-color: transparent !important;
    border: 1.5px solid #fff !important;
    width: 50px !important;
    padding: 0 !important;
    height: 50px !important;
    line-height: 50px !important;
    text-align: center !important;
    margin: 0 auto !important;
	border-radius: 50px !important;
}
div#um-shortcode-social-133 a.um-button.um-button-facebook:hover {
	border-color: #324d84 !important;
}
.um-field-error {
    position: absolute;
    padding: 6px 9px;
    font-size: 11px;
    line-height: normal !important;
    margin: 12px 0 13px;
    top: -9px;
    right: 3px;
    border-radius: 25px;
    width: 27px !important;
    text-align: center !important;
    font-weight: bold !important;
}
.um-field-arrow {
    display:none;
}
p.um-notice.err {
    display: none !important;
}
body, #page-container {background-color: transparent !important;}
div#um-shortcode-social-133 a.um-button.um-button-social i {
    font-size: 22px;
}
	
	<?php if (isset($_GET['active'])){ ?>
		/* Countdown disabled */
		.contercontrol {display:none !important;}
	<?php }else{ ?>
		/* Countdown */
		#page-container {display: none;}
		.um-social-login-overlay, #preloader, html {background-image: none !important;}
		html, .home body.et_cover_background {
			background-color: #0b1927 !important;
		}
		.text .val {
			margin: -11px 0 0 0;
			padding: 0;
		}
	<?php } ?>
	
</style> 
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('a.um-button.um-alt.um-button-social.um-button-facebook').html('<i class="um-faicon-facebook"></i>');
		jQuery( '<div class="forgpasslnk">Keep me sign in<span style="color: #949798;font-size: 11px;">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href="<?php echo $homeurlgen; ?>/password-reset/?b=<?php echo $setrand; ?>" class="showpassreset">Forgot Password?</a></div>' ).insertAfter( ".um-login .um-field-c .um-field-checkbox" );
		jQuery(".um-register .um-field-type_password:last-child").addClass("confirmpasscls");
		jQuery("#user_password-9").addClass("arbtriggerpass");
		jQuery(".um-register .um-col-1").append("<div class='arb_accept'>By clicking Sign Up, you agree to our <a href='<?php echo get_home_url(); 
		?>/terms/' class='fancybox-iframe'>Terms</a> & <a href='<?php echo get_home_url(); ?>/policies/' class='fancybox-iframe'>Policies</a></div>");
		jQuery(".forgotpass-wrapper .um-field-block div").html("Please enter your email address below");
		jQuery(".forgotpass-wrapper #username_b").attr("placeholder", "Email Address");
		
		/* jQuery(".showpassreset").click(function(){
			jQuery(".hidefromreset").fadeOut(400, function(){
				jQuery(".forgotpass-wrapper").fadeIn(400);
			});
		}); */
		
		jQuery(".hidepassreset").click(function(){
			jQuery(".forgotpass-wrapper").fadeOut(400, function(){
				jQuery(".hidefromreset").fadeIn(400);
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
		
	});
</script>

<?php get_footer();