<?php
	/*
	* Template Name: Email Verify page
	* Template page for email verification
	*/
// get_header();
$siteurlgen = get_home_url();
global $current_user;
$user = wp_get_current_user(); 

if ( is_user_logged_in() ) {
	$user_id = $user->ID;
	$checksharing = get_user_meta( $user_id, "check_user_share", true ); 
	if ($checksharing == "verified"){
		  header('Location: '.$siteurlgen);
		  die();
	}
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php if (WP_PROD_ENV != null && WP_PROD_ENV): ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-147416476-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-147416476-1');
	</script>
	
	<!-- Google Ads -->
    <script async src=“https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js“></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-7982031973729040",
            enable_page_level_ads: true
        });
    </script>
	<?php endif ?>
	
	<meta property="og:type" content="website" /> 
	<meta property="og:url" content="<?php echo $siteurlgen; ?>/share/" /> 
	<meta property="og:image" content="<?php 
		$input_image = array("ogimg1.jpg", "ogimg2.jpg", "ogimg3.jpg", "ogimg4.jpg", "ogimg5.jpg");
		$get_image = array_rand($input_image, 1);
		$get_fimage = $siteurlgen."/images/".$input_image[$get_image];
		echo $get_fimage;
	 ?>" />
	<meta property="og:title" content="<?php 
		$input_ttle = array("Top-notch Charting Tools, Alerts & Screeners", "Superb Trading Journal & Analytics", "User-Friendly Social Trading Facility", "Trading Skills Amplifier", "Trading is Life, Life is Trading");
		$get_ttle = array_rand($input_ttle, 1);
		$get_fttle = $input_ttle[$get_ttle];
		echo $get_fttle;
	 ?>" />
    <meta property="og:description" content="<?php 
		$input_descr = array("Amplify your inherent skills using our tools. Join today and become a better trader", "You can be free. You can live and work anywhere in the world. You can be independent from routine and not answer to anybody.", "Win or lose, everybody gets what they want out of the market. Some people seem to like to lose, so they win by losing money.", "What seems too high and risky to the majority generally goes higher and what seems low and cheap generally goes lower.", "You don't need to be a rocket scientist. Investing is not a game where the guy with the 160 IQ beats the guy with 130 IQ.");
		$get_descr = array_rand($input_descr, 1);
		$get_fdescr = $input_descr[$get_descr];
		echo $get_fdescr;
	 ?>" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<?php wp_head(); ?>
	<style>
		body, html {height: 100% !important;}
		body {
			font-family: 'Roboto', sans-serif;
			background: url(<?php echo get_home_url(); ?>/wp-content/uploads/2018/11/sign_up_hero.jpg) no-repeat center center;
			background-size: cover;
			color: #bdc3c7;
			font-size: 14px;
			font-weight: 300;
			line-height: 150%;
			overflow: hidden;
		}
		#main-content {
			background-color: transparent !important;
		}
		h1, h2, h3 {
			color: #fff;
			font-family: "Roboto", Arial, Helvetica, sans-serif;
		}
		.share_locker {
			padding: 0;
		}
		.ism_locker_3 .lock_content h2 {
			text-shadow: none !important;
			font-family: "Roboto", Arial, Helvetica, sans-serif;
			color: #fff !important;
		}
		p, body, div,
		.lock_content p {
			color: #bdc3c7;
		}
		.lock_buttons {
			padding: 25px !important;
		}
		a.ism_link {
			display: inline-block;
		}
		.arb_sharecontent {
			width: 100%;
			max-width: 600px;
			margin:-9px auto 45px;
		}
		.arb_very_btn {
			display: inline-block;
			margin: 15px;
			background-color: #25ae5f;
			border: 0;
			color: #FFF;
			padding: 11px 22px;
			font-family: "Roboto", Arial, Helvetica, sans-serif;
			border-radius: 35px;
			font-size: 14px;
			cursor:pointer;
		}
		.arb_very_btn:hover {
			background-color: #178c48;
		}
		.verifrm {
			text-align: center;
			width: 100%;
			max-width: 600px;
			margin: 0 auto;
			padding: 35px 0 40px;
		}
		a.arb_very_btn.fb .fa-facebook {
			font-size: 20px;
			vertical-align: middle;
			margin-right: 5px;
		}
		a.arb_very_btn.fb {
			margin: 15px;
			background-color: #4267b2;
		}
		a.arb_very_btn.fb:hover {
			background-color: #32559c;
		}
    </style>
</head>
<body>
    <div id="main-content" class="oncommonsidebar">
    <?php if ( is_user_logged_in() ) { ?>
    	<div style="text-align:center; padding:15% 0 0;">
        	<a href="<?php echo $siteurlgen; ?>"><img src="<?php echo $siteurlgen; ?>/wp-content/uploads/2018/12/logo.png" alt="Arbitrage Social Trading"></a>
        </div>
		<div class="share_locker">
            <div class='verifrm openn'>
                <?php 
				$user_id = $user->ID;
				$verificationurl = $siteurlgen."/verify/?".rand(342014141,942014141).$user_id."-".date("dmY").rand(342014141,942014141)."&em"; ?>
				
				<?php if (isset($_GET['em'])){ ?>
				
					<?php
                    $matchthisnow = $user_id."-".date("dmY");
                    $matchtothis = $_SERVER[REQUEST_URI];
                    if(preg_match("/$matchthisnow/i", $matchtothis)){ ?>
                    
                    	<h2><strong>Almost there!</strong></h2>
                    	<p>Click the button below to activate your account.</p>
                        <form method='post' enctype='multipart/form-data' action='<?php echo $siteurlgen; ?>/' >
                            <input type='hidden' value='verified' name='check_user_share_input'>
                            <div id="arb_buttonhere"><input type='submit' value='<?php 
                                    $input_btnlabel = array("Yeah! Let&rsquo;s go!", "Oh yeah! Let me in!", "Nice! Get started!", "Cool! Let&rsquo;s rock!");
                                    $get_btnlabel = array_rand($input_btnlabel, 1);
                                    $get_fbtnlabel = $input_btnlabel[$get_btnlabel];
                                    echo $get_fbtnlabel;
                                 ?>' class='arb_very_btn'></div>
                        </form>
                    
                    <?php }else{ ?>
                    
                    	<h2><strong>Wooops!</strong></h2>
                        <p>This verification link has expired. <a href="<?php echo $siteurlgen."/verify/?again"; ?>">Please try again</a></p>
                    
					<?php } ?>
                
                <?php }else{ ?>
                
                    <h2><strong>Please verify your email</strong></h2>
                    <p>Check your inbox. Our system sent a verification link to <?php
                    $user_id = $user->ID;
                    $user_info = get_userdata($user_id);
										$email = $user_info->user_email;
                    echo $email; ?></p><br />
                    <p>It may take 2-5 minutes for it to arrive in your inbox.<br>
                    You may also check your spam folder.</p> 
                    
					<?php 
                    $to = $email;
                    $subject = 'Email Verification';
                    $message = '
                        <table align="center" width="650" border="0" cellspacing="0" cellpadding="0" bgcolor="#0d1f33">
                          <tbody>
                            <tr>
                              <td align="center"><p>&nbsp;</p>
                              <p><img class="arbi-logo" src="'.$siteurlgen.'/images/emaillogo.png" /></p>
                              <p>&nbsp;</p></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="5%">&nbsp;</td>
                              <td width="90%"><font face="Arial" size="2"><br />Hey '.get_user_meta( $user_id, "first_name", true ).',<br /><br />
                                <a href="'.$verificationurl.'" target="_blank">Click here</a> to verify your email address.<br />
                              <br />If the link does not work please copy-and-paste this to your browser: <br />'.$verificationurl.'<br /><br />
                              Happy Trading!<br />
                              Arbitrage Team
                              <br /><br /></font>
                              </td>
                              <td width="5%">&nbsp;</td>
                            </tr>
                          </tbody>
                        </table>
                        </td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="center"><font color="#FFFFFF" face="Arial" size="2"><br /><br />
                                Arbitrage &copy; 2019<br />
                              <br /><br /></font></td>
                            </tr>
                          </tbody>
                        </table>
                    ';
                    
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'To: '.get_user_meta( $user_id, "first_name", true ).' <'.$email.'>' . "\r\n";
                    $headers .= 'From: Arbitrage Team <no-reply@arbitrage.ph>';
                    
                    $success = mail($to, $subject, $message, $headers);
					if (!$success) {
						$errorMessage = error_get_last();
					}
					 ?>
                
                <?php } ?>

            </div>
        </div>
    <?php }else{ ?>
        <script type="text/javascript">window.location.href = "<?php echo $siteurlgen; ?>/";</script>
    <?php } ?>
    </div> <!-- #main-content -->

</body>
</html>
<?php get_footer('dashboard');