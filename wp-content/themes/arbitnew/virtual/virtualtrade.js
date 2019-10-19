$(document).ready(function(){

	livedata();

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

function livedata(){
	var userid = $('.userid').val();
   	$.ajax({
	    type:'GET',
	    url:'/wp-json/virtual-api/v1/liveportfolio?userid='+userid,
	    dataType: 'json',
	    success: function(response) {
	    	console.log(response);
	     },
	    error: function(response) {                 
	    }
	});
}


	$('.groupinput').on('change', 'select.data_stocks',function(){

		var sdata = $(this).val();
		var btn = $('.btnValue').val();
		var userid = $('.userid').val();
		if(btn == 'buy'){
				$.ajax({
				    type:'GET',
				    url:'/wp-json/virtual-api/v1/dstock?stock='+sdata,
				    dataType: 'json',
				    success: function(response) {

					    			$('.sdesc').text(response.data.description);
					    			$('.cprice').text((response.data.last).toFixed(2));
					    			$('.pdetails.prev').text((response.data.close).toFixed(2));
					    			$('.pdetails.low').text((response.data.low).toFixed(2));
					    			$('.pdetails.klow').text(response.data.weekyearlow);
					    			$('.pdetails.vol').text(nFormatter(parseFloat(response.data.volume)));
					    			$('.pdetails.trade').text((response.data.trades).toFixed(2));
					    			$('.pdetails.open').text((response.data.open).toFixed(2));
					    			$('.pdetails.high').text((response.data.high).toFixed(2));
					    			$('.pdetails.khigh').text((response.data.weekyearhigh).toFixed(2));
					    			$('.pdetails.val').text(nFormatter(parseFloat(response.data.value)));
					    			$('.pdetails.av').text((response.data.average).toFixed(2));

					    			$.ajax({
									    type:'GET',
									    url:'/wp-json/virtual-api/v1/marketdepth?stock='+ sdata,
									    dataType: 'json',
									    success: function(response) {

									    	var bid = parseFloat(response.data.bid_total_percent).toFixed(2);
									    	var ask = parseFloat(response.data.ask_total_percent).toFixed(2);
									    	
									    	$('.arb_bar_green').css('width', bid + '%');
									    	$('.arb_bar_red').css('width', ask + '%');
									    },
									      error: function(response) {                 
									      }
									 });
				    },
				    error: function(response) {                 
				    }
			 	});

		}else {

			$.ajax({
				    type:'GET',
				    url:'/wp-json/virtual-api/v1/toselldetails?stock='+ sdata +'&userid='+userid,
				    dataType: 'json',
				    success: function(response) {				    	
				    	
				    				$('.sdesc').text(response.data.datainfo.description);
					    			$('.cprice').text((response.data.datainfo.last).toFixed(2));
					    			$('.pdetails.prev').text((response.data.datainfo.close).toFixed(2));
					    			$('.pdetails.low').text((response.data.datainfo.low).toFixed(2));
					    			$('.pdetails.klow').text(response.data.datainfo.weekyearlow);
					    			$('.pdetails.vol').text(nFormatter(parseFloat(response.data.volume)));
					    			$('.pdetails.trade').text((response.data.datainfo.trades).toFixed(2));
					    			$('.pdetails.open').text((response.data.datainfo.open).toFixed(2));
					    			$('.pdetails.high').text((response.data.datainfo.high).toFixed(2));
					    			$('.pdetails.khigh').text((response.data.datainfo.weekyearhigh).toFixed(2));
					    			$('.pdetails.val').text(nFormatter(parseFloat(response.data.datainfo.value)));
					    			$('.pdetails.av').text((response.data.averageprice).toFixed(2));

					    			$.ajax({
									    type:'GET',
									    url:'/wp-json/virtual-api/v1/marketdepth?stock='+ sdata,
									    dataType: 'json',
									    success: function(response) {

									    	var bid = parseFloat(response.data.bid_total_percent).toFixed(2);
									    	var ask = parseFloat(response.data.ask_total_percent).toFixed(2);
									    	
									    	$('.arb_bar_green').css('width', bid + '%');
									    	$('.arb_bar_red').css('width', ask + '%');
									    },
									      error: function(response) {                 
									      }
									 });

				     },
				    error: function(response) {                 
				    }
			 });
		}


	});


	function nFormatter(num) {
	     if (num >= 1000000000) {
	        return (num / 1000000000).toFixed(2).replace(/\.0$/, '') + 'G';
	     }
	     if (num >= 1000000) {
	        return (num / 1000000).toFixed(2).replace(/\.0$/, '') + 'M';
	     }
	     if (num >= 1000) {
	        return (num / 1000).toFixed(2).replace(/\.0$/, '') + 'K';
	     }
	     return num;
	}

	$('.btnbuy').on('click', function(){
		$('.btnbuy').css('background','#25ae5f');
		$('.btnsell').css('background','none');
		$('.labelprice').text('Buy Price');
		$('.btnValue').val('buy');
		$.ajax({
			    type:'GET',
			    url:'/wp-json/virtual-api/v1/buyvalues',
			    dataType: 'json',
			    success: function(response) {
			    	var opt = '';
			    	$('#inpt_data_select_stock option').remove();
			    	$.each(response.data, function(i, val) {
			    		opt = "<option value="+ val.symbol +">" + val.symbol + "</option>";
			    		$('#inpt_data_select_stock').append(opt);
			    	});

			    },
			      error: function(response) {                 
			      }
			 });

	});

	$('.btnsell').on('click', function(){
		$('.btnsell').css('background','#e64c3c');
		$('.btnbuy').css('background','none');
		$('.labelprice').text('Sell Price');
		$('.btnValue').val('sell');

		var userid = $('.userid').val();
		$.ajax({
		    type:'GET',
		    url:'/wp-json/virtual-api/v1/stockstosell?userid='+ userid,
		    dataType: 'json',
		    success: function(response) {	
		    	var opt = '';    	
		    	$('#inpt_data_select_stock option').remove();
	    		$.each(response.data, function(i, val) {
		    		opt = "<option value="+ val +">" + val + "</option>";
	    			$('#inpt_data_select_stock').append(opt);
		    	});    		
		    },
		      error: function(response) {                 
		      }
		 });

	});

	$('.confirm_order').on('click', function(){

		var stockname = $('.data_stocks').val();
		var buyprice = $('.inputbuyprice').val();
		var sellprice = $('.inputbuyprice').val();
		var volume = $('.pdetails.vol').text();
		var averageprice = $('.pdetails.av').text();
		var emotion = $('.inpt_data_emotion').val();
		var strategy = $('.inpt_data_strategy').val();
		var tradeplan = $('.inpt_data_tradeplan').val();
		var tradenotes = $('.tnotes').val();
		var d = new Date();
		var buydate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
		var userid = $('.userid').val();
		var btn = $('.btnValue').val();

		if(btn == 'buy'){
			$.ajax({
			    type:'GET',
			    url:'/wp-json/virtual-api/v1/livetrade',
			    dataType: 'json',
			    data:{
			    	"stockname": stockname,
					"buyprice": buyprice,
					"volume": volume,
					"emotion": emotion,
					"strategy": strategy,
					"tradeplan": tradeplan,
					"tradenotes": tradenotes,
					"buydate": buydate,
					"category": "vtrade1",
					"type": "vt",
					"userid": userid
			    },
			    success: function(response){
					console.log('success');
					$('.chart-loader').css('display','block');
					$('.confirm_order').hide();
					 window.location.href = "/virtual-trades";
			    },
			    error: function(response){                 
			      }
			 });

		}else {

			$.ajax({
			    type:'GET',
			    url:'/wp-json/virtual-api/v1/sellstock',
			    dataType: 'json',
			    data:{
			    	"userid": userid,
					"stock": stockname,
					"volume": volume,
					"averageprice": averageprice,
					"emotion": emotion,
					"strategy": strategy,
					"tradeplan": tradeplan,
					"tradenotes": tradenotes,
					"sellprice": sellprice,
					"buydate": buydate
			    },
			    success: function(response){
					console.log(response.data);
					$('.chart-loader').css('display','block');
					$('.confirm_order').hide();
					 window.location.href = "/virtual-trades";
			    },
			    error: function(response){                 
			      }
			 });

		}


	});

});