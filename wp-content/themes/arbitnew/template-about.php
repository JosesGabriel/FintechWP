<?php

	/*

	* Template Name: About Us

	*/



// get_header();

global $current_user;

$user = wp_get_current_user();



get_header('dashboard');



?>

<?php get_template_part('parts/global', 'cssfooter'); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/footer/about.css?<?php echo time(); ?>">
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
	<!-- <div class="wavey-bottom-bg">
		<svg class="wave-1hkxOo" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
			<path class="wavePath-haxJK1" d="M826.337463,25.5396311 C670.970254,58.655965 603.696181,68.7870267 447.802481,35.1443383 C293.342778,1.81111414 137.33377,1.81111414 0,1.81111414 L0,150 L1920,150 L1920,1.81111414 C1739.53523,-16.6853983 1679.86404,73.1607868 1389.7826,37.4859505 C1099.70117,1.81111414 981.704672,-7.57670281 826.337463,25.5396311 Z" fill="#0b1827" style=""></path>
		</svg>
	</div> -->
<div class="container">

	<div class="sub-container">

		<h2 class="terms-padding">About Us</h2>

		<div class="inner-content">
			<!-- <p class="p-padding">Every company has a story to tell. Although ours is just starting, it is rather fascinating tale of how we are forced evolved beyond the blueprint of our already mapped out journey.</p>

			<p class="p-padding">Arbitrage aimed to be a private online facility to cater our individual stock trading requirements. Having found the great limitations of meticulously developing our trading tools via MS Excel and other similar tools, we gave the idea of migrating such tools into its online equivalent. Using free online tools, we tried to hacked-in, improved and developed tools that we though will give us our competitive advantage as a Stock Trader. For one, the <strong class="hg-rainbow">Bid/Ask comparison</strong> which used to automatically extract online data and feed it in a form of a report via google sheets now has web-based equivalent we call the <strong class="hg-rainbow">Bid/Ask Bar.</strong> The tailor made <strong class="hg-rainbow">trading journal</strong> showed its real power when its website equivalent came into form.</p>

			<p class="p-padding">As we are to complete the migration of our offline tools into its online counterparts, we noticed that there are <strong class="hg-rainbow">too many other possibilities open</strong> if we keep moving forward. So, instead of being satisfied with the tool migration plan, we continue to develop other tools which we deemed helpful to our trading journey. The online platform crossed-out the limits of our MS Excel tools. Now we have the ability to automate everything. Now, we call-out data elsewhere and make a market summary report out of those. Algorithms can make things possible. Now we can gauge a fool-proof <strong class="hg-rainbow">market sentiments</strong>, a clear picture of <strong class="hg-rainbow">supply and demand</strong>, an automated <strong class="hg-rainbow">risk management</strong> tool, a <strong class="hg-rainbow">trading dairy</strong> with a dynamic dashboard reporting and so much more.</p>

			<p class="p-padding">After these realizations, our mission shifted. What used to be a <strong class="hg-rainbow">personal goal became organizational</strong> and, from there it transcended somewhere bigger than all of us combined. A vision pop-out. What we plan to arm ourselves now became a mission of arming everyone else. That, with a thought in mind that, the beauty we saw will be seen by everyone else.</p>

			<p class="p-padding">We gave a select group of people a peek of what we have developed so far and instantly saw the glare in their eyes, the same glare present in ours everytime we look at <strong class="hg-rainbow">Arbitrage</strong>. It was privilege. Something we will forever hold in high regard. We have done <strong class="hg-rainbow">something right</strong>.</p>	

			<p class="p-padding">The real journey is about to begin. We know inside that it is going to be exciting. As we <strong class="hg-rainbow">write our story</strong>, we invite you to come take this journey with us. We will traverse off the beaten track and leave a trail for everyone else to follow. We will cultivate tools and approach way beyond the TA prevalent highway. We will make everyone see how other fronts prove effective and efficient to attaining a successful trading journey. Tools like <strong class="hg-rainbow">fair market value calculator</strong> is in pipeline. Research and barney style explanations, understanding business dynamics, sales cycle, enterprise seasonality and the strengths and weaknesses of each industries.  A glimpse of how economies work, how money works, all in a easy to understand and painless to navigate online trading platform.</p>

			<p class="p-padding">The road ahead is long, we can use some company. <a href="/login/" style="color:cyan;"><strong>Join us!</strong></a></p> -->
			<p class="p-padding">Every company has a story to tell. Although ours is just starting, it is rather a fascinating tale of how we are forced to evolve beyond the blueprint of our already mapped-out journey.</p>
			
			<h4 class="sub-topics">Our aim </h4>
			
			<p class="p-padding">Arbitrage aims to be a private online facility to cater to our stock trading requirements. Having found the great limitations of meticulously developing our trading tools via MS Excel and other similar tools, we give the idea of migrating such tools into its online equivalent. Using free online tools, we tried to hack on, improve and develop tools that we thought will give us our competitive advantage as a Stock Trader. For one, the <strong>Bid/Ask comparison</strong> which used to automatically extract online data and feed it in a form of a report via google sheets now has web-based equivalent we call the <strong>Bid/Ask Bar.</strong> The tailor-made <strong>trading journal</strong> showed its real power when its website equivalent came into form.</p>
			
			<h4 class="sub-topics">We are getting out of the box.</h4>
			
			<p class="p-padding">As we are to complete the migration of our offline tools into its online counterparts, we noticed that there are <strong>too many other possibilities open</strong> if we keep moving forward. So, instead of being satisfied with the tool migration plan, we continue to develop other tools which we deemed helpful to our trading journey. The online platform cross out the limits of our MS Excel tools. We can automate everything. Now, we call out data elsewhere and make a market summary report out of those. Algorithms can make things possible. Now, we can gauge a fool-proof <strong>market sentiments</strong>, a clear picture of <strong>supply and demand</strong>, an automated <strong>risk management tool</strong>, a <strong>trading diary</strong> with a dynamic dashboard reporting and so much more.</p>
			
			<h4 class="sub-topics">Our vision has finally zoomed out.</h4>
			
			<p class="p-padding">After these realizations, our mission shifted. What used to be a <strong>personal goal became organizational</strong> and, from there it transcended somewhere bigger than all of us combined. A vision pop-out. What we plan to arm ourselves now became a mission of arming everyone else. That, with a thought in mind that the beauty we saw will be seen by everyone else. We gave a select group of people a peek of what we have developed so far and instantly saw the glare in their eyes, the same glare present in ours every time we look at <strong>Arbitrage</strong>. It was a privilege. Something we will forever hold in high regard. We have done <strong>something right</strong>.</p>
		
			<h4 class="sub-topics">This is merely our humble beginning.</h4>
			
			<p class="p-padding">The real journey is about to begin. We know that it is going to be exciting. As we <strong>write our story</strong>, we invite you to come to take this journey with us. We will traverse off the beaten track and leave a trail for everyone else to follow. We will cultivate tools and approach way beyond the TA prevalent highway. We will make everyone see how other fronts prove effective and efficient to attaining a successful trading journey. Tools like <strong>fair market value calculator</strong> are in the pipeline. Research and barney style explanations, understanding business dynamics, sales cycle, enterprise seasonality and the strengths and weaknesses of each industry. A glimpse of how economies work, how money works, all easy to understand and painless to navigate online trading platform.</p>
			
			<p class="p-padding">The road ahead is long, we can use some company. <a href="/login/" class="a-color-pink"><strong>Join us!</strong></a></p>
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
		<!-- <span class="ddot">•</span> -->
		<!-- <a href="/FAQ/">FAQ</a> -->
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
strong {
    font-weight: 900;
}
</style>

<?php get_footer();