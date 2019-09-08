<?php
	$ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);
	$ismetadis = json_encode($ismetadis);

	$curl = curl_init();	
	#curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes' );
	curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE' );
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$dwatchinfo = curl_exec($curl);
	curl_close($curl);

	$genstockinfo = json_decode($dwatchinfo);
	$stockinfo = $genstockinfo->data;

	// $curl = curl_init();
	// curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/intraday/?symbol='.$value['stockname'].'&firstDataRequest=true&from='.date('Y-m-d') );
	// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	// $dintrabase = curl_exec($curl);
	// curl_close($curl);

	$isdate = date('Y-m-d');
?>
<script type="text/javascript">
	(function($) {
	    jQuery(document).ready(function() {
	    	function getval() {
			    var currentTime = new Date()
			    var hours = currentTime.getHours()
			    var minutes = currentTime.getMinutes()

			    if (minutes < 10) minutes = "0" + minutes;

			    var suffix = "AM";
			    if (hours >= 12) {
			        suffix = "PM";
			        hours = hours - 12;
			    }
			    if (hours == 0) {
			        hours = 12;
			    }
			    var current_time = hours + ":" + minutes + " " + suffix;

			    return current_time;
			}

			function get24Hr(time){
			    var hours = Number(time.match(/^(\d+)/)[1]);
			    var AMPM = time.match(/\s(.*)$/)[1];
			    if(AMPM == "PM" && hours<12) hours = hours+12;
			    if(AMPM == "AM" && hours==12) hours = hours-12;
			    
			    var minutes = Number(time.match(/:(\d+)/)[1]);
			    hours = hours*100+minutes;
			    // console.log(time +" - "+hours);
			    return hours;
			}
			function newwatchlist(){
				var usermetas = <?php echo $ismetadis; ?>;
				//console.log(usermetas);
				$.each(usermetas, function(index, dinfo){
					var stockname = dinfo.stockname;
					jQuery.ajax({
						method: "get",
						url: "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE&symbol=" + stockname,
						dataType: 'json',
						data:{
							'action' : 'my_custom_action'
						},
						success: function(data){
							console.log(stockname);
							//console.log(data.data);
							var stockdata = data;
							$.each(stockdata.data, function(index,stockinfo){
								//start comparing now
								console.log(stockinfo.last);

							});
						}
					});
				});

			}
	        function checkwatchlist() {
	        	var dlistofstocks = <?php echo $ismetadis; ?>;
				console.log(dlistofstocks);
	        	jQuery.ajax({
				 	method: "GET",
					url: "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE&symbol=",
					
					// url: 'https://api2.pse.tools/api/quotes',
					dataType: 'json',
					data: {
						'action' : 'my_custom_action'
					},
					success: function(data) {
					   //console.log(data.data);
					  var allinfordata = data.data;
					  //console.log(allinfordata);
					  $.each(dlistofstocks, function(index, dinfo){
					  	var istockname = dinfo.stockname;
					  	var dstockdd;
					  	
					  	$.each(allinfordata, function(xindex, xdinfo){
							//console.log(allinfordata.symbol);
					  		if (xdinfo.symbol == istockname) {
					  			dstockdd = xdinfo;
					  		}
					  	});
					  	var dstockval = parseFloat(dstockdd.last);


					  	if ("dcondition_entry_price" in dinfo) {
					  		if (parseFloat(dinfo.dconnumber_entry_price) == dstockval.toFixed(2)) {
					  			// jQuery("#entry_price").attr("data-stock", istockname).attr("data-price", dstockval.toFixed(2)).trigger('click');
					  			// console.log(istockname+' Entery price has been hit');

									var dslert = '<div class="noti-message">';
										dslert += '<div class="vertical-align">';
											dslert += '<a class="cont-logo">';
												dslert += '<span style="border: 2px solid #f44336 !important;">'+istockname+'</span>';
											dslert += '</a>';
											dslert += '<div class="md-rightside">';
												dslert += '<a class="cont-bodymessage">';
													dslert += 'Buy Now! <br>';
													dslert += '<span class="disc-text">Current price is now ₱'+dstockval.toFixed(2)+'</span>';
													
												dslert += '</a>';
												dslert += '<div class="op-btnchart">';
													dslert += '<div class="btn-show"><a href="https://arbitrage.ph/chart/'+istockname+'">Show</a></div>';
													dslert += '<div class="btn-close xclsbtn">Close</div>';
												dslert += '</div>';
											dslert += '</div>';
										dslert += '</div>';
									dslert += '</div>';
								jQuery(".alert-handler").append(dslert);
					  		}
					  	}

					  	if ("dcondition_stop_loss_point" in dinfo) {
					  		if (parseFloat(dinfo.dconnumber_stop_loss_point) > dstockval.toFixed(2)) {
					  			// jQuery("#stop_loss_point").attr("data-stock", istockname).attr("data-price", dstockval.toFixed(2)).trigger('click');
					  			// console.log(istockname+' Stop Loss has been hit');

					  			var dslert = '<div class="noti-message">';
										dslert += '<div class="vertical-align">';
											dslert += '<a class="cont-logo">';
												dslert += '<span style="border: 2px solid #f44336 !important;">'+istockname+'</span>';
											dslert += '</a>';
											dslert += '<div class="md-rightside">';
												dslert += '<a class="cont-bodymessage">';
													dslert += 'Sell Now and Stop your loss! <br>';
													dslert += '<span class="disc-text">Current price is now ₱'+dstockval.toFixed(2)+'</span>';
													
												dslert += '</a>';
												dslert += '<div class="op-btnchart">';
													dslert += '<div class="btn-show"><a href="https://arbitrage.ph/chart/'+istockname+'">Show</a></div>';
													dslert += '<div class="btn-close xclsbtn">Close</div>';
												dslert += '</div>';
											dslert += '</div>';
										dslert += '</div>';
									dslert += '</div>';
								jQuery(".alert-handler").append(dslert);
					  		}
					  	}

					  	if ("dcondition_take_profit_point" in dinfo) {
					  		if (parseFloat(dinfo.dconnumber_take_profit_point) < dstockval.toFixed(2)) {
					  			// jQuery("#take_profit_point").attr("data-stock", istockname).attr("data-price", dstockval.toFixed(2)).trigger('click');
					  			// console.log(istockname+' Take Profit has been hit');

					  			var dslert = '<div class="noti-message">';
										dslert += '<div class="vertical-align">';
											dslert += '<a class="cont-logo">';
												dslert += '<span style="border: 2px solid #f44336 !important;">'+istockname+'</span>';
											dslert += '</a>';
											dslert += '<div class="md-rightside">';
												dslert += '<a class="cont-bodymessage">';
													dslert += 'Sell Now and Secure your Profit! <br>';
													dslert += '<span class="disc-text">Current price is now ₱'+dstockval.toFixed(2)+'</span>';
													
												dslert += '</a>';
												dslert += '<div class="op-btnchart">';
													dslert += '<div class="btn-show"><a href="https://arbitrage.ph/chart/'+istockname+'">Show</a></div>';
													dslert += '<div class="btn-close xclsbtn">Close</div>';
												dslert += '</div>';
											dslert += '</div>';
										dslert += '</div>';
									dslert += '</div>';
								jQuery(".alert-handler").append(dslert);
					  		}
					  	}

					  });
					  

					}
				});

	        }

	        function removealerts() {
	        	jQuery(".alert-handler").find('div').fadeOut( "slow", function() {
				    jQuery(this).remove();
				});
	        }

	        jQuery(".alert-handler").on("click", ".xclsbtn", function(){
			    jQuery(this).parents('.noti-message').fadeOut( "slow", function() {
				    jQuery(this).remove();
				});
			});
	        


	        var startTime = '09:30 AM';
			var endTime = '11:30 PM';
			var curr_time = getval();
			if (get24Hr(curr_time) > get24Hr(startTime) && get24Hr(curr_time) < get24Hr(endTime)) {
			    //in between these two times
			    //checkwatchlist();
				newwatchlist();
			    $counts = 1;
			    setInterval(function(){
			    	$counts++;
			    	removealerts();
			    	if ($counts <= 1) {
			    		//checkwatchlist();
						newwatchlist();
			    	}
				    
				},30000);
			}
	    });
	})(jQuery);
</script>