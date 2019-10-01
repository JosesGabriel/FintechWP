<?php

	/*

	* Template Name: Pricing page

	* Template page for Dashboard Social Platform

	*/



// get_header();

include 'phpsimpledom/simple_html_dom.php';

global $current_user;

$user = wp_get_current_user();

$userID = $current_user->ID;

get_header( 'dashboard' );



date_default_timezone_set('Asia/Manila'); ?>

<?php get_template_part('parts/global', 'css'); ?>
<link rel="stylesheet" href="/wp-content/themes/arbitrage-child/animate-style.css" type='text/css' />
<style type="text/css">
	html {
		background: linear-gradient(90deg, #0d1f33 0%,#0d1f33 0%,#12263b 0%,#152c43 100%) !important;
		background: #0d1f33 !important;
	}
	.cv-head img {
	    top: -13px;
	    display: block;
	    position: relative;
	    width: 240px;
    	transform: translate(46px, 208px);
	}
	.cv-head {
	    background-image: url(/svg/headiss-temp.svg);
	    background-size: cover;
	    background-position: bottom;
	    width: 100%;
	    height: 628px;
	}	
	.cv-headcont {
	    width: 100%;
	    height: 100%;
	}
	.cv-headerdesc h2 {
	    text-transform: uppercase;
	    font-family: 'Roboto', sans-serif;
	    font-size: 2.4rem;
	    line-height: 1;
	    font-weight: 200;
	    color: #f5f6f6;
	    text-shadow: 4px 3px 4px #0d1620;
	    text-align: right;
	}
	.cv-headerdesc p {
		color: #d8d8d8;
		font-size: 17px;
	    line-height: 1.4;
	    text-align: right;
	    padding-left: 50px;
	}
	.cv-desccont {
	    margin: auto;
	    display: block;
	    transform: translateY(166px);
	    padding: 10px 10px;
	}
	.cv-imgcont {
	    display: inline-block;
	    width: 100%
	}
	.cv-headerdesc {
	    height: 100%;
	}
	.cv-featureinner.is-left {
    	padding: 0 0 0 100px;
	    margin: 97px auto;
	}
	.cv-featureinner.is-right {
    	padding: 0 100px 0 0;
		margin: 7em auto;
	}
	.cv-featureinner .cv-title {
		-webkit-background-clip: text !important;
		-webkit-text-fill-color: transparent !important;
		background: linear-gradient(to right, #ee964b 0%, #ff6f59 0%, #f02d3a 13%, #e71d3d 50%, #dd0426 50%);
		padding: 0;
	    margin: 0;
	    font-size: 27px;
	    font-weight: 700;
	    font-family: 'Roboto', sans-serif;
		/*background: linear-gradient(to right, #30CFD0 0%, #330867 100%);*/
	}
	.cv-bodybottom {
		margin: 0 auto;
	}
	.cv-bodybottom h2 {
		text-align: center;
		color: #fff;
	    font-size: 40px;
	}
	.cv-bodytitle {
		margin: 0 auto;
	}
	.cv-bodytitle h2 {
		text-align: center;
		color: #fff;
	    font-size: 40px;
	}
	.cv-bodybottom p {
	    text-align: center;
	    width: 63%;
	    margin: 0 auto;
	}
	.cv-bodybottom {
		margin-bottom: 41px;
	}
	.bodybottom-bback {
	    margin-top: 100px;
	}
	.cv-chat, .cv-chart, .cv-social, .cv-journal {
	    height: 339px;
	}
	.bbbackground {
		background: #081728;
		overflow: hidden;
	}
	.con-asb {
		padding-top: 34px !important;
		padding-bottom: 45px !important;
	}
	._nam_var p {
	    margin: 0;
	    font-size: 40px;
	    font-weight: 700;
	    line-height: 1.3;
	    text-align: center;
	    -webkit-background-clip: text !important;
	    -webkit-text-fill-color: transparent !important;
	        background: linear-gradient(157deg, #ee964b 0%, #ff6f59 0%, #f02d3a 46%, #e71d3d 60%, #dd0426 100%);
	}
	._nam_bs p {
	    margin: 0;
	    font-size: 40px;
	    font-weight: 700;
	    line-height: 1.3;
	    text-align: center;
	    -webkit-background-clip: text !important;
	    -webkit-text-fill-color: transparent !important;
	        background: linear-gradient(157deg, #ee964b 0%, #ff6f59 0%, #f02d3a 46%, #e71d3d 60%, #dd0426 100%);
	}
	._nam_avp p {
	    margin: 0;
	    font-size: 40px;
	    font-weight: 700;
	    line-height: 1.3;
	    text-align: center;
	    -webkit-background-clip: text !important;
	    -webkit-text-fill-color: transparent !important;
	        background: linear-gradient(157deg, #ee964b 0%, #ff6f59 0%, #f02d3a 46%, #e71d3d 60%, #dd0426 100%);
	}
	._nam_var span {
	    font-size: 25px;
	    font-weight: 300;
	    line-height: .5;
	    text-align: center;
	    display: block;
	}
	._nam_bs span {
	    font-size: 25px;
	    font-weight: 300;
	    line-height: .5;
	    text-align: center;
	    display: block;
	}
	._nam_avp span {
	    font-size: 25px;
	    font-weight: 300;
	    line-height: .5;
	    text-align: center;
	    display: block;
	}
	._nam_var {
	    /*display: inline-block;
	    top: -153px;
	    position: absolute;
	    left: 71px;*/
    	margin-top: 10px;
	}
	._nam_bs {
	    /*display: inline-block;
	    position: relative;
	    margin-top: -34px;
	    left: -52px;*/
    	margin-top: 10px;
	}
	._nam_avp {
	    /*position: absolute;
	    display: inline-block;
	    top: -101px;
	    right: -8px;*/
    	margin-top: 10px;
	}
	.bbbackground {
	    background-color: #081728 !important;
	    background: url(/svg/overlay_cs.png) no-repeat -7% 18%, url(/svg/overlay_cs.png) no-repeat bottom right;
	    background-size: 29%;
	    background-attachment: fixed;
	}
	.free-csv img {
	    margin: 0 auto;
	    display: block;
	    width: 75%;
	    position: relative;
	    top: -27px;
	}
	.free-csv {
	    border-radius: 10px 10px 0px 0px;
	    text-align: center;
	}
	.prc-attributecenter ul li {
	    list-style: none;
	    padding-bottom: 10px;
	    padding-top: 10px;
		list-style: none;
	    font-size: 16px;
	    font-weight: 500;
	}
	.prc-attributecenter ul {
	    padding: 14px 30px 35px 30px;
	    background-color: #f9e5e8 !important;
	    background: url(/svg/overlay_cs.png) no-repeat;
	    background-size: 100%;
		background-position: 38px bottom;
	    color: #081728;
	    border-radius: 0 0 10px 10px;
	}
	.prc-attributecenter ul li img {
	    width: 16px;
	    float: right;
	    margin-top: 4px;
	    display: inline-block;
	}
	.pric-btn {
		text-align: center;
	    margin: 0 0 0 0;
	    padding-bottom: 16px;
	    color: #fff;
	}
	.pric-btn span p {
		margin: 0;
	    font-size: 50px;
	    font-weight: 300;
	    line-height: 1;
	    font-family: 'Century gothic';
	    color: #fff;
	}
	.pric-btn span {
	    display: inline-flex;
	    margin-left: -18px;
		font-size: 12px;
	}
	.freebtn a {
	    padding: 11px 27px;
		background-image: -moz-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		background-image: -webkit-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		background-image: -ms-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		box-shadow: 0px 3px 7px 0px rgba(0, 0, 0, 0.35);
	    border-radius: 30px;
	    font-size: 17px;
	    color: #fff !important;
	    cursor: pointer;
	}
	.freebtn {
		text-align: center;
		margin-top: 61px;
	}
	.prembtn a {
	    padding: 11px 27px;
		background-image: -moz-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		background-image: -webkit-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		background-image: -ms-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		box-shadow: 0px 3px 7px 0px rgba(0, 0, 0, 0.35);
	    border-radius: 30px;
	    font-size: 17px;
	    color: #fff !important;
	    cursor: pointer;
	}
	.prembtn {
		text-align: center;
		margin-top: 61px;
	}
	.prembtn.wcoupon {
		text-align: center;
		margin-top: 46px;
	}
	.prembtn.wcoupon a{
		cursor: pointer;
	}
	.prembtn.wcoupon a:hover {
		background: none !important;
	    border: solid 2px rgb(240,45,58);
	    color: rgb(240,45,58) !important;
	    font-weight: 500;
	    background-image: -moz-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
	    background-image: -webkit-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
	    background-image: -ms-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		transition-duration: 0.3s;
	}
	.prembtn a:hover {
		background: none !important;
	    border: solid 2px rgb(240,45,58);
	    color: rgb(240,45,58) !important;
	    font-weight: 500;
	    background-image: -moz-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
	    background-image: -webkit-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
	    background-image: -ms-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		transition-duration: 0.3s;
	}
	.freebtn a:hover {
		background: none !important;
	    border: solid 2px rgb(240,45,58);
	    color: rgb(240,45,58) !important;
	    font-weight: 500;
	    background-image: -moz-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
	    background-image: -webkit-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
	    background-image: -ms-linear-gradient( 146deg, rgb(238,150,75) 0%, rgb(255,111,89) 8%, rgb(240,45,58) 49%, rgb(231,29,61) 70%, rgb(221,4,38) 100%);
		transition-duration: 0.3s;
	}
	.free-csv a {
	    font-size: 28px;
	    font-weight: 500;
	    color: #00abc1 !important;
	    background-color: none !important;
	    top: -10px;
	    position: relative;
	}
	.free-csv .premin {
	    font-size: 28px;
	    font-weight: 500;
	    margin: 0;
	    top: -10px;
	    position: relative;
		-webkit-background-clip: text !important;
	    -webkit-text-fill-color: transparent !important;
    	background: linear-gradient(to right, #f44336, #e91e63, #9c27b0, #673ab7, #00abc1, #2196f3, #00bcd4);
	}
	.cp-safs {
	    box-shadow: 0px 6px 10px -7px rgba(1,11,23,1);
	}
	.cv-bodybottom p {
	    line-height: 1.2;
	}
	.cal-container {
	    margin: 0 auto;
	}
	img.imgcalc.aveprice {
		width: 80%;
	    margin: 0 auto;
	    display: block;
	}
	img.imgcalc.calc {
		width: 80%;
	    margin: 0 auto;
	    display: block;
	}
	img.imgcalc.bsell {
		width: 80%;
	    margin: 0 auto;
	    display: block;
	}
	.zxcz {
	    font-size: 21px;
	    border: 2px solid;
	    border-radius: 40px;
	    padding: 6px 38px;
	    margin-left: 6px;
	    cursor: pointer;
	}
	.zxfree:hover {
	    transition-duration: 0.5s;
	    background: #ee2f3b;
	    border: #ee2f3b 2px solid;
	    color: #fff !important;
	}
	.zxfree {
	}
	.zxprem {
	    background-color: #ee2f3b;
	    border-color: #ee2f3b;
	    color: #fff !important;
	}
	._00asx {
	    text-align: right;
	    display: block;
	    padding-top: 24px;
	}
	.-xac {
		font-size: 22px;
	    font-weight: 600;
	    top: -10px;
	    display: block;
	    text-align: center;
	    line-height: 1;
	    margin-top: 18px;
	    margin-bottom: 20px;
	}
	.-zxac {
	    font-size: 22px;
	    font-weight: 600;
	    top: -10px;
	    display: block;
	    text-align: center;
	    line-height: 1;
	    margin-top: 19px;
	    margin-bottom: 20px;
	}
	.free-zxa {
		background-image: -moz-linear-gradient( -41deg, rgb(16,38,60) 0%, rgb(26,58,90) 100%);
		background-image: -webkit-linear-gradient( -41deg, rgb(16,38,60) 0%, rgb(26,58,90) 100%);
		background-image: -ms-linear-gradient( -41deg, rgb(16,38,60) 0%, rgb(26,58,90) 100%);
	}
	.prem-zxa {
		background-image: -moz-linear-gradient( 139deg, rgb(255,111,89) 0%, rgb(219,80,74) 40%, rgb(240,45,58) 70%, rgb(231,29,61) 83%, rgb(221,4,38) 100%);
		background-image: -webkit-linear-gradient( 139deg, rgb(255,111,89) 0%, rgb(219,80,74) 40%, rgb(240,45,58) 70%, rgb(231,29,61) 83%, rgb(221,4,38) 100%);
		background-image: -ms-linear-gradient( 139deg, rgb(255,111,89) 0%, rgb(219,80,74) 40%, rgb(240,45,58) 70%, rgb(231,29,61) 83%, rgb(221,4,38) 100%);
	}
	.premin small {
	    font-size: 16px !important;
	    margin-top: 0px;
	    display: block;
	}
	.inner-placeholder {
		overflow: hidden;
	}
</style>

<div id="main-content" class="ondashboardpage">

	<div class="inner-placeholder">

		<div class="row justify-content-md-center">
		<div class="cv-head">
			<div class="cv-headcont">
				<div class="container">
					<div class="row">
						<div class="col-md-7">
							<!-- <img src="/svg/features.png"> -->
						</div>
						<div class="col-md-5">
							<div class="cv-headerdesc">
				    			<div class="cv-desccont">
									<h2 class="animated bounceInRight faster"><strong>Boost</strong> <span>your skills,<br> not your <strong>expense</strong>.</span></h2>
									 
				    				<p>Our robust platform can amplify your stock trading skills at a pocket-friendly rate.</p>
				    				
				    				<span class="_00asx">
				    					<a class="zxcz zxfree">Try Free</a>
				    					<a class="zxcz zxprem">Premium</a>
				    				</span>
								</div>
							</div>
							<!-- <div class="cv-imgcont">
								<img src="/svg/cv-headerimg.svg">
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

		<div class="cv-bodyfeatures">
			<div class="container">
				<div class="row">
					<div class="cv-bodytitle">
						<h2>FEATURES</h2>
					</div>
					<div class="cv-chart row">
						<div class="col-md-6">
							<img src="/svg/chart-fin.png" draggable="false" class="animated bounceInLeft slower">
						</div>
						<div class="col-md-6">
							<div class="cv-featureinner is-right">
								<p class="cv-title">Interactive Chart</p>
								<p>Compact with all your charting tools, reliable market data and so much more. Now you can monitor Price Fluctuations, Bid & Ask Volume, Market Sentiments and other market data in a single page. </p>
							</div>
						</div>
					</div>
					<div class="cv-chat row">
						<div class="col-md-6">
							<div class="cv-featureinner is-left">
								<p class="cv-title">Vyndue Chat</p>
								<p>Share ideas swiftly via your selection of closely-knit trading community. Now you have the power to silence the noise by creating and joining highly moderated private chatrooms equipt with a live connection to market data. You can call-in market information like stock price, volume, fluctuations and even relevant news right into your groups chats.</p>
							</div>
						</div>
						<div class="col-md-6">
							<img src="/svg/chat-fin.png" draggable="false" class="animated bounceInRight slower">
						</div>
					</div>
					<div class="cv-social row">
						<div class="col-md-6">
							<img src="/svg/social-fin.png" draggable="false" class="animated bounceInLeft slower">
						</div>
						<div class="col-md-6">
							<div class="cv-featureinner is-right">
								<p class="cv-title">Social</p>
								<p>Gather ideas by following your respected traders. Be inspired by their success and learn from their shortcomings. In the same way, you can also share your thoughts with ease, develop a solid following & see insightful feedbacks from your circle. This is the SocMed fit for traders. </p>
							</div>
						</div>
					</div>
					<div class="cv-journal row">
						<div class="col-md-6">
							<div class="cv-featureinner is-left">
								<p class="cv-title">Trade Journal</p>
								<p>Record your trading activities effortlessly and with fun. We will deliver back your data in an image-rich analytics report for your easier appreciation. This is a distinctive trading diary like you have never seen before.</p>
							</div>
						</div>
						<div class="col-md-6">
							<img src="/svg/journal-fin.png" draggable="false" class="animated bounceInRight slower">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bodybottom-bback">
			<div class="bbbackground">
				<div class="container con-asb">
					<div class="row">
						<div class="cv-bodybottom">
							<h2>POWER TOOLS</h2>
							<p>Make numbers your friend. Learn how size and price can affect your every move before it happens, as it happens and after it happens. </p>
						</div>
						<!-- <div class="cal-container"></div> -->
					</div>
						<div class="row">
							<div class="col-md-4">
						    <img src="/svg/calc.svg" draggable="false" class="imgcalc calc animated fadeInLeft slow">
								<div class="_nam_var">
									<p>VAR</p>
									<span>Calculator</span>
								</div>
							</div>
							<div class="col-md-4">
						    <img src="/svg/aveprice.svg" draggable="false" class="imgcalc aveprice animated fadeInUp slow">
								<div class="_nam_avp">
									<p>AVERAGE PRICE</p>
									<span>Calculator</span>
								</div>
							</div>
							<div class="col-md-4">
						    <img src="/svg/bsell.svg" draggable="false" class="imgcalc bsell animated fadeInRight slow">
								<div class="_nam_bs">
									<p>BUY/SELL</p>
									<span>Calculator</span>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	
		<div class="inner-main-content">
			<div class="container">
					<div class="cv-bodybottom">
						<h2>PRICING</h2>
						<p>For the price of <strong style="color: #e47349;">2 milk teas</strong>, <br>you get  access to the <strong style="color: #e47349;">most powerful stock trading platform</strong> yet.</p>
					</div>
				<div class="row justify-content-md-center">
					
					<div class="col-md-4">
						<div class="cp-safs">
							<div class="free-csv free-zxa">
								<img src="/svg/free-stis.svg" draggable="false">
								<div class="pric-btn">
									<span>Php <p>00.00</p></span>
									<div class="mosnf">monthly</div>
								</div>
							</div>
							<div class="prc-1 prc-attributecenter">
								<ul>
									<a class="-xac">FREE</a>
									<li><span>Social</span><img src="/svg/checkbl.svg"></li>
									<li><span>Chat</span><img src="/svg/checkbl.svg"></li>
									<li><span>News</span><img src="/svg/checkbl.svg"></li>
									<li><span>Chart</span><img src="/svg/checkbl.svg"></li>
									<li><span>Games</span><img src="/svg/checkbl.svg"></li>
									<li><span>Journal</span><img src="/svg/checkbl.svg"></li>
									<li><span>Buy/Sell Calculator</span><img src="/svg/checkbl.svg"></li>
									<li><span>Watchers & Alerts</span><img src="/svg/exred.svg"></li>
									<li><span>Average Price Calculator</span><img src="/svg/exred.svg"></li>
									<li><span>VAR Calculator</span><img src="/svg/exred.svg"></li>
									<li><span>Ad Free</span><img src="/svg/exred.svg"></li>
									
									
									<div class="freebtn"><a>Subscribe now!</a></div>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="cp-safs">
							<div class="free-csv prem-zxa">
								<img src="/svg/prem-stick.svg" draggable="false">
								<div class="pric-btn">
									<span>Php <p>359.40</p></span>
									<div class="mosnf">monthly</div>
								</div>
							</div>
							<div class="prc-2 prc-attributecenter">
								<ul>
									<p class="premin -zxac">PREMIUM<br><small>with discount coupon</small></p>
									<li><span>Social</span><img src="/svg/checkbl.svg"></li>
									<li><span>Chat</span><img src="/svg/checkbl.svg"></li>
									<li><span>News</span><img src="/svg/checkbl.svg"></li>
									<li><span>Chart</span><img src="/svg/checkbl.svg"></li>
									<li><span>Games</span><img src="/svg/checkbl.svg"></li>
									<li><span>Journal</span><img src="/svg/checkbl.svg"></li>
									<li><span>Buy/Sell Calculator</span><img src="/svg/checkbl.svg"></li>
									<li><span>Watchers & Alerts</span><img src="/svg/checkbl.svg"></li>
									<li><span>Average Price Calculator</span><img src="/svg/checkbl.svg"></li>
									<li><span>VAR Calculator</span><img src="/svg/checkbl.svg"></li>
									<li><span>Ad Free</span><img src="/svg/checkbl.svg"></li>

									<div class="prembtn wcoupon"><a>Enter Coupon</a></div>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="cp-safs">
							<div class="free-csv prem-zxa">
								<img src="/svg/prem-stick.svg" draggable="false">
								<div class="pric-btn">
									<span>Php <p>599.40</p></span>
									<div class="mosnf">monthly</div>
								</div>
							</div>
							<div class="prc-2 prc-attributecenter">
								<ul>
									<p class="premin -zxac">PREMIUM</p>
									<li><span>Social</span><img src="/svg/checkbl.svg"></li>
									<li><span>Chat</span><img src="/svg/checkbl.svg"></li>
									<li><span>News</span><img src="/svg/checkbl.svg"></li>
									<li><span>Chart</span><img src="/svg/checkbl.svg"></li>
									<li><span>Games</span><img src="/svg/checkbl.svg"></li>
									<li><span>Journal</span><img src="/svg/checkbl.svg"></li>
									<li><span>Buy/Sell Calculator</span><img src="/svg/checkbl.svg"></li>
									<li><span>Watchers & Alerts</span><img src="/svg/checkbl.svg"></li>
									<li><span>Average Price Calculator</span><img src="/svg/checkbl.svg"></li>
									<li><span>VAR Calculator</span><img src="/svg/checkbl.svg"></li>
									<li><span>Ad Free</span><img src="/svg/checkbl.svg"></li>

									<div class="prembtn"><a>Subscribe now!</a></div>
								</ul>
							</div>
						</div>
					</div>
					
				</div>
			</div>

		</div>
	<br>
	<br>
	</div>

</div>


<?php



get_footer();
