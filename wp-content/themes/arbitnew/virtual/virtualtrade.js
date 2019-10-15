$(document).ready(function(){

	$.ajax({
	    type:'POST',
	    url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol=PHEN',
	    dataType: 'json',
	    success: function(response) {
	    	console.log(response);
	    },
	      error: function(response) {                 
	      }
	 });


});