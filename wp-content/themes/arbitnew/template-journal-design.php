<?php
	/*
	* Template Name: Journal Design Page
	* Template page for Journal Design Page
	*/
	get_header( 'dashboard' );
?>

<div id="main-content" class="oncommonsidebar">

	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">
						<div class="left-user-details">
							<div class="left-user-details-inner">
								<div class="side-header">
									<div class="left-image">
										<div class="user-image" style="background: url('<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>') no-repeat center center;">&nbsp;</div>
									</div>
									<div class="right-image">
										<div class="onto-user-name"><?php echo $current_user->display_name; ?></div>
										<div class="onto-user-meta-details">100 Following</div>
									</div>
								</div>
								<div class="side-content">
									<div class="side-content-inner">
										<ul>
											<li class="one"><a href="/dashboard/">Activities</a></li>
											<li class="two"><a href="#">Charts</a></li>
											<li class="three"><a href="/journal/">Journal</a></li>
											<li class="four"><a href="#">Screener</a></li>
											<li class="five"><a href="#">Watcher</a></li>
											<li class="six"><a href="#">Paper Trade</a></li>
											<li class="seven"><a href="#">Chat</a></li>
											<li class="eight"><a href="#">Groups</a></li>
											<li class="nine"><a href="#">Traders</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="thisparton">this is a test</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->

<?php

get_footer('dashboard');