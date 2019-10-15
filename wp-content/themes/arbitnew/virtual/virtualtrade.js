$(document).ready(function(){

	$.ajax({
	    type:'GET',
	    url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE',
	    dataType: 'json',
	    success: function(response) {
	    	console.log(response);
	    },
	      error: function(response) {                 
	      }
	 });


});