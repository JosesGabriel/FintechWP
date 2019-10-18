$(document).ready(function(){

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


	$('.groupinput').on('change', 'select.data_stocks',function(){

		var sdata = $(this).val();
		var btn = $('.btnValue').val();

		if(btn == 'buy'){
				$.ajax({
				    type:'GET',
				    url:'/wp-json/virtual-api/v1/buyvalues',
				    dataType: 'json',
				    success: function(response) {

				    	$.each(response.data, function(i, val) {

					    		if(sdata == val.symbol){
					    			$('.sdesc').text(val.description);
					    			$('.cprice').text((val.last).toFixed(2));
					    			$('.pdetails.prev').text((val.close).toFixed(2));
					    			$('.pdetails.low').text((val.low).toFixed(2));
					    			$('.pdetails.klow').text(val.weekyearlow);
					    			$('.pdetails.vol').text(nFormatter(parseFloat(val.volume)));
					    			$('.pdetails.trade').text((val.trades).toFixed(2));
					    			$('.pdetails.open').text((val.open).toFixed(2));
					    			$('.pdetails.high').text((val.high).toFixed(2));
					    			$('.pdetails.khigh').text((val.weekyearhigh).toFixed(2));
					    			$('.pdetails.val').text(nFormatter(parseFloat(val.value)));
					    			$('.pdetails.av').text((val.average).toFixed(2));

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


					    		} 
					    });
				    	

				    },
				    error: function(response) {                 
				    }
			 	});

		}else {

			$.ajax({
				    type:'GET',
				    url:'/wp-json/virtual-api/v1/toselldetails?stock=' + sdata,
				    dataType: 'json',
				    success: function(response) {
				    	console.log(response);
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
		var volume = $('.pdetails.vol').text();
		var emotion = $('.inpt_data_emotion').val();
		var strategy = $('.inpt_data_strategy').val();
		var tradeplan = $('.inpt_data_tradeplan').val();
		var tradenotes = $('.tnotes').val();
		var d = new Date();
		var buydate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
		var userid = $('.userid').val();
		
			$.ajax({
			    type:'GET',
			    url:'/wp-json/virtual-api/v1/livetrade',
			    dataType: 'json',
			    data:{
			    	"stockname": "PHEN",
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
					$('.chart-loader').css('display','block');
					$('.confirm_order').hide();
					 window.location.href = "/virtual-trades";
			    },
			    error: function(response){                 
			      }
			 });

	});

});