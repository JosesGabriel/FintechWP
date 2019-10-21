$(document).ready(function(){

	livedata();
	tradelogs();

	$.ajax({
	    type:'GET',
	    url:'/wp-json/virtual-api/v1/buyvalues',
	    dataType: 'json',
	    success: function(response) {
	    	var opt = '';
	    	$.each(response.data, function(i, val) {
	    		opt = "<option value="+ val.symbol +">" + val.symbol + "</option>";
	    		$('#inpt_data_select_stock').append(opt);
	    	});

	    },
	      error: function(response) {                 
	      }
	 });

	function livedata(){
		var userid = $('.userid').val();
	   	$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/liveportfolio?userid='+userid,
		    dataType: 'json',
		    success: function(response) {
		    		//console.log(response);	    	
		    	$(".datalive").remove();
		    	jQuery.each(response.data, function(i, val) {
		    		
		    		var buyprice = parseFloat(response.data[i].buyprice);
		    		var marketval = response.data[i].datainfo.average * response.data[i].volume;
		    		var prof = buyprice * response.data[i].volume;
		    		var profit = marketval - prof;
		    		var profperc = (profit/marketval) * 100;
		    		//var totalcost = response.data[i].averageprice *; 

		    		var data_live = '';
			    	data_live += '<li class="datalive">';
				    data_live += '<table width="100%">';
				    data_live += '<tbody><tr><td style="width: 7%;text-align: left !important;"><a target="_blank" class="stock-label" href="/chart/'+ response.data[i].stockname +'">' + response.data[i].stockname + '</a></td>';
				    data_live += '<td style="width:9%" class="table-title-live">'+response.data[i].datainfo.last+'</td>';
				    data_live += '<td style="width:9%" class="table-title-live">'+(response.data[i].volume).toFixed(2)+'</td>';
				    data_live += '<td style="width: 12%;" class="table-title-live">₱'+(response.data[i].averageprice).toFixed(2)+'</td>';
				    data_live += '<td style="width:15%" class="table-title-live">₱</td>';
				    data_live += '<td style="width:15%" class="table-title-live">₱'+(marketval).toFixed(2)+'</td>';
				    data_live += '<td style="width:10%" class="'+(profit < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">₱'+(profit).toFixed(2)+'</td>';
				    data_live += '<td style="width:8%" class="'+(profperc < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">'+(profperc).toFixed(2)+'%</td>';
				    data_live += '<td style="width:77px;text-align:center;">';
				    data_live += '<a data-stock="'+response.data[i].stockname+'" class="smlbtn fancybox-inline green buymystocks" data-toggle="modal" data-target="#enter_trade" data-stockdetails="" data-boardlot="">BUY</a>';
				    data_live += '<a data-stock="'+response.data[i].stockname+'" class="smlbtn fancybox-inline red sellmystocks" data-toggle="modal" data-target="#enter_trade"data-stockdetails=""data-trades="" data-position="" data-stock="" data-averprice="" >SELL</a>';
				    data_live += '</td>';
				    data_live += '<td style="width:27px; text-align:center"><a data-emotion="'+ response.data[i].emotion +'" data-toggle="modal" data-target="#livetradenotes" data-strategy="'+ response.data[i].strategy +'" data-tradeplan="'+response.data[i].tradeplan+'" data-tradingnotes="'+response.data[i].tradenotes+'" data-outcome="" class="livetrbut smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></td>';
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
		    		console.log(response);
		    		$(".data_logs").remove();
		    		jQuery.each(response.data, function(i, val) {
			    		var data_tradelogs = '';
			    		var profit = parseFloat(response.data[i].profit).toFixed(2);
			    		var profperc = parseFloat(response.data[i].profitperc).toFixed(2);
			    		data_tradelogs += '<li class="data_logs">';
	                    data_tradelogs += '<div style="width:100%;">';
	                    data_tradelogs += '<div style="width:45px">'+response.data[i].stockname+'</div>';                                                                                	
	                    data_tradelogs += '<div style="width:65px">'+response.data[i].buydate+'</div>';
	                    data_tradelogs += '<div style="width:55px; float:right;" class="table-title-live">'+response.data[i].volume+'</div>';
	                    data_tradelogs += '<div style="width:65px; float:right;" class="table-title-live">'+response.data[i].averageprice+'</div>';
	                    data_tradelogs += '<div style="width:95px; float:right;" class="table-title-live">₱</div>';
	                    data_tradelogs += '<div style="width:65px; float:right;" class="table-title-live">'+parseFloat(response.data[i].sellprice).toFixed(2)+'</div>';
	                    data_tradelogs += '<div style="width:88px; float:right;" class="table-title-live">₱</div>';
	                    data_tradelogs += '<div style="width:80px; float:right;" class="'+(profit < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">'+profit+'</div>';
	                    data_tradelogs += '<div style="width:65px; float:right;" class="'+(profperc < 0 ? 'dredpart ' : 'dgreenpart ')+'table-title-live">'+profperc+'%</div>';
	                    data_tradelogs += '<div style="width:65px; float:right;; text-align:center">';
	                    data_tradelogs += '<div style="width:27px; text-align:center"><a class="smlbtn blue tldetails" data-tlstrats="" data-tltradeplans="" data-tlemotions="" data-tlnotes="" data-outcome=""><i class="fas fa-clipboard"></i></a></div>';
	                    data_tradelogs += '<div style="width:25px"><a class="deletelog smlbtn-delete" data-istl="" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></div>';
	                    data_tradelogs += '</div>';
	                    data_tradelogs += '</div>';  	
	                    data_tradelogs += '</li>';
	                    $(".showtradelogs > ul").append(data_tradelogs);
		    		});	
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


	$('.groupinput').on('change', 'select.data_stocks',function(){

		var sdata = $(this).val();
		var btn = $('.btnValue').val();
		var userid = $('.userid').val();
		if(btn == 'buy'){
				$.ajax({
				    type:'GET',
				    url:'/wp-json/virtual-api/v1/dstock?stock='+sdata,
				    dataType: 'json',
				    success: function(response) {

					    			$('.sdesc').text(response.data.description);
					    			$('.cprice').text((response.data.last).toFixed(2));
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

					    			$.ajax({
									    type:'GET',
									    url:'/wp-json/virtual-api/v1/marketdepth?stock='+ sdata,
									    dataType: 'json',
									    success: function(response) {

									    	var bid = parseFloat(response.data.bid_total_percent).toFixed(2);
									    	var ask = parseFloat(response.data.ask_total_percent).toFixed(2);
									    	
									    	$('.arb_bar_green').css('width', bid + '%');
									    	$('.arb_bar_red').css('width', ask + '%');
									    },
									      error: function(response) {                 
									      }
									 });
				    },
				    error: function(response) {                 
				    }
			 	});

		}else {

			$.ajax({
				    type:'GET',
				    url:'/wp-json/virtual-api/v1/toselldetails?stock='+ sdata +'&userid='+userid,
				    dataType: 'json',
				    success: function(response) {				    	
				    	
				    				$('.sdesc').text(response.data.datainfo.description);
					    			$('.cprice').text((response.data.datainfo.last).toFixed(2));
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

					    			$.ajax({
									    type:'GET',
									    url:'/wp-json/virtual-api/v1/marketdepth?stock='+ sdata,
									    dataType: 'json',
									    success: function(response) {

									    	var bid = parseFloat(response.data.bid_total_percent).toFixed(2);
									    	var ask = parseFloat(response.data.ask_total_percent).toFixed(2);
									    	
									    	$('.arb_bar_green').css('width', bid + '%');
									    	$('.arb_bar_red').css('width', ask + '%');
									    },
									      error: function(response) {                 
									      }
									 });

				     },
				    error: function(response) {                 
				    }
			 });
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

	jQuery(document).on('click', '.buymystocks', function(){
		var stock = $(this).attr('data-stock');
		$('.btnValue').val('buy');
		$("#inpt_data_select_stock").val(stock).change();
		$('#inpt_data_select_stock').prop('disabled', 'disabled');
		$('.bsbutton').css('display','none');
		$('.label_enter').text('Enter Buy Order:');
	});

	jQuery(document).on('click', '.sellmystocks', function(){
		var stock = $(this).attr('data-stock');
		$('.btnValue').val('sell');
		$("#inpt_data_select_stock").val(stock).change();
		$('#inpt_data_select_stock').prop('disabled', 'disabled');
		$('.bsbutton').css('display','none');
		$('.label_enter').text('Enter Sell Order:');
	});
	
	jQuery(document).on('click', '.enter-trade-btn', function(){
		$('.bsbutton').css('display','inline-block');
		$('#inpt_data_select_stock').prop('disabled', false);
		$('.label_enter').text('Enter Order:');
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
                    'Your Watchlist has been deleted.',
                    'success'
                ).then((result) => {
                	deletedata(id);
                    //var ditemtoremove = jQuery(this).attr('data-space');
                    //window.location.href = "/watchlist/?remove="+ditemtoremove;
                });
            }
        });
	});


	$('.btnbuy').on('click', function(){
		$('.btnbuy').css('background','#25ae5f');
		$('.btnsell').css('background','none');
		$('.labelprice').text('Buy Price');
		$('.btnValue').val('buy');
		$.ajax({
			    type:'GET',
			    url:'/wp-json/virtual-api/v1/buyvalues',
			    dataType: 'json',
			    success: function(response) {
			    	var opt = '';
			    	$('#inpt_data_select_stock option').remove();
			    	$.each(response.data, function(i, val) {
			    		opt = "<option value="+ val.symbol +">" + val.symbol + "</option>";
			    		$('#inpt_data_select_stock').append(opt);
			    	});

			    },
			      error: function(response) {                 
			      }
			 });

	});

	$('.btnsell').on('click', function(){
		$('.btnsell').css('background','#e64c3c');
		$('.btnbuy').css('background','none');
		$('.labelprice').text('Sell Price');
		$('.btnValue').val('sell');

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
		var volume = $('.pdetails.vol').text();
		var averageprice = $('.pdetails.av').text();
		var emotion = $('.inpt_data_emotion').val();
		var strategy = $('.inpt_data_strategy').val();
		var tradeplan = $('.inpt_data_tradeplan').val();
		var tradenotes = $('.tnotes').val();
		var d = new Date();
		var buydate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
		var userid = $('.userid').val();
		var btn = $('.btnValue').val();

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
			    },
			    error: function(response){                 
			      }
			 });

		}


	});

});