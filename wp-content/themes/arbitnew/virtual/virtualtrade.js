$(document).ready(function(){

	var stockdata;
	$.ajax({
	    type:'GET',
	    url:'/wp-json/virtual-api/v1/buyvalues',
	    dataType: 'json',
	    success: function(response) {
	    	var opt = '';
	    	stockdata = response;
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
		$.each(stockdata.data, function(i, val) {

	    		if(sdata == val.symbol){
	    			$('.sdesc').text(val.description);
	    			$('.cprice').text(val.last);
	    			$('.pdetails.prev').text(val.close);
	    			$('.pdetails.low').text(val.low);
	    			$('.pdetails.klow').text(val.weekyearlow);
	    			$('.pdetails.vol').text(val.volume);
	    			$('.pdetails.trade').text(val.trades);
	    			$('.pdetails.open').text(val.open);
	    			$('.pdetails.high').text(val.high);
	    			$('.pdetails.khigh').text(val.weekyearhigh);
	    			$('.pdetails.val').text(val.value);
	    			$('.pdetails.av').text(val.average);

	    			$.ajax({
					    type:'GET',
					    url:'/wp-json/virtual-api/v1/marketdepth?stock='+ sdata,
					    dataType: 'json',
					    success: function(response) {

					    	var bid = (response.data.bid_total_percent).toFixed(2);
					    	var ask = (response.data.ask_total_percent).toFixed(2);
					    	console.log('bid->' + bid + ' ask->' + ask);

					    },
					      error: function(response) {                 
					      }
					 });


	    		} 
	    });

	});




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