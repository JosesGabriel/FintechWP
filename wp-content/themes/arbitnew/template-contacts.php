<?php

	/*

	* Template Name: Contacts

	*/



// get_header();

global $current_user;

$user = wp_get_current_user();



get_header('dashboard');



?>

<?php get_template_part('parts/global', 'cssfooter'); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/footer/contacts.css?<?php echo time(); ?>">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

	<!-- <div class="background-positionfix"> -->
		<div class="starsNear-2zVFGJ">
		<svg class="leftConstellation-OiQA13" version="1.1" xmlns="http://www.w3.org/2000/svg">
			<circle class="star-3Afsk9" r="1" cx="55.39610339506173%" cy="28.23688271604938%"></circle>
			<circle class="star-3Afsk9" r="3" cx="68.32534722222222%" cy="97.13371913580247%"></circle>
			<circle class="star-3Afsk9" r="1" cx="50.800887345679016%" cy="56.132407407407406%"></circle>
			<circle class="star-3Afsk9" r="3" cx="45.60050154320988%" cy="98.34405864197531%"></circle>
			<circle class="star-3Afsk9" r="1" cx="22.168634259259264%" cy="57.54645061728395%"></circle>
			<circle class="star-3Afsk9" r="3" cx="30.616396604938274%" cy="24.18402777777777%"></circle>
			<circle class="star-3Afsk9" r="1" cx="91.72156635802469%" cy="4.367901234567896%"></circle>
			<circle class="star-3Afsk9" r="3" cx="20.928587962962965%" cy="7.875848765432096%"></circle>
			<circle class="star-3Afsk9" r="1" cx="77.3485725308642%" cy="70.15231481481482%"></circle>
			<circle class="star-3Afsk9" r="3" cx="61.759297839506175%" cy="10.308410493827154%"></circle>
			<circle class="star-3Afsk9" r="1" cx="31.605208333333337%" cy="14.121913580246911%"></circle>
			<circle class="star-3Afsk9" r="3" cx="58.99741512345679%" cy="62.03726851851852%"></circle>
			<circle class="star-3Afsk9" r="1" cx="21.71369598765432%" cy="83.16558641975308%"></circle>
			<circle class="star-3Afsk9" r="3" cx="21.198495370370367%" cy="43.2846450617284%"></circle>
			<circle class="star-3Afsk9" r="1" cx="41.562924382716055%" cy="65.83888888888889%"></circle>
			<circle class="star-3Afsk9" r="3" cx="37.584760802469134%" cy="90.93942901234568%"></circle>
			<circle class="star-3Afsk9" r="1" cx="55.708449074074075%" cy="62.36404320987654%"></circle>
			<circle class="star-3Afsk9" r="3" cx="91.04510030864198%" cy="48.557175925925925%"></circle>
			<circle class="star-3Afsk9" r="1" cx="76.37249228395062%" cy="99.62993827160494%"></circle>
			<circle class="star-3Afsk9" r="3" cx="3.13506944444444%" cy="38.36010802469136%"></circle>
			<circle class="star-3Afsk9" r="1" cx="75.44394290123456%" cy="76.19212962962963%"></circle>
			<circle class="star-3Afsk9" r="3" cx="6.0768904320987644%" cy="76.23711419753087%"></circle>
			<circle class="star-3Afsk9" r="1" cx="28.478356481481484%" cy="37.272839506172836%"></circle>
			<circle class="star-3Afsk9" r="3" cx="60.75945216049383%" cy="16.743750000000006%"></circle>
			<circle class="star-3Afsk9" r="1" cx="90.69795524691358%" cy="86.76095679012346%"></circle>
			<circle class="star-3Afsk9" r="3" cx="98.73831018518518%" cy="26.102237654320987%"></circle>
			<circle class="star-3Afsk9" r="1" cx="13.991628086419752%" cy="35.212037037037035%"></circle>
			<circle class="star-3Afsk9" r="3" cx="99.23568672839507%" cy="98.20146604938272%"></circle>
			<circle class="star-3Afsk9" r="1" cx="81.91493055555556%" cy="70.8483024691358%"></circle>
			<circle class="star-3Afsk9" r="3" cx="1.1404706790123527%" cy="98.59699074074074%"></circle>
			<circle class="star-3Afsk9" r="1" cx="97.69008487654321%" cy="77.55864197530863%"></circle>
			<circle class="star-3Afsk9" r="3" cx="44.00821759259259%" cy="39.51103395061728%"></circle>
			<circle class="star-3Afsk9" r="1" cx="88.20597993827161%" cy="74.89861111111111%"></circle>
			<circle class="star-3Afsk9" r="3" cx="53.061149691358025%" cy="90.83248456790123%"></circle>
			<circle class="star-3Afsk9" r="1" cx="51.018171296296295%" cy="97.09043209876543%"></circle>
			<circle class="star-3Afsk9" r="3" cx="44.18815586419753%" cy="30.116898148148152%"></circle>
			<circle class="star-3Afsk9" r="1" cx="31.348881172839498%" cy="6.022993827160491%"></circle>
			<circle class="star-3Afsk9" r="3" cx="69.94479166666667%" cy="12.586496913580248%"></circle>
			<circle class="star-3Afsk9" r="1" cx="34.08699845679011%" cy="30.251851851851853%"></circle>
			<circle class="star-3Afsk9" r="3" cx="98.55327932098766%" cy="87.13016975308642%"></circle>
			<circle class="star-3Afsk9" r="1" cx="67.7880787037037%" cy="49.99922839506173%"></circle>
			<circle class="star-3Afsk9" r="3" cx="24.902507716049385%" cy="42.30347222222222%"></circle>
			<circle class="star-3Afsk9" r="1" cx="23.67434413580247%" cy="4.154012345679021%"></circle>
			<circle class="star-3Afsk9" r="3" cx="11.548032407407405%" cy="77.32862654320988%"></circle>
			<circle class="star-3Afsk9" r="1" cx="82.6346836419753%" cy="33.271759259259255%"></circle>
			<circle class="star-3Afsk9" r="3" cx="70.71207561728394%" cy="21.09452160493828%"></circle>
			<circle class="star-3Afsk9" r="1" cx="66.22465277777778%" cy="61.574691358024694%"></circle>
			<circle class="star-3Afsk9" r="3" cx="75.2835262345679%" cy="69.15671296296296%"></circle>
			<circle class="star-3Afsk9" r="1" cx="8.666473765432102%" cy="5.951697530864195%"></circle>
			<circle class="star-3Afsk9" r="1" cx="99.81793981481482%" cy="68.73742283950617%"></circle>
			</svg>
		<svg class="rightConstellation-2amr_t" version="1.1" xmlns="http://www.w3.org/2000/svg">
			<circle class="star-3Afsk9" r="1" cx="55.39610339506173%" cy="28.23688271604938%"></circle>
			<circle class="star-3Afsk9" r="3" cx="68.32534722222222%" cy="97.13371913580247%"></circle>
			<circle class="star-3Afsk9" r="1" cx="50.800887345679016%" cy="56.132407407407406%"></circle>
			<circle class="star-3Afsk9" r="3" cx="45.60050154320988%" cy="98.34405864197531%"></circle>
			<circle class="star-3Afsk9" r="1" cx="22.168634259259264%" cy="57.54645061728395%"></circle>
			<circle class="star-3Afsk9" r="3" cx="30.616396604938274%" cy="24.18402777777777%"></circle>
			<circle class="star-3Afsk9" r="1" cx="91.72156635802469%" cy="4.367901234567896%"></circle>
			<circle class="star-3Afsk9" r="3" cx="20.928587962962965%" cy="7.875848765432096%"></circle>
			<circle class="star-3Afsk9" r="1" cx="77.3485725308642%" cy="70.15231481481482%"></circle>
			<circle class="star-3Afsk9" r="3" cx="61.759297839506175%" cy="10.308410493827154%"></circle>
			<circle class="star-3Afsk9" r="1" cx="31.605208333333337%" cy="14.121913580246911%"></circle>
			<circle class="star-3Afsk9" r="3" cx="58.99741512345679%" cy="62.03726851851852%"></circle>
			<circle class="star-3Afsk9" r="1" cx="21.71369598765432%" cy="83.16558641975308%"></circle>
			<circle class="star-3Afsk9" r="3" cx="21.198495370370367%" cy="43.2846450617284%"></circle>
			<circle class="star-3Afsk9" r="1" cx="41.562924382716055%" cy="65.83888888888889%"></circle>
			<circle class="star-3Afsk9" r="3" cx="37.584760802469134%" cy="90.93942901234568%"></circle>
			<circle class="star-3Afsk9" r="1" cx="55.708449074074075%" cy="62.36404320987654%"></circle>
			<circle class="star-3Afsk9" r="3" cx="91.04510030864198%" cy="48.557175925925925%"></circle>
			<circle class="star-3Afsk9" r="1" cx="76.37249228395062%" cy="99.62993827160494%"></circle>
			<circle class="star-3Afsk9" r="3" cx="3.13506944444444%" cy="38.36010802469136%"></circle>
			<circle class="star-3Afsk9" r="1" cx="75.44394290123456%" cy="76.19212962962963%"></circle>
			<circle class="star-3Afsk9" r="3" cx="6.0768904320987644%" cy="76.23711419753087%"></circle>
			<circle class="star-3Afsk9" r="1" cx="28.478356481481484%" cy="37.272839506172836%"></circle>
			<circle class="star-3Afsk9" r="3" cx="60.75945216049383%" cy="16.743750000000006%"></circle>
			<circle class="star-3Afsk9" r="1" cx="90.69795524691358%" cy="86.76095679012346%"></circle>
			<circle class="star-3Afsk9" r="3" cx="98.73831018518518%" cy="26.102237654320987%"></circle>
			<circle class="star-3Afsk9" r="1" cx="13.991628086419752%" cy="35.212037037037035%"></circle>
			<circle class="star-3Afsk9" r="3" cx="99.23568672839507%" cy="98.20146604938272%"></circle>
			<circle class="star-3Afsk9" r="1" cx="81.91493055555556%" cy="70.8483024691358%"></circle>
			<circle class="star-3Afsk9" r="3" cx="1.1404706790123527%" cy="98.59699074074074%"></circle>
			<circle class="star-3Afsk9" r="1" cx="97.69008487654321%" cy="77.55864197530863%"></circle>
			<circle class="star-3Afsk9" r="3" cx="44.00821759259259%" cy="39.51103395061728%"></circle>
			<circle class="star-3Afsk9" r="1" cx="88.20597993827161%" cy="74.89861111111111%"></circle>
			<circle class="star-3Afsk9" r="3" cx="53.061149691358025%" cy="90.83248456790123%"></circle>
			<circle class="star-3Afsk9" r="1" cx="51.018171296296295%" cy="97.09043209876543%"></circle>
			<circle class="star-3Afsk9" r="3" cx="44.18815586419753%" cy="30.116898148148152%"></circle>
			<circle class="star-3Afsk9" r="1" cx="31.348881172839498%" cy="6.022993827160491%"></circle>
			<circle class="star-3Afsk9" r="3" cx="69.94479166666667%" cy="12.586496913580248%"></circle>
			<circle class="star-3Afsk9" r="1" cx="34.08699845679011%" cy="30.251851851851853%"></circle>
			<circle class="star-3Afsk9" r="3" cx="98.55327932098766%" cy="87.13016975308642%"></circle>
			<circle class="star-3Afsk9" r="1" cx="67.7880787037037%" cy="49.99922839506173%"></circle>
			<circle class="star-3Afsk9" r="3" cx="24.902507716049385%" cy="42.30347222222222%"></circle>
			<circle class="star-3Afsk9" r="1" cx="23.67434413580247%" cy="4.154012345679021%"></circle>
			<circle class="star-3Afsk9" r="3" cx="11.548032407407405%" cy="77.32862654320988%"></circle>
			<circle class="star-3Afsk9" r="1" cx="82.6346836419753%" cy="33.271759259259255%"></circle>
			<circle class="star-3Afsk9" r="3" cx="70.71207561728394%" cy="21.09452160493828%"></circle>
			<circle class="star-3Afsk9" r="1" cx="66.22465277777778%" cy="61.574691358024694%"></circle>
			<circle class="star-3Afsk9" r="3" cx="75.2835262345679%" cy="69.15671296296296%"></circle>
			<circle class="star-3Afsk9" r="1" cx="8.666473765432102%" cy="5.951697530864195%"></circle>
			<circle class="star-3Afsk9" r="3" cx="99.81793981481482%" cy="68.73742283950617%"></circle>
			</svg>
		</div>
	</div>
	<div class="wavey-bottom-bg">
		<svg class="wave-1hkxOo" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
			<path class="wavePath-haxJK1" d="M826.337463,25.5396311 C670.970254,58.655965 603.696181,68.7870267 447.802481,35.1443383 C293.342778,1.81111414 137.33377,1.81111414 0,1.81111414 L0,150 L1920,150 L1920,1.81111414 C1739.53523,-16.6853983 1679.86404,73.1607868 1389.7826,37.4859505 C1099.70117,1.81111414 981.704672,-7.57670281 826.337463,25.5396311 Z" fill="#0b1827" style=""></path>
		</svg>
	</div>
<div class="container">
	<div class="sub-container" style="width: 100%; text-align: justify;">
		<h2 class="terms-padding">We're here</h2>

		<div class="inner-content inner-content--contact">
			<form action="" class="contact--form row" id="contact--form">
				<div class="col-md-12">
					<div class="quote">
						<h4 class="quote-f01">It’s about time.</h4>
						<span class="quote-f1">We've been waiting for you to reach us.</span>
					</div>
					<div class="form-group">
						<!-- <label for="contact--textField__name" class="contact--label">Name *</label> -->
						<input type="text" class="form-control contact--textField contact--textField__name" id="contact--textField__name" placeholder="What does your friends call you?">
					</div>
					<div class="form-group">
						<!-- <label for="contact--textField__email" class="contact--label">Email *</label> -->
						<input type="email" class="form-control contact--textField contact--textField__email" id="contact--textField__email" placeholder="Where can we email you back?">
					</div>
				</div>
				<div class="quote2 col-md-12">
					<div class="form-group">
						<!-- <label for="contact--textField__message" class="contact--label">Message *</label> -->
						<textarea name="" class="form-control contact--textField" id="contact--textField__message" cols="30" rows="4" form="contact--form" placeholder="The team is all ears. We're always here for a good chat."></textarea>
					</div>
					<div class="flex-box">
						<button type="submit" class="arbitrage-button arbitrage-button--dark" style="outline: none;">Submit</button>
					</div>
				</div>
			</form>
				<!-- <h4 class="quote-f02">It’s about time.</h4>
				<span class="quote-f2">We’ve been waiting for you to contact us. Let’s talk about: Your amazing Ideas; How we can improve our service; Space and time.</span> -->
		</div>
	</div>
</div>
<div class="footer-container">
	<div class="button-media-container">
		<a href="https://business.facebook.com/arbitrage.ph/?business_id=118029389394062&ref=bookmarks">
			<img src="/svg/facebook-01.svg" class="media-facebook" alt="https://business.facebook.com/arbitrage.ph/?business_id=118029389394062&ref=bookmarks">
		</a>
		<a href="https://twitter.com/ArbitragePh?s=09">
			<img src="/svg/twitter-01.svg" class="media-twitter" alt="https://twitter.com/ArbitragePh?s=09">
		</a>
		<a href="https://instagram.com/arbitrage_ph?igshid=1nhyzhq0d8jqy/">
			<img src="/svg/instagram-white.svg" class="media-instagram" alt="https://instagram.com/arbitrage_ph?igshid=1nhyzhq0d8jqy/">
		</a>
	</div>
	<div class="container a-link-text-align a-link-text-margin a-text-font">
		<a href="/privacy-policy/">Privacy Policy</a>
		<span class="ddot">•</span>
		<a href="/terms-of-use/">Terms of Use</a>
		<span class="ddot">•</span>
		<a href="/contact/">Contact Us</a>
		<span class="ddot">•</span>
		<a href="/about/">About Us</a>
		<!-- <span class="ddot">•</span>
		<a href="/FAQ/">FAQ</a> -->
		<div class="c-footer-arbitrage">Copyright © 2019 Arbitrage</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".media-facebook").hover(function(){
			$(this).attr('src', "/svg/facebook-1.svg");
			}, function(){
			$(this).attr('src', "/svg/facebook-01.svg");
		}, 1500);
		$(".media-twitter").hover(function(){
			$(this).attr('src', "/svg/twitter-1.svg");
			}, function(){
			$(this).attr('src', "/svg/twitter-01.svg");
		}, 1500);
		$(".media-instagram").hover(function(){
			$(this).attr('src', "/svg/instagram-2.svg");
			}, function(){
			$(this).attr('src', "/svg/instagram-white.svg");
		}, 1500);
	});
</script>
<style>
	.container .sub-container {
		padding: 50px 15% 0px 15%;
	}
	.contact--form{
		padding-left: 0;
	}
	.inner-content {
		padding: 30px 40px 25px 40px;
	}
</style>

<?php get_footer();