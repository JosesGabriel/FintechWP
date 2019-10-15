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

	$('#inpt_data_select_stock').on('change', function() {
		var stock = $(this).val();
		console.log();
	});

});