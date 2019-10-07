function checkwatchlist() {
	        	var dlistofstocks = <?php echo $ismetadis; ?>;
	        	jQuery.ajax({
				 	method: "post",
					url: "/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol=",
					
					// url: 'https://api2.pse.tools/api/quotes',
					dataType: 'json',
					data: {
						'action' : 'my_custom_action'
					},
					success: function(data) {
					  var allinfordata = data.data;
					  $.each(dlistofstocks, function(index, dinfo){
					  	var istockname = dinfo.stockname;
					  	var dstockdd;
					  	
					  	$.each(allinfordata, function(xindex, xdinfo){
					  		if (xdinfo.symbol == istockname) {
					  			dstockdd = xdinfo;
					  		}
					  	});
					  	var dstockval = parseFloat(dstockdd.last);
						

					  	if ("dcondition_entry_price" in dinfo) {
					  		if (parseFloat(dinfo.dconnumber_entry_price) == dstockval.toFixed(2)) {
					  			// jQuery("#entry_price").attr("data-stock", istockname).attr("data-price", dstockval.toFixed(2)).trigger('click');

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
													dslert += '<div class="btn-show"><a href="/chart/'+istockname+'">Show</a></div>';
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
													dslert += '<div class="btn-show"><a href="/chart/'+istockname+'">Show</a></div>';
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
													dslert += '<div class="btn-show"><a href="/chart/'+istockname+'">Show</a></div>';
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