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

		if($('.bbuy').css('display') == 'none'){
			$('.bbuy').css('display','block');
			$('.bsell').css('display','none');
		}else{
			$('.bbuy').css('display','none');
		}
	});

	$('.btnsell').on('click', function(){

		if($('.bsell').css('display') == 'none'){
			$('.bsell').css('display','block');
			$('.bbuy').css('display','none');
		}else{
			$('.bsell').css('display','none');
		}
	});

});