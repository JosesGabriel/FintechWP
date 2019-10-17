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

	$('.data_stocks').on('change', function(){

		console.log($(this).val());

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