<?php
	/*
	* Template Name: Search Tab

	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>



<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>




<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.js"></script>
<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.min.js"></script>
<link href="../calendar-assets/bootstrap-year-calendar.css" rel="stylesheet">
<link href="../calendar-assets/bootstrap-year-calendar.min.css" rel="stylesheet">


<link rel="stylesheet" type="text/css" href="/wp-content/themes/divi-child/tradelogs.css">


<div id="main-content" class="oncommonsidebar">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="post-content">
						<div>
							<div class="row">
								<div class="col-md-12">
						            <div class="panel panel-primary">
						               <div class="panel-heading">
						                    
						                    <span class="">
						                        <!-- Tabs -->
						                         <ul class="nav panel-tabs">
						                            <li class="active"><a href="#tab1" data-toggle="tab" class="active show">
						                            	<img src="/svg/layout.svg" style="width: 19px;vertical-align: sub;height: 18px;"> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">All</span></a></a></li>
						                            <li class=""><a href="#tab2" data-toggle="tab"> <img src="/svg/user-outline.svg" style="width: 19px;vertical-align: sub;height: 18px;"> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">People</span></a></li>
						                            <li class=""><a href="#tab3" data-toggle="tab" class=""> <img src="/svg/bar-chart.svg" style="width: 19px;vertical-align: sub;height: 18px;"> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">Stocks</span></a></li>
						                            <li class=""><a href="#tab4" data-toggle="tab" class=""> <img src="/svg/edit1.svg" style="width: 19px;vertical-align: sub;height: 18px;"> <span style="padding-left: 3px;font-size: 13px;color: #fffffe;">Posts</span></a></li>
						                        </ul>
						                    </span>
						                </div>
						                <div class="panel-body">
						                    <div class="tab-content">
						                        <div class="tab-pane show active" id="tab1">
						                        	posts1
														
						                        </div>


						                        <div class="tab-pane" id="tab2">
													 
						                        	post2

						                        </div>
						                        
						                        <div class="tab-pane" id="tab3">
						                        	
						                        	post3

						                        </div>



						                        <div class="tab-pane" id="tab4">
						                        
						                        	post4

						                        </div>
						                    </div>
						                </div>
						            </div>
						        </div>
							</div>
						</div>

					</div>
				</div>
			</div>

			

			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->


<div class="script">

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>



</div>
<?php

get_footer('dashboard');
