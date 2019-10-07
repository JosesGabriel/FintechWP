
		(function($) {
			//global stockList 
			var stockList=[];
			var vm = this;

		    jQuery(document).ready(function() {

		    	var postid;
		    	var usersall = `<?php echo json_encode([]); ?>`;

				//query all stocks
				$.ajax({
					type: 'GET',
					url: '/wp-json/data-api/v1/stocks/list',
					dataType: 'json',

					success: function(response) {
						let stockListArr = [];

						//append all keys to stockListArr
						Object.keys(response.data).forEach(key => {
							stockListArr.push(key);
						});

						//assign to global stockList
						vm.stockList = stockListArr;
					}
				});

		    	jQuery(".um-activity-new-post .um-activity-textarea").append('<div class="tagging_cont"></div>');
				jQuery(this).on('keyup', '.um-activity-comment-textarea', function (e) {
					postid = jQuery(this).parents('.um-activity-widget').attr('id').replace('postid-', '');

					if($(this).parent().find('.comment_tag_' + postid).length == 0){
						jQuery(this).parents('.um-activity-comment-box').append('<div class="comment_tag_'+postid+'"></div>');

					}

				});

		    	jQuery(this).scrollTop(0);
		    	jQuery(".nobar").click(function(e){
					e.preventDefault();
					event.stopPropagation();

					if (jQuery("ul.closehideme").hasClass('opened')) {
						jQuery("ul.closehideme").fadeOut().css('display', 'none').removeClass('opened');
					} else {
						jQuery("ul.closehideme").fadeIn().css('display', 'inline-block').addClass('opened');
					}

				});

		    	var dauto = false;
		    	var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', '#ffeb3b'];
		    	var arraylimit = colors.length - 1;
				var loopfriends;
				jQuery('.um-activity-textarea textarea').on('keydown', function (e) {
					clearTimeout(loopfriends);
				});

		        jQuery('.um-activity-textarea textarea').on('keyup', function (e) {

		        	var string = jQuery(this).val();
		        	var lastChar = string.substr(string.length -1);

		        	if($(this).val().length < 2 || lastChar == '$') {
		        		jQuery(".um-activity-new-post .um-activity-textarea .tagging_cont > li").remove();
		        		jQuery(this).parent().find(".popname").remove();
		        		return;
		        	}


		        	var counx = 0;
					clearInterval(loopfriends);

							jQuery(".um-activity-new-post .um-activity-textarea .tagging_cont")
		        	if (e.which == 52) { dauto = true; }
		        	if (e.which == 32) { dauto = false; }

		        	var dcontexttext = jQuery(this).val();
		        	var res = dcontexttext.split(" ");
		        	var dlastitem = res[res.length-1];
		        	var i;

					 jQuery(".um-activity-new-post .um-activity-textarea .tagging_cont > li").remove();
					if(!(dlastitem.indexOf('@') === -1)){
						dauto = false;
						loopfriends = setInterval(function(){
							if(dlastitem != ''){
								var results = JSON.parse(usersall);
								var len = results.length;
								var input = dlastitem.substring(1, dlastitem.length);
								$countxs = 0;
								for ( i = 0 ; i<len;i++){

									var name = results[i].displayname;
									var rgxp = new RegExp(input, "gi");

									if (name.match(rgxp)) {

										var fullname = results[i].displayname;
										jQuery(".um-activity-new-post .um-activity-textarea .tagging_cont").append('<li class="cgitem num_'+i+'" data-id="'+results[i].id+'"  style="list-style: none; cursor: pointer; display: inline-block !important; padding: 2px 6px;  margin: 3px 0 0 3px; font-size: 13px; color: #d8d8d8; border-radius: 4px; background-color: #213f58;">'+fullname+'</li>');
										if($countxs > 8) { break; }
										$countxs++;
									}
								}
							}else{
								return false;
							}
							clearInterval(loopfriends);
						}, 500);

					} else if (dlastitem.indexOf('$') === -1) {
				    	dauto = false;
				    } else {
				    	dauto = true;
				    }

				    if (dauto) {
				    	var stocks = vm.stockList;
        				stocks = JSON.parse(stocks);
				    	jQuery(this).parent().find(".popname").remove();

						var finddword = dlastitem.toUpperCase();
				    	var dpop = "";
				    	dpop += '<div class="popname">';
					    	dpop += '<ul>';
					    	$.each(stocks, function(index, dfeats){
								var sistorck = "$"+dfeats;
					    		if (sistorck.indexOf(finddword) >= 0) {
					    			dpop += '<li style="background-image: linear-gradient(to right, '+colors[counx]+' , '+colors[(counx + 0 >= arraylimit ? 0 : counx + 1)]+');color:#fff;"><span class="inboxc">'+dfeats+'</span></li>';

					    			if (counx >= (arraylimit)) {
						    			counx = 0;
						    		} else {
						    			counx++;
						    		}
					    		}


					    	});
					    	dpop += '</ul>';
				    	dpop += '</div>';
				    	jQuery(this).parent().append(dpop);
				    } else {
				    	jQuery(this).parent().find(".popname").remove();
				    }
				});


		jQuery(this).on('keyup','.um-activity-comment-textarea', function(e){


					var comment_id = jQuery(this).attr('data-reply_to');
		        	var counx = 0;
					clearInterval(loopfriends);

		        	if (e.which == 52) { dauto = true; }
		        	if (e.which == 32) { dauto = false; }

		        	var dcontexttext = $(this).val();
		        	var res = dcontexttext.split(" ");
		        	var dlastitem = res[res.length-1];
		        	var i;

		        	if(comment_id != 0 ){
							postid = comment_id;
					}
					$(".um-activity-comment-box .comment_tag_" + postid + " > li").remove();

					if(!(dlastitem.indexOf('@') === -1)){
						dauto = false;
						loopfriends = setInterval(function(){
								 if(dlastitem != ''){
								 	var results = JSON.parse(usersall);
								 	var len = results.length;
								 	var input = dlastitem.substring(1, dlastitem.length);
										$countxs = 0;
								 		for ( i = 0 ; i<len;i++){

								 			var name = results[i].displayname;
								 			var rgxp = new RegExp(input, "gi");
								 			if (name.match(rgxp)) {

												var fullname = results[i].displayname;

											if(comment_id != 0 ){

												postid = comment_id;
											}

											jQuery(".um-activity-comment-box .comment_tag_"+postid).append('<li class="cgitem num_'+i+'" data-id="'+results[i].id+'" user-login="'+results[i].user_login+'" style="list-style: none; cursor: pointer; display: inline-block !important; padding: 2px 6px;  margin: 3px 0 0 3px; font-size: 13px; color: #d8d8d8; border-radius: 4px; background-color: #213f58; ">'+fullname+'</li>');

												if($countxs > 8) { break; }
												$countxs++;
											}

								 		}
							    }else{
							      return false;
							    }


							clearInterval(loopfriends);
						}, 500);

					} else if (dlastitem.indexOf('$') === -1) {
				    	dauto = false;

				    } else {
				    	dauto = true;
				    }
				});

		  	$(document).on('click','.cgitem', function(){

				var textval = jQuery(this).parents('.um-activity-comment-box').find('textarea').val();

				var did = jQuery(this).attr('data-id');

				var user1 = jQuery(this).parents('.um-activity-comment-box').find('input.userlogin').attr('value');

				userlogin = jQuery(this).attr('user-login') + ' ' + user1;

				var isname = jQuery(this).text();

				var dtextareas = jQuery(this).parents('.um-activity-comment-box').find('textarea').val();

				var dfinalname = isname.replace(' ', '_').toLowerCase();

				var n = dtextareas.lastIndexOf("@");

				var comm = dtextareas.slice(0, n);

				var dreplaceditem = comm + '@'+did+'_'+dfinalname;

				jQuery(this).parents('.um-activity-comment-box').find('textarea').val(dreplaceditem).focus();
		  	});




			$(".um-activity-new-post .um-activity-textarea .tagging_cont").on("click", ".cgitem", function(){
				jQuery(this).hide("slow");
				var textval = jQuery(this).parents('.um-activity-textarea').find('textarea').val();
				var did = jQuery(this).attr('data-id');
				var isname = jQuery(this).text();
				var dtextareas = jQuery(this).parents('.um-activity-textarea').find('textarea').val();
				var res = dtextareas.split(" ");

				var dlastitem = res[res.length-1];

				var dfinalname = isname.replace(' ', '_').toLowerCase();

				var n = dtextareas.lastIndexOf("@");

				var comm = dtextareas.slice(0, n);
				// format information as per data
				//var dreplaceditem = dtextareas.replace(dlastitem, '@'+did+'_'+dfinalname);
				var dreplaceditem = comm + '@'+did+'_'+dfinalname;

				jQuery(this).parents('.um-activity-textarea').find('textarea').val(dreplaceditem).focus();
			});

			jQuery(".um-activity-textarea").on("click", ".popname ul li", function(){
				var dsaid = jQuery(this).parents('.um-activity-textarea').find('textarea').val();
				var res = dsaid.split(" ");
				var newdesc = dsaid.replace(res[res.length-1], '$'+jQuery(this).text());
				jQuery(this).parents('.um-activity-textarea').find('textarea').val(newdesc);
				jQuery(this).parents('.um-activity-textarea').find(".popname").remove();
			});

		});

	})(jQuery);

  $(document).ready(function(){

    //Start Notifications ============================================================================================================================

    function getval() {
      var currentTime = new Date()
      var hours = currentTime.getHours()
      var minutes = currentTime.getMinutes()

      if (minutes < 10) minutes = "0" + minutes;

      var suffix = "AM";
      if (hours >= 12) {
          suffix = "PM";
          hours = hours - 12;
      }
      if (hours == 0) {
          hours = 12;
      }
      var current_time = hours + ":" + minutes + " " + suffix;

      return current_time;
    }

    function get24Hr(time){
      var hours = Number(time.match(/^(\d+)/)[1]);
      var AMPM = time.match(/\s(.*)$/)[1];
      if(AMPM == "PM" && hours<12) hours = hours+12;
      if(AMPM == "AM" && hours==12) hours = hours-12;

      var minutes = Number(time.match(/:(\d+)/)[1]);
      hours = hours*100+minutes;
      return hours;
    }

    function newwatchlist(){
            jQuery.ajax({
                method: "get",
                url: "/sidebar-api/?daction=get_user_metas",
                dataType: 'json',
                success: function(data){
                  var usermetas = data;
                  $.each(usermetas, function(index, dinfo){
                    var stockname = dinfo.stockname;
                    console.log("Stockname: " + stockname);
                    jQuery.ajax({
                      method: "get",
                      url: "/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol=" + stockname,
                      dataType: 'json',
                      success: function(data){
                        var stocklastdata = parseFloat(data.data.last);

                        //compare now

                        //Entry Price

                          if (parseFloat(dinfo.dconnumber_entry_price) == stocklastdata.toFixed(2)) {
                            var dslert = '<div class="noti-message">';
                              dslert += '<div class="vertical-align">';
                                dslert += '<a class="cont-logo">';
                                  dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
                                dslert += '</a>';
                                dslert += '<div class="md-rightside">';
                                  dslert += '<a class="cont-bodymessage">';
                                    dslert += 'Buy Now! <br>';
                                    dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

                                  dslert += '</a>';
                                  dslert += '<div class="op-btnchart">';
                                    dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
                                    dslert += '<div class="btn-close xclsbtn">Close</div>';
                                  dslert += '</div>';
                                dslert += '</div>';
                              dslert += '</div>';
                            dslert += '</div>';
                            jQuery(".alert-handler").append(dslert);

                          }

                        //stoplosspoint

                          if (parseFloat(dinfo.dconnumber_stop_loss_point) > stocklastdata.toFixed(2)) {
                            var dslert = '<div class="noti-message">';
                              dslert += '<div class="vertical-align">';
                                dslert += '<a class="cont-logo">';
                                  dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
                                dslert += '</a>';
                                dslert += '<div class="md-rightside">';
                                  dslert += '<a class="cont-bodymessage">';
                                    dslert += 'Sell Now and Stop your loss! <br>';
                                    dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

                                  dslert += '</a>';
                                  dslert += '<div class="op-btnchart">';
                                    dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
                                    dslert += '<div class="btn-close xclsbtn">Close</div>';
                                  dslert += '</div>';
                                dslert += '</div>';
                              dslert += '</div>';
                            dslert += '</div>';
                            jQuery(".alert-handler").append(dslert);
                          }

                        //takeprofit

                          if (parseFloat(dinfo.dconnumber_take_profit_point) < stocklastdata.toFixed(2)) {
                            var dslert = '<div class="noti-message">';
                              dslert += '<div class="vertical-align">';
                                dslert += '<a class="cont-logo">';
                                  dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
                                dslert += '</a>';
                                dslert += '<div class="md-rightside">';
                                  dslert += '<a class="cont-bodymessage">';
                                    dslert += 'Sell Now and Secure your Profit! <br>';
                                    dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

                                  dslert += '</a>';
                                  dslert += '<div class="op-btnchart">';
                                    dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
                                    dslert += '<div class="btn-close xclsbtn">Close</div>';
                                  dslert += '</div>';
                                dslert += '</div>';
                              dslert += '</div>';
                            dslert += '</div>';
                            jQuery(".alert-handler").append(dslert);
                          }

                      }
                    });
                  });
                }
            });
    }


      function removealerts() {
        jQuery(".alert-handler").find('div').fadeOut( "slow", function() {
          jQuery(this).remove();
        });
      }

      jQuery(".alert-handler").on("click", ".xclsbtn", function(){
        jQuery(this).parents('.noti-message').fadeOut( "slow", function() {
          jQuery(this).remove();
        });
      });



    var startTime = '09:30 AM';
    var endTime = '11:30 PM';
    var curr_time = getval();
    if (get24Hr(curr_time) > get24Hr(startTime) && get24Hr(curr_time) < get24Hr(endTime)) {
      newwatchlist();

        $counts = 1;
        setInterval(function(){
            $counts++;
            removealerts();
            if ($counts <= 1) {
            newwatchlist();
            }
        },30000);
    }

    //End Notifications ============================================================================================================================


  });
