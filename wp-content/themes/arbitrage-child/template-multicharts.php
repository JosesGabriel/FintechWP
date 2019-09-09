<?php /* Template Name: Multichart Main Page */ ?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Arbitrage | Multicharts</title>
<link rel="shortcut icon" href="https://1948265747.rsc.cdn77.org/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" />
<style>
html, body {
	height:100%;
	margin:0;
	padding:0;
	background-color:#354960;
}
iframe {
	border:none;
	display:block;
}
</style>
</head>

<body>
<div>
		<div class="chart_logo_arbitrage"><a href="https://arbitrage.ph/" target="_blank"><img src="https://arbitrage.ph/wp-content/themes/arbitrage-child/images/arblogo_svg1.svg" style="width: 33px;"></a></div>

		<iframe style="border:0;width:100%;height: 40px;border-bottom: 4px #34495e solid;overflow: hidden;" scrolling="no" src="<?php echo $homeurlgen; ?>/stock-ticker/"></iframe>

		<?php //get_template_part('parts/global', 'css'); ?>

		<div class="arb_right_icons_trans">
			<?php /*?> Top Icons <?php */?>
			<ul class="main-drops-chart">
				<a href="#" class="arb-side-icon">
					<img src="<?php echo $homeurlgen; ?>/svg/menu.svg" style="width: 17px;display: inline-block;vertical-align: top;margin-top: 6px;">
				</a>
				<ul id="droppouts" style="box-shadow: 0px 2px 4px 1px rgba(7, 13, 19, 0.52);display: none;">
						<li><a href="#">Buy/Sell Calculator</a></li>
						<li><a href="#">VAR Calculator</a></li>
						<li><a href="#">Average Price Calculator</a></li>
						<li><a href="<?php echo get_home_url(); ?>/multicharts/">Multichart</a></li>
				</ul>
			</ul>
			<a href="<?php echo $homeurlgen; ?>/notifications/" class="arb-side-icon"><img src="<?php echo $homeurlgen; ?>/svg/bell.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 5px;"></a>
			<a href="<?php echo $homeurlgen; ?>/messages/" class="arb-side-icon"><img src="<?php echo $homeurlgen; ?>/svg/vyndue-newlogo-white.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 4px;"></a>
			<a href="<?php echo $homeurlgen; ?>/account/" class="arb-side-icon"><?php
				if ( $user ) : ?>
					<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" style="width: 24px;height: 24px;margin-left: 5px;" class="arb_proficon" />
				<?php else: ?>
					<i class="fas fa-user-tie"></i>
				<?php endif; ?></a>
			<div style="clear:both"></div>
		</div>    
	</div>
<div style="height:50%;">
    <iframe src="https://arbitrage.ph/multicharts/chart-part-1/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:left;"></iframe>
    <iframe src="https://arbitrage.ph/multicharts/chart-part-2/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:right;"></iframe>
</div>
<div style="clear:both"></div>
<div style="height:50%;">
    <iframe src="https://arbitrage.ph/multicharts/chart-part-3/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:left;"></iframe>
    <iframe src="https://arbitrage.ph/multicharts/chart-part-4/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:right;"></iframe>
</div>
</body>
</html>
