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
	});

	$('.btnsell').on('click', function(){
		$('.btnsell').css('background','#e64c3c');
		$('.btnbuy').css('background','none');
		$('.labelprice').text('Sell Price');
	});

});