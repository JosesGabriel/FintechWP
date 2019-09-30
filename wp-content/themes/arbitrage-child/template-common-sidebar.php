<?php
	/*
	* Template Name: Tradelogs Page (Error)
	* Template page for Tradelogs Page 	
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );
include_once(get_template_directory().'/arphie-functions.php');
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,600i" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.js"></script>
<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.min.js"></script>
<link href="../calendar-assets/bootstrap-year-calendar.css" rel="stylesheet">
<link href="../calendar-assets/bootstrap-year-calendar.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="/wp-content/themes/divi-child/tradelogs.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);


      function drawChart() {

      	//current allocation
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Cash',  60000],
          ['$ISM',  20000],
          ['$IRC',  20000],
          ['$HLMC', 10000]
        ]);

        var options = {
          // title: 'My Daily Activities',
          colors: ['#f9926e', '#d26987', '#ab4b97', '#643f96'],
          legend: {
          	position: 'none'
          },
          backgroundColor: {
          	stroke: 'none'
          },
          pieHole: 0.4,
          backgroundColor:{
          	fill: '#35485f',
          	stroke: 'none'
          },
          pieSliceBorderColor:"transparent",
          pieSliceText: 'none',
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);

        //trade statistics
        var statsdata = google.visualization.arrayToDataTable([
          ['Task', 'Trade Statistics'],
          ['Win',     80],
          ['Loss',      20]
        ]);

        var statsoption = {
          // title: 'My Daily Activities',
          colors: ['green', 'red'],
          legend: {
          	position: 'bottom'
          },
          pieHole: 0.4,
          backgroundColor: {
          	fill: '#35485f',
          	stroke: 'none'
          },
          pieSliceBorderColor:"transparent",
        };

        var statchart = new google.visualization.PieChart(document.getElementById('statsdonut'));
        statchart.draw(statsdata, statsoption);


      }


    </script>

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
										<div class="onto-user-name"><?php echo um_user('full_name'); ?></div>
											<div class="onto-user-meta-details">100 Following</div>
									</div>
								</div>
								<div class="side-content">
									<div class="side-content-inner">
										<ul>
											<li class="two"><a href="/chart/">Interactive Chart</a></li>
											<li class="three"><a href="/journal/">Trading Journal</a></li>
											<li class="five"><a href="#">Watcher & Alerts</a></li>
											<li class="four"><a href="#">Stock Screener</a></li>
											<li class="one"><a href="#">Power Tools</a></li>
											<!-- <li class="six"><a href="#">Paper Trade</a></li> -->
											<!-- <li class="seven"><a href="#">Chat</a></li> -->
											<!-- <li class="eight"><a href="#">Groups</a></li> -->
											<!-- <li class="nine"><a href="#">Traders</a></li> -->
										</ul>

									<div class="side-content-enter-trade text-center">
											<a class="btn btn-lg btn-primary btn-tradelog" href="/enter-trade/">Enter Trade</a>
										</div> 
									</div>
									<div class="box-portlet-footer"></div>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
						                            <li class="active"><a href="#tab1" data-toggle="tab" class="active show">Dashboard</a></li>
						                            <li class=""><a href="#tab2" data-toggle="tab">Tradelogs</a></li>
						                            <li class=""><a href="#tab3" data-toggle="tab" class="">Ledger</a></li>
						                            <li class=""><a href="#tab4" data-toggle="tab" class="">Calendar</a></li>
						                        </ul>
						                    </span>
						                </div>
						                <div class="panel-body">
						                    <div class="tab-content">
						                        <div class="tab-pane show active" id="tab1">
						                        	<div class="row">
														<div class="col-md-7">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Portfolio Snapshot
																</div>
																<div class="box-portlet-content">
																	<div class="row">
																		<div class="col-md-6">
																			<div class="inner-portlet">
																				<div class="inner-portlet-title">Traiding Results</div>
																				<div class="inner-portlet-content">
																						<div class="row intosection">
																							<div class="col-md-7">Beginning Balance</div>
																							<div class="col-md-5 post-right-text">100,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">Year to Date P/L</div>
																							<div class="col-md-5 post-right-text">10,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">posrtfolio YTD %</div>
																							<div class="col-md-5 post-right-text">10.00%</div>
																						</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="inner-portlet">
																				<div class="inner-portlet-title">Fund Transfers</div>
																				<div class="inner-portlet-content">
																						<div class="row intosection">
																							<div class="col-md-7">Total Deposits</div>
																							<div class="col-md-5 post-right-text">50,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">Total Withdrawals</div>
																							<div class="col-md-5 post-right-text">10,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">Total Equity</div>
																							<div class="col-md-5 post-right-text">150,000.00</div>
																						</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<br class="clear">
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<div class="col-md-5">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Current Allocation
																</div>
																<div class="box-portlet-content">
																	<div class="row">
																		<div class="col-md-6">
																			<ul class="alloc-data">
																				<li>
																					<div class="data-color"><span class="color-cash">&nbsp;</span></div>
																					<div class="data-name">Cash</div>
																					<div class="data-price">60,000.00</div>
																				</li>
																				<li>
																					<div class="data-color"><span class="color-ism">&nbsp;</span></div>
																					<div class="data-name">$ISM</div>
																					<div class="data-price">20,000.00</div>
																				</li>
																				<li>
																					<div class="data-color"><span class="color-irc">&nbsp;</span></div>
																					<div class="data-name">$IRC</div>
																					<div class="data-price">20,000.00</div>
																				</li>
																				<li>
																					<div class="data-color"><span class="color-hlcm">&nbsp;</span></div>
																					<div class="data-name">$HLMC</div>
																					<div class="data-price">10,000.00</div>
																				</li>
																			</ul>
																		</div>
																		<div class="col-md-6">
																			<div class="charthere">
																				<div id="donutchart" style="width: 150px; height: 130px;"></div>
																			</div>
																		</div>
																		
																		<br class="clear">
																	</div>
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
													</div>

													<br class="clear">
													<div class="monthly">
														<div class="box-portlet">
															<div class="box-portlet-header">
																Monthly Performance
															</div>
															<div class="box-portlet-content">
																Latest 12 Months activit here
															</div>
															<div class="box-portlet-footer"></div>
														</div>
													</div>
													<br class="clear">

													 
													<div class="row">
														<div class="col-md-4">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Trade Statistics
																</div>
																<div class="box-portlet-content">
																	<div class="row">
																		<div class="col-md-12">
																			<ul class="onstats">
																				<li>
																					<div class="textleft">Total Trades</div>
																					<div class="textright">100</div>
																				</li>
																				<li>
																					<div class="textleft">Wins</div>
																					<div class="textright">80</div>
																				</li>
																				<li>
																					<div class="textleft">Loss</div>
																					<div class="textright">20</div>
																				</li>
																				<li>
																					<div class="textleft">Win Rate</div>
																					<div class="textright">80.00%</div>
																				</li>
																			</ul>
																		</div>
																		<div class="col-md-12">
																			<div class="charthere">
																				<div id="statsdonut" style="width: 260px; height: 200px;"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>

														<div class="col-md-8">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Strategy Statistics
																</div>
																<div class="box-portlet-content">
																	<div class="stats-info">
																		<div class="dstatstrade">
																			<ul>
																				<li class="headerpart">
																					<div>Emotions</div>
																					<div class="center">Trades</div>
																					<div class="center">Wins</div>
																					<div class="center">Loses</div>
																					<div class="center">Win Rate</div>
																				</li>
																				<li>
																					<div>Neutral</div>
																					<div class="center">11</div>
																					<div class="center">6</div>
																					<div class="center">5</div>
																					<div class="center">54.00%</div>
																				</li>
																				<li>
																					<div>Greedy</div>
																					<div class="center">40</div>
																					<div class="center">18</div>
																					<div class="center">22</div>
																					<div class="center">45.00%</div>
																				</li>
																				<li>
																					<div>Fearful</div>
																					<div class="center">10</div>
																					<div class="center">6</div>
																					<div class="center">4</div>
																					<div class="center">60.00%</div>
																				</li>
																				<li>
																					<div>Bored</div>
																					<div class="center">4</div>
																					<div class="center">2</div>
																					<div class="center">2</div>
																					<div class="center">50.00%</div>
																				</li>
																				<li>
																					<div>Excited</div>
																					<div class="center">55</div>
																					<div class="center">41</div>
																					<div class="center">14</div>
																					<div class="center">74.00%</div>
																				</li>
																				<li>
																					<div>Hopeful</div>
																					<div class="center">40</div>
																					<div class="center">37</div>
																					<div class="center">3</div>
																					<div class="center">92.00%</div>
																				</li>
																			</ul>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-6 border-right alocate-charts">
																			<h2>Trades | Wins | Losses</h2>
																			<div class="dcontent">
																				the chart here
																			</div>
																		</div>
																		<div class="col-md-6 alocate-charts">
																			<h2>Win Allocations</h2>
																			<div class="dcontent">
																				the chart here
																			</div>
																		</div>
																		<br class="clear">
																	</div>
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<br class="clear">
													</div>
													<br class="clear">
													<div class="expence-report">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Expence Report
																</div>
																<div class="box-portlet-content">
																	expence charts
																</div>
																<div class="box-portlet-footer"></div>
															</div>
													</div>
													<br class="clear">
													<div class="row">
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Daily Buy Volume (last 30 traiding days)
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Daily Buy Value (last 30 traiding days)
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
													</div>

													<br class="clear">
													<div class="d-adds">
														adds here
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Performance by Day of the Week
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Gross P&L (last 30 traiding days)
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
													</div>														
						                        </div>


						                        <div class="tab-pane" id="tab2">
													 
						                        	<!--Table-->
													<table id="tablePreview" class="table table-striped table-sm">
													<!--Table head-->
													  <thead>
													    <tr>
													      <th>No.</th>
													      <th>Stock</th>
													      <th>Strategy</th>
													      <th>Trade Plan</th>
													      <th>Emotion</th>
													      <th>Qty.</th>
													      <th>Buy Date</th>
													      <th>Ave Price</th>
													      <th>Sell Date</th>
													      <th>Performance</th>
													      <th>Outcome</th>
													      <th>P&L</th>
													    </tr>
													  </thead>
													  <!--Table head-->
													  <!--Table body-->
													  <tbody>
													    <tr>
													      <th scope="row">1</th>
													      <td>IRC</td>
													      <td>Bottom Picking</td>
													      <td>Swing Trade</td>
													      <td>Neutral</td>
													      <td>4,000</td>
													      <td>January 3, 2019</td>
													      <td>₱2.44</td>
													      <td>January 3, 2019</td>
													      <td>8.11%</td>
													      <td>Gain</td>
													      <td>₱720.00</td>

													    </tr>
													   
													  </tbody>
													  <!--Table body-->
													</table>
													<!--Table-->

													<br class="clear">

													<div class="totalpl">
														 <p>Total P/L to date: <span class="totalplscore">₱720.00</span></p>
													</div>

						                        </div>
						                        
						                        <div class="tab-pane" id="tab3">
						                        	  <!--Table-->
														<table id="tablePreview" class="table table-striped table-sm">
														  <!--Table head-->
														  <thead>
														    <tr>
														      <th>Monthly Perfomance</th>
														      <th>Starting Balance</th>
														      <th>Perfomance</th>
														      <th>Profit/Loss</th>
														      <th>Withdrawals</th>
														      <th>Deposits</th>
														      <th>Ending Balance</th>
														    </tr>
														  </thead>
														  <!--Table head-->
														  <!--Table body-->
														  <tbody>
														    <tr>
														      <th scope="row">January</th>
														      <td>₱100,000.00</td>
														      <td>15.20%</td>
														      <td>₱15,199.00</td>
														      <td>₱20,000.00</td>
														      <td>0.00</td>
														      <td>₱19,199.00</td>
														    </tr>
														    
														  </tbody>
														  
														  <tfoot>
														    <tr>
														      <td>Total</td>
														      <td>&nbsp;</td>
														       <td>&nbsp;</td>
														       <td>₱15,199.00</td>
														       <td>₱20,000.00</td>
														      <td>₱10,000.00<td>
														      
														    </tr>
														  </tfoot>
														  <!--Table body-->
														</table>
														<!--Table-->

													<br class="clear">

													<!-- <div class="totalpl">
														 <p>Total P/L to date: <span class="totalplscore">₱720.00</span></p>
													</div> -->

						                        </div>



						                        <div class="tab-pane" id="tab4">
						                        	<div data-provide="calendar"></div>
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


<script type="text/javascript">
	function editEvent(event) {
    jQuery('#event-modal input[name="event-index"]').val(event ? event.id : '');
    jQuery('#event-modal input[name="event-name"]').val(event ? event.name : '');
    jQuery('#event-modal input[name="event-location"]').val(event ? event.location : '');
    jQuery('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
    jQuery('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
    jQuery('#event-modal').modal();
}

function deleteEvent(event) {
    var dataSource = jQuery('#calendar').data('calendar').getDataSource();

    for(var i in dataSource) {
        if(dataSource[i].id == event.id) {
            dataSource.splice(i, 1);
            break;
        }
    }
    
    jQuery('#calendar').data('calendar').setDataSource(dataSource);
}

function saveEvent() {
    var event = {
        id: jQuery('#event-modal input[name="event-index"]').val(),
        name: jQuery('#event-modal input[name="event-name"]').val(),
        location: jQuery('#event-modal input[name="event-location"]').val(),
        startDate: jQuery('#event-modal input[name="event-start-date"]').datepicker('getDate'),
        endDate: jQuery('#event-modal input[name="event-end-date"]').datepicker('getDate')
    }
    
    var dataSource = jQuery('#calendar').data('calendar').getDataSource();

    if(event.id) {
        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource[i].name = event.name;
                dataSource[i].location = event.location;
                dataSource[i].startDate = event.startDate;
                dataSource[i].endDate = event.endDate;
            }
        }
    }
    else
    {
        var newId = 0;
        for(var i in dataSource) {
            if(dataSource[i].id > newId) {
                newId = dataSource[i].id;
            }
        }
        
        newId++;
        event.id = newId;
    
        dataSource.push(event);
    }
    
    jQuery('#calendar').data('calendar').setDataSource(dataSource);
    jQuery('#event-modal').modal('hide');
}

jQuery(function() {
    var currentYear = new Date().getFullYear();

    jQuery('#calendar').calendar({ 
        enableContextMenu: true,
        enableRangeSelection: true,
        contextMenuItems:[
            {
                text: 'Update',
                click: editEvent
            },
            {
                text: 'Delete',
                click: deleteEvent
            }
        ],
        selectRange: function(e) {
            editEvent({ startDate: e.startDate, endDate: e.endDate });
        },
        mouseOnDay: function(e) {
            if(e.events.length > 0) {
                var content = '';
                
                for(var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                                    + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                    + '<div class="event-location">' + e.events[i].location + '</div>'
                                + '</div>';
                }
            
                jQuery(e.element).popover({ 
                    trigger: 'manual',
                    container: 'body',
                    html:true,
                    content: content
                });
                
                jQuery(e.element).popover('show');
            }
        },
        mouseOutDay: function(e) {
            if(e.events.length > 0) {
                jQuery(e.element).popover('hide');
            }
        },
        dayContextMenu: function(e) {
            jQuery(e.element).popover('hide');
        },
        dataSource: [
            {
                id: 0,
                name: 'Google I/O',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 4, 28),
                endDate: new Date(currentYear, 4, 29)
            },
            {
                id: 1,
                name: 'Microsoft Convergence',
                location: 'New Orleans, LA',
                startDate: new Date(currentYear, 2, 16),
                endDate: new Date(currentYear, 2, 19)
            },
            {
                id: 2,
                name: 'Microsoft Build Developer Conference',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 3, 29),
                endDate: new Date(currentYear, 4, 1)
            },
            {
                id: 3,
                name: 'Apple Special Event',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 8, 1),
                endDate: new Date(currentYear, 8, 1)
            },
            {
                id: 4,
                name: 'Apple Keynote',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 8, 9),
                endDate: new Date(currentYear, 8, 9)
            },
            {
                id: 5,
                name: 'Chrome Developer Summit',
                location: 'Mountain View, CA',
                startDate: new Date(currentYear, 10, 17),
                endDate: new Date(currentYear, 10, 18)
            },
            {
                id: 6,
                name: 'F8 2015',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 2, 25),
                endDate: new Date(currentYear, 2, 26)
            },
            {
                id: 7,
                name: 'Yahoo Mobile Developer Conference',
                location: 'New York',
                startDate: new Date(currentYear, 7, 25),
                endDate: new Date(currentYear, 7, 26)
            },
            {
                id: 8,
                name: 'Android Developer Conference',
                location: 'Santa Clara, CA',
                startDate: new Date(currentYear, 11, 1),
                endDate: new Date(currentYear, 11, 4)
            },
            {
                id: 9,
                name: 'LA Tech Summit',
                location: 'Los Angeles, CA',
                startDate: new Date(currentYear, 10, 17),
                endDate: new Date(currentYear, 10, 17)
            }
        ]
    });
    
    jQuery('#save-event').click(function() {
        saveEvent();
    });
});	
</script>
</div>
<?php

get_footer('dashboard');
