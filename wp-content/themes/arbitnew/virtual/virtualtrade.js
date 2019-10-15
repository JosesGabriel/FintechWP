$(document).ready(function(){

	$.ajax({
	    type:'POST',
	    url:'/wp-json/virtual-api/v1/virtualdata?stockname=2GO',
	    dataType: 'json',
	    success: function(response) {
	    	console.log(response);
	    },
	      error: function(response) {                 
	      }
	 });


});