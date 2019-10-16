$(document).ready(function(){


	$.ajax({
	    type:'POST',
	    url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE',
	    dataType: 'json',
	    success: function(response) {
	    	var opt = '';
	    	jQuery.each(response.data, function(i, val) {
	    		opt = "<option value="+ val.symbol +">" + val.symbol + "</option>";
	    		$('#inpt_data_select_stock').append(opt);
	    	});
	    },
	      error: function(response) {                 
	      }
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