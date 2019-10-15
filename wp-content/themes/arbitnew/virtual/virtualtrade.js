$(document).ready(function(){

	$.ajax({
	    type:'POST',
	    url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE',
	    dataType: 'json',
	    success: function(response) {
	    	jQuery.each(response.data, function(i, val) {
	    		console.log(val.symbol);
	    	});
	    },
	      error: function(response) {                 
	      }
	 });


});