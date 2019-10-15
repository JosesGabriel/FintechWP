$(document).ready(function(){

	$.ajax({
	    type:'POST',
	    url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE',
	    dataType: 'json',
	    success: function(response) {
	    	var opt = '';
	    	jQuery.each(response.data, function(i, val) {
	    		console.log(val.symbol);
	    		opt = "<option value="+ val.symbol +">" + val.symbol + "</opttion>";
	    		$('#inpt_data_select_stock').append(opt);
	    	});
	    },
	      error: function(response) {                 
	      }
	 });


});