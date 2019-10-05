<?php
	/*
	* Template Name: FB Share Page
	* Template page for facebook verification 	
	*/
// get_header();
$siteurlgen = get_home_url();
global $current_user;
$user = wp_get_current_user(); 

if ( is_user_logged_in() ) {
	$user_id = $user->ID;
	$checksharing = get_user_meta( $user_id, "check_user_share", true ); 
	if ($checksharing == "shared"){
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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
		.openn {display:none;}
		.lockk {display:block;}
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
		i.fab.fa-facebook-f {
			font-size: 18px;
			vertical-align: middle;
			margin-right: 10px;
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
			<script type="text/javascript">
            function shareOnFB() {
                FB.ui({
                    method: "feed",
                    link: "<?php echo get_home_url(); ?>/",
                    picture: "<?php echo $get_fimage; ?>",
                    name: "<?php echo $get_fttle; ?>",
                    caption: '<?php echo $siteurlgen ?>/',
                    description: "<?php echo $get_fdescr; ?>",
					quote: "This is awesome!",
                    }, function(t){
                    var str = JSON.stringify(t);
                    var obj = JSON.parse(str);
                    if(obj.post_id != ''){
                        var secret_data = "<input type='submit' value='<?php 
							$input_btnlabel = array("Yeah! Let&rsquo;s go!", "Oh yeah! Let me in!", "Nice! Get started!", "Cool! Let&rsquo;s rock!");
							$get_btnlabel = array_rand($input_btnlabel, 1);
							$get_fbtnlabel = $input_btnlabel[$get_btnlabel];
							echo $get_fbtnlabel;
						 ?>' class='arb_very_btn'>";
                        jQuery("#arb_buttonhere").html(secret_data);
						jQuery(".openn").css("display","block");
						jQuery(".lockk").css("display","none");
						jQuery(".lockk").html("<!-- Shared -->");
                    }
                });
            }
            </script>
            <div class='verifrm lockk'>
                <h2>Share to Verify</h2>
                <p>Please share our website to verify your account and to gain full access to our trading facilities.</p>
                <a href="#" onclick="shareOnFB();" class="arb_very_btn fb"><i class="fab fa-facebook-f"></i> Share on Facebook</a>
            </div>
            <div class='verifrm openn'>
            	<h2><strong><?php 
					$input_welttl = array("Awesome!", "Great!", "Amazing!", "Wonderful!");
					$get_welttl = array_rand($input_welttl, 1);
					$get_fwelttl = $input_welttl[$get_welttl];
					echo $get_fwelttl;
				 ?></strong></h2>
                <h3 style="color:#bdc3c7; font-weight:300;"><?php 
					$curusernow = ucfirst($user->user_login);
					$input_weldesc = array("It&rsquo;s time for your pocket to shine!", "OMG! You&rsquo;re in! Congrats!", "Alright! let&rsquo;s get started!", "Behold! you&rsquo;re about to enter to a new world of trading!");
					$get_weldesc = array_rand($input_weldesc, 1);
					$get_fweldesc = $input_weldesc[$get_weldesc];
					echo $get_fweldesc;
				 ?></h3>                
                <form method='post' enctype='multipart/form-data' action='<?php echo $siteurlgen; ?>/' >
                    <input type='hidden' value='shared' name='check_user_share_input'>
                    <div id="arb_buttonhere"></div>
                </form>
            </div>
        </div>
    <?php }else{ ?>
        <script type="text/javascript">window.location.href = "<?php echo $siteurlgen; ?>/";</script>
    <?php } ?>
    </div> <!-- #main-content -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=310546216473988&version=v2.0&message=This%20is%20awesome!";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
<?php get_footer('dashboard');