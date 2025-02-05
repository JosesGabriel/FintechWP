$(document).ready(function(){

	getstocks();
	livedata();
	tradelogs();
	performance();
	marketstatus();
	setInterval(function(){
   		livedata();
   		marketstatus();
   		performance();
  	}, 5000);



	function getstocks(){

		$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/buyvalues',
		    dataType: 'json',
		    success: function(response) {
		    	var opt = '';

		    	var sorted = response.data.sort(function (a, b) {
	    				if (a.symbol > b.symbol) {
	      					return 1;
	      				}
	    				if (a.symbol < b.symbol) {
	     					 return -1;
	     				}
	    				return 0;
				   });

		    	$.each(sorted, function(i, val) {
		    		opt = "<option value="+ val.symbol +">" + val.symbol + "</option>";
		    		$('#inpt_data_select_stock').append(opt);
		    	});

		    },
		      error: function(response) {                 
		      }
		 });
	}

	function livedata(){
		var userid = $('.userid').val();
	   	$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/liveportfolio?userid='+userid,
		    dataType: 'json',
		    success: function(response) {   	
		    	$(".datalive").remove();
		    	jQuery.each(response.data, function(i, val) {
		    		//console.log(response.data);
		    		var buyprice = parseFloat(response.data[i].buyprice);
		    		var marketval = 0;
			    	var totalcost = 0;
			    	var last = 0;
			    	var average = 0;

		    		if(response.data[i].datainfo != null){
		    			last = response.data[i].datainfo.last;
			    		marketval = response.data[i].datainfo.last * response.data[i].volume;
			    		totalcost = response.data[i].datainfo.average * response.data[i].volume; 
			    		average = response.data[i].datainfo.average;
		    		}

		    		var prof = buyprice * response.data[i].volume;
		    		var profit = marketval - prof;
		    		var profperc = (profit/marketval) * 100;
		    		
		    		var outcome = (profit > 0 ? "Winning" : "Loosing");

		    		var data_live = '';
			    	data_live += '<li class="datalive">';
				    data_live += '<table width="100%">';
				    data_live += '<tbody><tr><td style="width: 7%;text-align: left !important;"><a target="_blank" class="stock-label" href="/chart/'+ response.data[i].stockname +'">' + response.data[i].stockname + '</a></td>';
				    data_live += '<td style="width:9%" class="table-title-live">'+last+'</td>';
				    data_live += '<td style="width:9%" class="table-title-live">'+response.data[i].volume+'</td>';
				    data_live += '<td style="width: 12%;" class="table-title-live">₱'+(average).toFixed(2)+'</td>';
				    data_live += '<td style="width:15%" class="table-title-live">₱'+(totalcost).toFixed(2)+'</td>';
				    data_live += '<td style="width:15%" class="table-title-live">₱'+(marketval).toFixed(2)+'</td>';
				    data_live += '<td style="width:10%" class="'+(profit < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">₱'+(profit).toFixed(2)+'</td>';
				    data_live += '<td style="width:8%" class="'+(profperc < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">'+(profperc).toFixed(2)+'%</td>';
				    data_live += '<td style="width:77px;text-align:center;">';
				    data_live += '<a data-stock="'+response.data[i].stockname+'" class="smlbtn fancybox-inline green buymystocks" data-toggle="modal" data-target="#enter_trade" data-stockdetails="" data-boardlot="">BUY</a>';
				    data_live += '<a data-stock="'+response.data[i].stockname+'" class="smlbtn fancybox-inline red sellmystocks" data-toggle="modal" data-target="#enter_trade"data-stockdetails=""data-trades="" data-position="" data-stock="" data-averprice="" >SELL</a>';
				    data_live += '</td>';
				    data_live += '<td style="width:27px; text-align:center"><a data-emotion="'+ response.data[i].emotion +'" data-toggle="modal" data-target="#livetradenotes" data-strategy="'+ response.data[i].strategy +'" data-tradeplan="'+response.data[i].tradeplan+'" data-tradingnotes="'+response.data[i].tradenotes+'" data-outcome="'+outcome+'" class="livetrbut smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></td>';
				    data_live += '<td style="width:25px"><a data-stock="'+response.data[i].stockid+'" data-totalprice="" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></td>';
				    data_live += '</tr></tbody>';
				    data_live += '</table>';
				    data_live += '</li>';
				    $("#live_portfolio > ul").append(data_live);
		    	});


		     },
		    error: function(response) {                 
		    }
		});
	}


	function tradelogs(){
		var userid = $('.userid').val();
	   	$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/tradelogs?userid='+userid,
		    dataType: 'json',
		    success: function(response) {
		    		//console.log(response);
		    		$(".data_logs").remove();
		    		jQuery.each(response.data, function(i, val) {
			    		var data_tradelogs = '';
			    		var profit = parseFloat(response.data[i].profit).toFixed(2);
			    		var profperc = parseFloat(response.data[i].profitperc).toFixed(2);
			    		var buyvalue = response.data[i].averageprice * response.data[i].volume;
			    		var outcome = (profit > 0 ? "Winning" : "Loosing");

			    		data_tradelogs += '<li class="data_logs">';
	                    data_tradelogs += '<div style="width:100%;">';
	                    data_tradelogs += '<div style="width:45px"><a target="_blank" class="stock-label" href="/chart/'+ response.data[i].stockname +'">'+response.data[i].stockname+'</a></div>';                                                                                	
	                    data_tradelogs += '<div style="width:65px">'+response.data[i].buydate+'</div>';
	                    data_tradelogs += '<div style="width:55px; text-align:center" class="table-title-live">'+response.data[i].volume+'</div>';
	                    data_tradelogs += '<div style="width:65px; text-align:center" class="table-title-live">₱'+response.data[i].averageprice+'</div>';
	                    data_tradelogs += '<div style="width:95px; text-align:center" class="table-title-live">₱'+(buyvalue).toFixed(2)+'</div>';
	                    data_tradelogs += '<div style="width:65px; text-align:center" class="table-title-live">₱'+parseFloat(response.data[i].sellprice).toFixed(2)+'</div>';
	                    data_tradelogs += '<div style="width:88px; text-align:center" class="table-title-live">₱'+(response.data[i].sellvalue).toFixed(2)+'</div>';
	                    data_tradelogs += '<div style="width:80px; text-align:center" class="'+(profit < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">₱'+profit+'</div>';
	                    data_tradelogs += '<div style="width:65px; text-align:center" class="'+(profperc < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">'+profperc+'%</div>';
	                    data_tradelogs += '<div style="width:65px; text-align:center; float:right">';
	                    data_tradelogs += '<div style="width:27px; text-align:center"><a data-toggle="modal" data-target="#livetradenotes" class="smlbtn blue tldetails" data-strategylog="'+ response.data[i].strategy +'" data-tradeplanlog="'+response.data[i].tradeplan+'" data-emotionlog="'+ response.data[i].emotion +'" data-tradingnoteslog="'+response.data[i].tradenotes+'" data-outcomelog="'+outcome+'"><i class="fas fa-clipboard"></i></a></div>';
	                    data_tradelogs += '<div style="width:25px"><a class="deletelog smlbtn-delete" data-stockid="'+ response.data[i].id +'" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></div>';
	                    data_tradelogs += '</div>';
	                    data_tradelogs += '</div>';  	
	                    data_tradelogs += '</li>';
	                    $(".showtradelogs > ul").append(data_tradelogs);
		    		});	

		    		if(response.totalprofit < 0){
		    			$('.totalplscore').addClass('dredpart');
		    			$('.totalplscore').removeClass('dgreenpart');
		    		}else{
		    			$('.totalplscore').addClass('dgreenpart');
		    			$('.totalplscore').removeClass('dredpart');
		    		}
		    		if(response.totalprofit != null){
		    			$('.totalplscore').text('₱'+(response.totalprofit).toFixed(2));
		    		}

		    		$('.total_wins').text(response.totalwins);
		    		$('.total_loss').text(response.totalloss);
		    		chart_load();
		    },
		    error: function(response) {                 
		    } 
		});
	}


	function performance(){
		var userid = $('.userid').val();
		$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/performance?userid='+userid,
		    dataType: 'json',
		    success: function(response) {
		    	//console.log(response); 	
		    	if(response.data.realized < 0){
		    		$('.realized').addClass('dredpart');
		    		$('.realized').removeClass('dgreenpart');
		    		$('.up_arrow_realized').css('display','none');
		    		$('.down_arrow_realized').css('display','block');
		    	}else{
		    		$('.realized').addClass('dgreenpart');
		    		$('.realized').removeClass('dredpart');
		    	}

		    	if(response.data.unrealize < 0){
		    		$('.unrealized').addClass('dredpart');
		    		$('.unrealized').removeClass('dgreenpart');
		    		$('.up_arrow_unrealized').css('display','none');
		    		$('.down_arrow_unrealized').css('display','block');
		    	}else{
		    		$('.unrealized').addClass('dgreenpart');
		    		$('.unrealized').removeClass('dredpart');
		    	}
		    	if(response.data.percentage < 0){
		    		$('.vperformance').addClass('dredpart');
		    		$('.vperformance').removeClass('dgreenpart');
		    	}else{
		    		$('.vperformance').addClass('dgreenpart');
		    		$('.vperformance').removeClass('dredpart');
		    	}

		    	$('.vcapital').text('₱' + addcomma(response.data.capital));
		    	$('.realized').text('₱' + addcomma(response.data.realized));
		    	$('.unrealized').text('₱' + addcomma(response.data.unrealize));
		    	$('.total_equity').text('₱' + addcomma(response.data.equity));
		    	$('.vperformance').text('%' + addcomma(response.data.percentage));
		    	$('.available_funds').text('₱' + addcomma(response.data.buypower));
		    	$('.av_funds').text('₱' + addcomma(response.data.buypower));
		    },
		    error: function(response) {                 
		    }
		});

	}


	function deletedata(id){
		var userid = $('.userid').val();
		$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/deletedata?id='+id+'&userid='+userid,
		    dataType: 'json',
		    success: function(response) {
		    	console.log(response);
		    	livedata();
		    },
		    error: function(response) {                 
		    }
		});
	}

	function resetdata(){
		var userid = $('.userid').val();
		//console.log('userid='+userid);
		$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/resetdata?userid='+userid,
		    dataType: 'json',
		    success: function(response) {
		    	console.log(response);
		    	livedata();
		    	tradelogs();
				performance();
		    },
		    error: function(response) {                 
		    }
		});
	}

	function deletelogs(id){
		var userid = $('.userid').val();
		$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/deletelogs?id='+id+'&userid='+userid,
		    dataType: 'json',
		    success: function(response) {
		    	console.log(response);
		    	tradelogs();
		    },
		    error: function(response) {                 
		    }
		});
	}

	function get_marketdepth(stock){
    	$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/marketdepth?stock='+ stock,
		    dataType: 'json',
		    success: function(response) {

		    	var bid = (response.data.bid_total_percent == null ? 0 : parseFloat(response.data.bid_total_percent).toFixed(2));
		    	var ask = (response.data.ask_total_percent == null ? 0 : parseFloat(response.data.ask_total_percent).toFixed(2));

		    	$('.arb_bar_green').css('width', bid + '%');
		    	$('.arb_bar_red').css('width', ask + '%');
		    },
		      error: function(response) {                 
		      }
		 });
	}


	function get_sentiments(stock){
    	$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/memsentiment?stock='+ stock,
		    dataType: 'json',
		    success: function(response) {
		    	var bull = response.bull;
		    	var bear = response.bear;

		    	if(bull == null || bull == ''){
		    		bull = 0;
		    	}
		    	if(bear == null || bear == ''){
		    		bear = 0;
		    	}
		    	var vtotal = parseFloat(bull) + parseFloat(bear);
		    	if(vtotal != 0){
			    	var bullperc = (bull / vtotal) * 100;
			    	var bearperc = (bear / vtotal) * 100;
			    	$('.arb_bar_green_m').css('width', bullperc + '%');
		    		$('.arb_bar_red_m').css('width', bearperc + '%');
		    	}else{
		    		$('.arb_bar_green_m').css('width','50%');
		    		$('.arb_bar_red_m').css('width','50%');
		    	}
		    	
		    },
		      error: function(response) {                 
		      }
		 });
	}

	function buydata(stock){

			$.ajax({
			    type:'GET',
			    url:'/wp-json/virtual-api/v1/dstock?stock='+stock,
			    dataType: 'json',
			    success: function(response) {

			    	/*var dboard = 0;
			        if (response.data.last >= 0.0001 && response.data.last <= 0.0099) {
			            dboard = '1,000,000';
			        } else if (response.data.last >= 0.01 && response.data.last <= 0.049) {
			            dboard = '100,000';
			        } else if (response.data.last >= 0.05 && response.data.last <= 0.495) {
			            dboard = '10,000';
			        } else if (response.data.last >= 0.5 && response.data.last <= 4.99) {
			            dboard = '1,000';
			        } else if (response.data.last >= 5 && response.data.last <= 49.95) {
			            dboard = 100;
			        } else if (response.data.last >= 50 && response.data.last <= 999.5) {
			            dboard = 10;
			        } else if (response.data.last >= 1000) {
			            dboard = 5;
			        }*/ 
			        if((response.data.change).toFixed(2) > 0){
			        	$('.change').addClass('dgreenpart');
			        	$('.change').removeClass('dredpart');
			        }else if((response.data.change).toFixed(2) < 0) {
			        	$('.change').addClass('dredpart');
			        	$('.change').removeClass('dgreenpart');
			        }else {
			        	$('.change').css('color','#fcbb29');
			        	$('.change').removeClass('dgreenpart');
			        	$('.change').removeClass('dredpart');
			        }

			        if((response.data.changepercentage).toFixed(2) > 0){
			        	$('.cpercentage').addClass('dgreenpart');
			        	$('.cpercentage').removeClass('dredpart');
			        }else if((response.data.changepercentage).toFixed(2) < 0) {
			        	$('.cpercentage').addClass('dredpart');
			        	$('.cpercentage').removeClass('dgreenpart');
			        }else {
			        	$('.cpercentage').css('color','#fcbb29');
			        	$('.cpercentage').removeClass('dgreenpart');
			        	$('.cpercentage').removeClass('dredpart');
			        }

				    			$('.sdesc').text(response.data.description);
				    			$('.cprice').text('  '+(response.data.last).toFixed(2));
				    			$('.change').text('  '+(response.data.change).toFixed(2));
				    			$('.cpercentage').text(' ('+(response.data.changepercentage).toFixed(2) + '%)');
				    			$('.pdetails.prev').text((response.data.close).toFixed(2));
				    			$('.pdetails.low').text((response.data.low).toFixed(2));
				    			$('.pdetails.klow').text(response.data.weekyearlow);
				    			$('.pdetails.vol').text(nFormatter(parseFloat(response.data.volume)));
				    			$('.pdetails.trade').text((response.data.trades).toFixed(2));
				    			$('.pdetails.open').text((response.data.open).toFixed(2));
				    			$('.pdetails.high').text((response.data.high).toFixed(2));
				    			$('.pdetails.khigh').text((response.data.weekyearhigh).toFixed(2));
				    			$('.pdetails.val').text(nFormatter(parseFloat(response.data.value)));
				    			$('.pdetails.av').text((response.data.average).toFixed(2));
				    			$('#entertopdataprice').val((response.data.last).toFixed(2));
				    			get_marketdepth(stock);
				    			get_sentiments(stock);
			    },
			    error: function(response) {                 
			    }
		 	});

	}


	function selldata(stock, userid){

		$.ajax({
			    type:'GET',
			    url:'/wp-json/virtual-api/v1/toselldetails?stock='+ stock +'&userid='+userid,
			    dataType: 'json',
			    success: function(response) {	

						    	if((response.data.datainfo.change).toFixed(2) > 0){
						        	$('.change').addClass('dgreenpart');
						        	$('.change').removeClass('dredpart');
						        }else if((response.data.datainfo.change).toFixed(2) < 0) {
						        	$('.change').addClass('dredpart');
						        	$('.change').removeClass('dgreenpart');
						        }else {
						        	$('.change').css('color','#fcbb29');
						        	$('.change').removeClass('dgreenpart');
						        	$('.change').removeClass('dredpart');
						        }

						        if((response.data.datainfo.changepercentage).toFixed(2) > 0){
						        	$('.cpercentage').addClass('dgreenpart');
						        	$('.cpercentage').removeClass('dredpart');
						        }else if((response.data.datainfo.changepercentage).toFixed(2) < 0) {
						        	$('.cpercentage').addClass('dredpart');
						        	$('.cpercentage').removeClass('dgreenpart');
						        }else {
						        	$('.cpercentage').css('color','#fcbb29');
						        	$('.cpercentage').removeClass('dgreenpart');
						        	$('.cpercentage').removeClass('dredpart');
						        }			    	
			    	
			    				$('.sdesc').text(response.data.datainfo.description);
				    			$('.cprice').text(' '+(response.data.datainfo.last).toFixed(2));
				    			$('.change').text(' '+(response.data.datainfo.change).toFixed(2));
				    			$('.cpercentage').text(' ('+(response.data.datainfo.changepercentage).toFixed(2) + '%)');
				    			$('.pdetails.prev').text((response.data.datainfo.close).toFixed(2));
				    			$('.pdetails.low').text((response.data.datainfo.low).toFixed(2));
				    			$('.pdetails.klow').text(response.data.datainfo.weekyearlow);
				    			$('.pdetails.vol').text(nFormatter(parseFloat(response.data.volume)));
				    			$('.pdetails.trade').text((response.data.datainfo.trades).toFixed(2));
				    			$('.pdetails.open').text((response.data.datainfo.open).toFixed(2));
				    			$('.pdetails.high').text((response.data.datainfo.high).toFixed(2));
				    			$('.pdetails.khigh').text((response.data.datainfo.weekyearhigh).toFixed(2));
				    			$('.pdetails.val').text(nFormatter(parseFloat(response.data.datainfo.value)));
				    			$('.pdetails.av').text((response.data.averageprice).toFixed(2));
				    			$('#entertopdataprice').val((response.data.datainfo.last).toFixed(2));
				    			get_marketdepth(stock);
				    			get_sentiments(stock);

			     },
			    error: function(response) {                 
			    }
		 });

	}

	$('.groupinput').on('change', 'select.data_stocks',function(){

		var sdata = $(this).val();
		var btn = $('.btnValue').val();
		var userid = $('.userid').val();

		if(btn == 'buy'){
			buydata(sdata);
		}else {
			selldata(sdata, userid);
		}

	});


	function nFormatter(num) {
	     if (num >= 1000000000) {
	        return (num / 1000000000).toFixed(2).replace(/\.0$/, '') + 'G';
	     }
	     if (num >= 1000000) {
	        return (num / 1000000).toFixed(2).replace(/\.0$/, '') + 'M';
	     }
	     if (num >= 1000) {
	        return (num / 1000).toFixed(2).replace(/\.0$/, '') + 'K';
	     }
	     return num;
	}

	function addcomma(n, sep, decimals) {
	    sep = sep || "."; // Default to period as decimal separator
	    decimals = decimals || 2; // Default to 2 decimals

	    return n.toLocaleString().split(sep)[0]
	        + sep
	        + n.toFixed(2).split(sep)[1];
	}

	function thetradefees(totalfees, istype){
        // Commissions
        let dpartcommission = totalfees * 0.0025;
        let dcommission = (dpartcommission > 20 ? dpartcommission : 20);
        // TAX
        let dtax = dcommission * 0.12;
        // Transfer Fee
        let dtransferfee = totalfees * 0.00005;
        // SCCP
        let dsccp = totalfees * 0.0001;
        let dsell = totalfees * 0.006;
        let dall;
        if (istype == 'buy') {
            dall = dcommission + dtax + dtransferfee + dsccp;
        } else {
            dall = dcommission + dtax + dtransferfee + dsccp + dsell;
        }

        return dall;
    }

    function marketstatus(){
    	    	
    	$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/gettime',
		    dataType: 'json',
		    success: function(response) {	    	
		    	var times = response.timestamp;
		    	time = times.timestamp * 1000;

		    	var open_am = new Date();
		  			open_am.setHours(17, 30, 0);
		    	var close_am = new Date();
		    		close_am.setHours(19, 59, 59);
		    	var recess_open = new Date();
		    		recess_open.setHours(20, 0, 0);
		    	var recess_close = new Date();
		    		recess_close.setHours(21, 29, 59);
		    	var open_pm = new Date();
		    		open_pm.setHours(21, 30, 0);
		    	var close_pm = new Date();
		    		close_pm.setHours(23, 30, 0);

		    	if(time == null){
		    		time = Date.now();
		    	}

		    	    if((time > Date.parse(open_am) && time < Date.parse(close_am)) || (time > Date.parse(open_pm) && time < Date.parse(close_pm))) {	
						$('.mstatus').text('Open');
						$('.mstatus').addClass('dgreenpart');
						$('.mstatus').removeClass('dredpart');
					}else if (time > Date.parse(recess_open) && time < Date.parse(recess_close)) {
						$('.mstatus').text('Recess');
					} else{
						$('.mstatus').text('Close');
						$('.mstatus').addClass('dredpart');
						$('.mstatus').removeClass('dgreenpart');
					}
				
		     },
		    error: function(response) {                 
		    }
		});
	
    }

    jQuery(document).on('click', '.resetdata', function(){   	
    	Swal.fire({
            title: 'Are you sure?',
            text: "Once deleted, you will not be able to recover your Data!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                ).then((result) => {
                	resetdata();
                    //var ditemtoremove = jQuery(this).attr('data-space');
                    //window.location.href = "/watchlist/?remove="+ditemtoremove;
                });
            }
        });
    });

	jQuery(document).on('click', '.buymystocks', function(){
		var stock = $(this).attr('data-stock');
		$('.btnValue').val('buy');
		$("#inpt_data_select_stock").val(stock).change();
		$('#inpt_data_select_stock').prop('disabled', 'disabled');
		$('.bsbutton').css('display','none');
		$('.label_enter').text('Enter Buy Order:');
		$('.footer_details2').slideDown();
	});

	jQuery(document).on('click', '.sellmystocks', function(){
		var stock = $(this).attr('data-stock');
		$('.btnValue').val('sell');
		$("#inpt_data_select_stock").val(stock).change();
		$('#inpt_data_select_stock').prop('disabled', 'disabled');
		$('.bsbutton').css('display','none');
		$('.label_enter').text('Enter Sell Order:');
		$('.labelprice').text('Sell Price');
		$('.footer_details2').slideUp();
	});
	
	jQuery(document).on('click', '.enter-trade-btn', function(){
		$('.bsbutton').css('display','inline-block');
		$('#inpt_data_select_stock').prop('disabled', false);
		$('.label_enter').text('Enter Order:');
	});

	jQuery(".buymystocks").click(function(e){
		e.preventDefault();

		console.log("this is a test");
	});

	jQuery(document).on('click', '.livetrbut.smlbtn', function(){
		var emotion = $(this).attr('data-emotion');
		var strategy = $(this).attr('data-strategy');
		var tradeplan = $(this).attr('data-tradeplan');
		var notes = $(this).attr('data-tradingnotes');
		var outcome = $(this).attr('data-outcome');

		$('.addstrats').text(strategy);
		$('.addtplan').text(tradeplan);
		$('.addemotion').text(emotion);
		$('.addoutcome').text(outcome);
		$('.addnotes').text(notes);
	});

	jQuery(document).on('click', '.tldetails', function(){
		var emotion = $(this).attr('data-emotionlog');
		var strategy = $(this).attr('data-strategylog');
		var tradeplan = $(this).attr('data-tradeplanlog');
		var notes = $(this).attr('data-tradingnoteslog');
		var outcome = $(this).attr('data-outcomelog');

		$('.addstrats').text(strategy);
		$('.addtplan').text(tradeplan);
		$('.addemotion').text(emotion);
		$('.addoutcome').text(outcome);
		$('.addnotes').text(notes);
	});

	jQuery(document).on('keyup', '.inputquantity', function(){
		var price = $('.inputbuyprice').val().replace(/,/g, '');
        var quantity = $(this).val().replace(/,/g, '');
        var total_price = parseFloat(price) * Math.trunc(quantity);
        total_price = isNaN(total_price) || total_price < 0 ? 0 : parseFloat(total_price).toFixed(2);

        var finaltotal = parseFloat(total_price) + parseFloat(thetradefees(total_price, 'buy'));
        var decnumbs = finaltotal;
        var avfunds = jQuery('.av_funds').text().replace(/,/g, '');
        var buypower = avfunds.replace(/₱/g, '');
        
        if(parseFloat(decnumbs) > parseFloat(buypower)){
            swal("Not Enough Buy Power");
            jQuery(this).val(quantity.slice(0,-1));
            return false;
        } else {
            jQuery('.tlcost').text('₱'+addcomma(decnumbs));       
        }

      
	});


	jQuery(document).on('click', '.deletelive.smlbtn-delete', function(){

	 	var id = $(this).attr('data-stock');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                ).then((result) => {
                	deletedata(id);
                    //var ditemtoremove = jQuery(this).attr('data-space');
                    //window.location.href = "/watchlist/?remove="+ditemtoremove;
                });
            }
        });
	});

	jQuery(document).on('click', '.deletelog', function(){

	 	var id = $(this).attr('data-stockid');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                ).then((result) => {
                	deletelogs(id);
                });
            }
        });
	});


	$('.btnbuy').on('click', function(){
		$('.btnbuy').css('background','#25ae5f');
		$('.btnsell').css('background','none');
		$('.labelprice').text('Buy Price');
		$('.btnValue').val('buy');
		$('#inpt_data_select_stock option').remove();
		$('.footer_details2').slideDown();
		getstocks();
	});

	$('.btnsell').on('click', function(){
		$('.btnsell').css('background','#e64c3c');
		$('.btnbuy').css('background','none');
		$('.labelprice').text('Sell Price');
		$('.btnValue').val('sell');
		$('.footer_details2').slideUp();
		var userid = $('.userid').val();
		$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/stockstosell?userid='+ userid,
		    dataType: 'json',
		    success: function(response) {	
		    	var opt = '';    	
		    	$('#inpt_data_select_stock option').remove();
	    		$.each(response.data, function(i, val) {
		    		opt = "<option value="+ val +">" + val + "</option>";
	    			$('#inpt_data_select_stock').append(opt);
		    	});    		
		    },
		      error: function(response) {                 
		      }
		 });

	});

	$('.confirm_order').on('click', function(){

		var stockname = $('.data_stocks').val();
		var buyprice = $('.inputbuyprice').val();
		var sellprice = $('.inputbuyprice').val();
		var volume = $('.inputquantity').val().replace(/,/g, '');
		var averageprice = $('.pdetails.av').text();
		var emotion = $('.inpt_data_emotion').val();
		var strategy = $('.inpt_data_strategy').val();
		var tradeplan = $('.inpt_data_tradeplan').val();
		var tradenotes = $('.tnotes').val();
		var d = new Date();
		var buydate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
		var userid = $('.userid').val();
		var btn = $('.btnValue').val();
		var status = $('.mstatus').text();

		console.log('volume - ' + volume + '| price -' + buyprice);

		if(volume.length == 0 ){
			swal("Please enter quantity");
            return false;
		}

		if(stockname == ''){
			swal("Please select a Stock");
            return false;
		}
		//if(status == 'Open'){
			
					if(btn == 'buy'){
						$.ajax({
						    type:'GET',
						    url:'/wp-json/virtual-api/v1/livetrade',
						    dataType: 'json',
						    data:{
						    	"stockname": stockname,
								"buyprice": buyprice,
								"volume": volume,
								"emotion": emotion,
								"strategy": strategy,
								"tradeplan": tradeplan,
								"tradenotes": tradenotes,
								"buydate": buydate,
								"category": "vtrade1",
								"type": "vt",
								"userid": userid
						    },
						    success: function(response){
								console.log('success');
								$('#enter_trade').modal('toggle'); 
								livedata();
								performance();
						    },
						    error: function(response){                 
						      }
						 });

					}else {

						$.ajax({
						    type:'GET',
						    url:'/wp-json/virtual-api/v1/sellstock',
						    dataType: 'json',
						    data:{
						    	"userid": userid,
								"stock": stockname,
								"volume": volume,
								"averageprice": averageprice,
								"emotion": emotion,
								"strategy": strategy,
								"tradeplan": tradeplan,
								"tradenotes": tradenotes,
								"sellprice": sellprice,
								"buydate": buydate
						    },
						    success: function(response){
								console.log(response.data);
								$('#enter_trade').modal('toggle'); 
								livedata();
								tradelogs();
								performance();
						    },
						    error: function(response){                 
						      }
						 });

					}
		/*}else {
			swal("Market Closed!");
            return false;
		}*/

	});

	///=======================chart=====================//

function chart_load(){
		google.charts.load("current", {packages:["corechart"]});
	      google.charts.setOnLoadCallback(drawChart);
	      function drawChart() {
	      	var wins = $('.total_wins').text();
	      	var loss = $('.total_loss').text();
	        var data = google.visualization.arrayToDataTable([
	          ['Task', 'Wins/Losses'],

	          ['Wins', wins],
	          ['Loss', loss]
	        ]);

	        var options = {
	          width: 180,
	  		  height: 100,
	  		  backgroundColor:'transparent',
	          pieHole: 0.4,
	          legend: 'none',
	          BorderColor : "transparent",
	      	  chartArea: {
	      	  		left: 6,
	      	  		top: 10,
	      			width: 60, 
	      			height: 60
	      		},
	      	  slices: {
	      	  	0: {color: '#27ae60'}, 
	      	  	1: {color: '#e44c3c'}
	      		},
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
	        chart.draw(data, options);
	      }

     }

});