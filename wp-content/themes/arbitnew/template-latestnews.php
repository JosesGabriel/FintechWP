<?php
/*
	* Template Name: Latest News Page
	* Template page for Dashboard Social Platform
	*/

// get_header();
include 'phpsimpledom/simple_html_dom.php';
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
require("news/header-files.php");
require("parts/global-header.php");
date_default_timezone_set('Asia/Manila'); ?>

<style type="text/css">
	.center-dashboard-part {
		float: left;
		width: 85%;
		margin-top: 10px;
	}
	.right-dashboard-part {
		float: left;
		width: 100% !important;
		padding: 21px 0px !important;
		height: 140%;
		position: -webkit-sticky;
		position: sticky;
		top: -177%;
	}
	.remm-sm {
		display: none;
		margin-top: -1px;
		position: absolute;
		background-color: #f9f9f9;
		box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
		z-index: 1;
		right: 22px;
		color: #fff;
		background-color: #2b405b;
		font-size: 10px;
		padding: 6px 10px;
		border-radius: 25px;
	}
	.drop-over-post {
		color: #6583a8;
		font-size: 20px;
		margin-top: 7px;
		margin-right: 7px;
	}
	.srr-tab-wrap>li.srr-active-tab {
		border-left: none !important;
		background: none !important;
	}
	.srr-tab-wrap li {
		border-radius: 0;
		margin: 0px 0px 0 0 !important;
		width: 100%;
		text-align: center;
		padding: 3px 7px !important;
	}
	.et_pb_widget ul li:hover {
		border-bottom: none !important;
		background: #12283f;
	}
	.srr-tab-wrap {
		margin: 0 !important;
		border: none !important;
		position: absolute;
		background: #142c46 !important;
		z-index: 2;
		right: 4px;
		padding: 0px !important;
		margin-top: -12px !important;
		border-radius: 4px;
		overflow: hidden;
		box-shadow: rgba(7, 13, 19, 0.42) 0px 2px 5px 0.1px;
	}
	.srr-tab-wrap>li {
		background: none;
		border-bottom: none !important;
		border: none;
		font-size: 11px;
		font-weight: 400;
		text-align: left;
		text-transform: uppercase;
	}
	.auto-height {
		height: 40px !important;
	}
	.arb_watchlst_cont table tbody tr td {
		text-align: left !important;
	}
	.vertical-box table tbody tr td div {
		display: block !important;
		padding-bottom: 3px !important;
	}
	.vertical-box table tbody tr td {
		padding-left: 6px;
	}
	.add-post .um-activity-wall .um-activity-body {
		background: #142c46;
	}
	.adsbygoogle {
		background: none;
		display: block;
		margin-top: 0;
		border-radius: 5px;
		overflow: hidden;
		padding-bottom: 0;
	}
	.adsbygoogles {
		background: none !important;
		display: block !important;
		margin-top: 0 !important;
		border-radius: 5px;
		overflow: hidden;
		padding-bottom: 0 !important;
	}
	.fa-plus-circle {
		color: #fffffe;
	}
	.srr-item-cont {
		display: block;
		padding-top: 0px;
		padding-left: 1px;
		padding-right: 13px;
		text-align: center;
		top: -1px;
		position: relative;
		margin-bottom: 7px;
		margin-top: 0px;
	}
	.srr-wrap .srr-item>* {
		margin-bottom: 0 !important;
	}
	.srr-wrap .srr-item {
		width: 90% !important;
	}
	time.srr-date {
		font-size: 18px !important;
		line-height: 1.1;
		font-weight: 300;
		color: #ffeb3b;
	}
	time.srr-date div {
		font-size: 11px !important;
		margin-top: -4px;
		text-transform: uppercase;
	}
	.srr-wrap .srr-item>* {
		margin-bottom: 7px;
	}
	.srr-wrap .srr-item>*:last-child {
		margin-bottom: 0px !important;
	}
	.dauthor {
		color: #878a8e;
	}
	.srr-wrap.srr-style-none .srr-item {
		display: -webkit-box !important;
	}
	.um-padding-none {
		padding-left: 18px;
	}
	.even .to-watch-data:last-child {
		border: none;
	}
	.et_fixed_nav.et_show_nav #page-container,
	.et_non_fixed_nav.et_transparent_nav.et_show_nav #page-container {
		padding-top: 0 !important;
	}
	.to-top-dropdown {
		float: right;
		font-size: 12px;
		color: #fffffe;
		line-height: 1.7;
		cursor: pointer;
	}
	.banner-try {
		background: #142c46;
		border-radius: 5px;
		padding-bottom: 12px;
		margin-top: 15px;
		display: none;
	}
	.cont-try-premium {
		padding: 0 14px;
	}
	.to-top-create {
		float: right;
		color: #6583a8;
	}
	.abcds {
		padding-right: 5px;
		padding-left: 5px;
	}
	.srr-wrap .dnewstitle {
		word-break: break-word;
		position: relative;
		width: 90%;
	}
	.srr-item .srr-item-cont {
		margin: 8px 0 !important;
	}
	.to-rss-inner {
		height: 240px;
		overflow-y: hidden;
		overflow-x: hidden;
	}
	.to-rss-inner:hover {
		overflow-y: scroll;
	}
	ul.srr-tab-wrap.srr-tab-style-none.srr-clearfix {
		height: 50px;
	}
	#main-content .container {
		padding-top: 0;
	}
	.to-top-title p {
		color: #fffffe;
		font-size: 17px !important;
		font-weight: 200 !important;
		padding-left: 5px;
		padding-top: 5px;
		padding-bottom: 5px !important;
		border-left: #ffeb3b solid 3px;
		font-family: 'Roboto', sans-serif;
		margin: 0;
	}
	.container {
		padding-right: 0;
		padding-left: 0;
	}
	.adsbygoogle .to-top-title {
		display: none;
	}
	.box-portlet {
		border: none;
	}
	.adsbygoogle .box-portlet-content {
		padding: 0 27px 27px 27px !important;
	}
	.adsbygoogles .box-portlet-content {
		padding: 0 27px 27px 27px !important;
	}
	.left-dashboard-part {
		position: sticky;
		top: 35px !important;
	}
	pre {
		background: #fff;
	}
</style>
<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>
<div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="left-dashboard-part-inner">
					<?php get_template_part('parts/sidebar', 'profile'); ?>
				</div>
			</div>
			<!-- <div class="center-dashboard-part" style="max-width: 800px;">
				<div class="center-dashboard-part-inner">
					<div class="container">
						<div class="row">
							<div class="col-md-12 abcds">
								<?php //get_template_part('parts/sidebar', 'stockslatestnews');
								?>
							</div>
						</div>
					</div>
					<div class="nws-container">
						               <div class="adsbygoogles">
					<div class="box-portlet">
						<div class="box-portlet-content">
							<small>ADVERTISEMENT</small>
							<div class="adscontainer">
							<img width="100%" src="<?php echo get_home_url(); ?>/ads/addsample728x90_<?php echo rand(1, 3); ?>.png">
							</div>
						</div>
					</div>
				</div>
					<?php
						$html = file_get_html('http://news.google.com/search?q=Philippine%20stock%20exchange&hl=en-PH&gl=PH&ceid=PH%3Aen');

						// titles
						$titles = [];
						foreach ($html->find('div.NiLAwe h3') as $key => $value) {
							$titles[$key] = $value->plaintext;
						}

						$desc = [];
						foreach ($html->find('div.NiLAwe span.xBbh9') as $key => $value) {
							$newdata = str_replace('bookmark_bordershare', '', $value->plaintext);
							$newdata = str_replace('more_vert', '', $newdata);
							$desc[$key] = $newdata;
						}

						$link = [];
						foreach ($html->find('div.NiLAwe a.VDXfz') as $key => $value) {
							$link[$key] = $value->href;
						}

						$link = array_unique($link);
						$link = array_values($link);

						$images = [];
						foreach ($html->find('div.NiLAwe img') as $key => $value) {
							$images[$key] = $value->src;

							if ($images < 1) {
								$images = preg_replace('/(<a\b[^><]*)>/i', '$1 style="xxxx:yyyy;">', $images);
							}
						}

						$source = [];
						foreach ($html->find('div.NiLAwe .wEwyrc') as $key => $value) {
							$source[$key] = $value->plaintext;
						}

						?>
						<div class="wh-container">
							<div class="nws-inner">
								<div class="container">
									<div class="nws-businesstitle">Business News</div>
									<div class="row msbusinesstit">
										first news
										<div class="col-md-8" style="padding-right: 10px;">
											<div class="nws-thumbnstopimg sss" style="background: url('<?php echo $images[0]; ?>');background-position: center center;background-size: cover;background-repeat: no-repeat;">
												<div class="nws-toptitle">
													<p><a href="https://news.google.com/<?php echo $link[0]; ?>" target="_blank"><?php echo (strlen($titles[0]) > 59 ? substr($titles[0], 0, 60) . '...' : $titles[0]) ?></a></p>
													<p class="ellpnews"><?php echo (strlen($desc[0]) > 200 ? substr($desc[0], 0, 200) . '...' : $desc[0]) ?></p>
													<p><?php echo (strlen($source[0]) > 25 ? substr($source[0], 0, 25) . '...' : $source[0]) ?></p>
												</div>
												<div class="ddtopimg" style="background: url('<?php echo $images[0]; ?>');background-position: center center;background-size: auto 100%;background-repeat: no-repeat;">
												</div>
											</div>
										</div>
										<div class="col-md-4" style="padding-left: 0px;">
											<div class="main-innertop">
												7 to 11
												<?php for ($topright = 1; $topright <= 4; $topright++) { ?>
													<div class="nws-conttype llll">
														<div class="nws-thumbns sss" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: cover;background-repeat: no-repeat;">
															<div class="ddimg" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
															</div>
														</div>
														<div class="nws-thumbnsdesc">
															<p><a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank"><?php echo (strlen($titles[$topright]) > 45 ? substr($titles[$topright], 0, 45) . '...' : $titles[$topright]) ?></a></p>
															<p class="ellpnews"><?php echo (strlen($desc[$topright]) > 33 ? substr($desc[$topright], 0, 33) . '...' : $desc[$topright]) ?></p>
															<p><?php echo (strlen($source[$topright]) > 25 ? substr($source[$topright], 0, 25) . '...' : $source[$topright]) ?></p>
															<p class="nws-toplinks"><a href="/bulletins/">/bulletins/</a></p>
														</div>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="row cisz" style="padding-top: 0px; margin-top: -3px;">
										<div class="hksi col-md-8">
											<div class="row">
												1 to 6
												<?php for ($topright = 5; $topright <= 8; $topright++) { ?>
													<div class="col-md-6" style="padding-right: 0px;">
														<div class="nws-part">
															<div class="img_sep">
																<div class="ccc" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
																</div>
															</div>
															<div class="nws-seprator">
																<div class="nws-title">
																	<p>
																		<strong>
																			<a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank">
																				<?php echo (strlen($titles[$topright]) > 51 ? substr($titles[$topright], 0, 51) . '...' : $titles[$topright]) ?></a>
																		</strong>
																	</p>
																</div>
																<div class="nws-description">
																	<p><?php echo (strlen($desc[$topright]) > 120 ? substr($desc[$topright], 0, 120) . '...' : $desc[$topright]) ?></p>
																	<p><?php echo $source[$topright]; ?></p>
																</div>
															</div>
														</div>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="nws-part col-md-4" style="margin-top: 0px;">
											<?php // get_template_part('parts/sidebar', 'ads');
											?>

											<div class="nws-part">
												<div class="img_sep">
													<div class="ccc" style="background: url('<?php echo $images[$topright]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
													</div>
												</div>
												<div class="nws-seprator">
													<div class="nws-title">
														<p>
															<strong>
																<a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank">
																	<?php echo (strlen($titles[$topright]) > 51 ? substr($titles[$topright], 0, 51) . '...' : $titles[$topright]) ?></a>
															</strong>
														</p>
													</div>
													<div class="nws-description">
														<p><?php echo (strlen($desc[$topright]) > 120 ? substr($desc[$topright], 0, 120) . '...' : $desc[$topright]) ?></p>
														<p><?php echo $source[$topright]; ?></p>
													</div>
												</div>
											</div>

											<?php //get_template_part('parts/sidebar', 'ads');
											?>

										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="nws-containersss">
							<div class="nws-inner">
								<div class="container">
									<?php //get_template_part('parts/sidebar', 'watchlistlatestnews');
									?>



								<div class="adsbygoogle">
								<div class="box-portlet row" style="padding: 0px 0%;">-->
									<!--<div class="tte-spons col-md-2">
										<h6>Sponsor</h6>
									</div>-->
									<!--	<div class="box-portlet-content col-md-10" style="padding: 0 !important;">-->
									<!-- <small>ADVERTISEMENT</small> -->
									<!--	<div class="adscontainer" style="width: 900px;">
										<img src="/ads/addsample728x90_1.png" style="width: 783px;padding-left: 16px;">
										</div>
									</div>
								</div>
							</div>

									<div class="nws-businesstitle">Market News</div>

									========================================= Second section ==============================================

									<div class="row">
										for 11
										<div class="col-md-4">
											<div class="main-innertop klaska">
												<div class="nws-part">
													<div class="img_sep" style="width: 252px;">
														<div class="ccc" style="background: url('<?php echo $images[19]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
														</div>
													</div>
													<div class="nws-seprator" style="width: 237px;height: 231px;">
														<div class="nws-title">
															<p>
																<strong>
																	<a href="https://news.google.com/<?php echo $link[$topright]; ?>" target="_blank">
																		<?php echo (strlen($titles[9]) > 51 ? substr($titles[9], 0, 51) . '...' : $titles[9]) ?></a>
																</strong>
															</p>
														</div>
														<div class="nws-description">
															<p><?php echo (strlen($desc[9]) > 120 ? substr($desc[9], 0, 120) . '...' : $desc[9]) ?></p>
															<p><?php echo $source[9]; ?></p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="nws-thumbnstopimg sss xls nws-part" style="background: url('<?php echo $images[10]; ?>');background-position: center center;background-size: cover;background-repeat: no-repeat;">
												<div class="nws-toptitle">
													<p><a href="https://news.google.com/<?php echo $link[10]; ?>" target="_blank"><?php echo (strlen($titles[10]) > 39 ? substr($titles[10], 0, 40) . '...' : $titles[10]) ?></a></p>
													<p class="ellpnews"><?php echo (strlen($desc[10]) > 199 ? substr($desc[10], 0, 200) . '...' : $desc[10]) ?></p>
													<p><?php echo (strlen($source[10]) > 25 ? substr($source[10], 0, 25) . '...' : $source[10]) ?></p>
												</div>
												<div class="ddtopimg" style="background: url('<?php echo $images[10]; ?>');background-position: center center;background-size: auto 100%;background-repeat: no-repeat;">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<?php for ($bottomnews = 11; $bottomnews <= 19; $bottomnews++) { ?>
											<div class="col-md-4" style="padding-right: 0px; margin-top: -10px;">
												<div class="main-innertop">
													<div class="nws-part">
														<div class="img_sep">
															<div class="ccc" style="background: url('<?php echo $images[$bottomnews]; ?>');background-position: center center;background-size: 100% auto;background-repeat: no-repeat;">
															</div>
														</div>
														<div class="nws-seprator">
															<div class="nws-title">
																<p>
																	<strong>
																		<a href="https://news.google.com/<?php echo $link[$bottomnews]; ?>" target="_blank">
																			<?php echo (strlen($titles[$bottomnews]) > 45 ? substr($titles[$bottomnews], 0, 45) . '...' : $titles[$bottomnews]) ?></a>
																	</strong>
																</p>
															</div>
															<div class="nws-description">
																<p><?php echo (strlen($desc[$bottomnews]) > 120 ? substr($desc[$bottomnews], 0, 120) . '...' : $desc[$bottomnews]) ?></p>
																<p><?php echo $source[$bottomnews]; ?></p>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>

				<style type="text/css">
				</style>
				<div class="banner-try">
					<div class="to-top-title">Sponsored <div class="to-top-create">Create ads</div>
						<hr class="style14 style15" style="width: 100% !important;margin-bottom: 9px !important;margin-top: 5px !important;/* margin: 5px 0px !important; */">
					</div>

					<div class="cont-try-premium">
						<img src="<?php echo get_home_url(); ?>//svg/try-primium.jpg">
					</div>
				</div>
				<br class="clear">
				</div>
				</div>
			</div> -->
		</div>
	</div>
</div>

<?php

get_footer();
