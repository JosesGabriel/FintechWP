<?php
/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;

do_action( 'et_after_main_content' );

if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<!-- <footer id="main-footer">
				<div class="on-footer-inner">
					<div class="on-footer-left">
						<div class="on-foot-left-inner">
							<?php
								// wp_nav_menu( array( 'menu' => 'footer-left', 'container_class' => 'custom-menu-class' ) ); 
							?>
						</div>
					</div>
					<div class="on-footer-middle">
						<div class="on-footer-mid-inner">
							<img src="/wp-content/uploads/2018/12/logo.png">
						</div>
					</div>
					<div class="on-footer-right">
						<div class="on-foot-right-inner">
							<?php
								// wp_nav_menu( array( 'menu' => 'footer-right', 'container_class' => 'custom-menu-class' ) ); 
							?>
						</div>
					</div>
					<br class="clear">
				</div>
			</footer>  -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>
	<div style="display: none;">
		<a id="entry_price">&nbsp;</a>
		<a id="take_profit_point">&nbsp;</a>
		<a id="stop_loss_point">&nbsp;</a>
	</div>
	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
	<script src="/wp-content/plugins/um-friends/assets/js/um-friends.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js" integrity="sha256-BfIfo/K+ePw1iAn4BFfrfVXmXQPAmKtqeDwVIgCFqTU=" crossorigin="anonymous"></script>

	<?php
		$dwatchdd = get_user_meta('7', '_scrp_stocks_watch', true);
		$ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".add-post .um-activity-widget").each(function(i, obj) {
				var baseimage = jQuery(this).find(".um-activity-ava a img").attr('src');
				jQuery(this).find(".um-activity-ava a").css('background', 'url('+baseimage+') no-repeat center center').addClass("d_profile_image");
			});

			jQuery(".um-activity-comments .um-activity-commentl.um-activity-comment-area .um-activity-right").hide();

			jQuery(".um-activity-widget .um-activity-comments .um-activity-commentl.um-activity-comment-area .um-activity-comment-box textarea").keyup(function() {
				if (jQuery(this).val() == "") {
					jQuery(this).parents(".um-activity-comments").find(".um-activity-right").hide("slow");
				} else {
					jQuery(this).parents(".um-activity-comments").find(".um-activity-right").show("slow");
				}
			});



			jQuery(".moretoclick").click(function(e){
				e.preventDefault();
				
				if (jQuery("ul.closehideme").hasClass('opened')) {
					jQuery("ul.closehideme").fadeOut().css('display', 'none').removeClass('opened');
				} else {
					jQuery("ul.closehideme").fadeIn().css('display', 'inline-block').addClass('opened');
				}

			});

			jQuery(".header-dashboard .user-image").click(function(e){
				e.preventDefault();
				var isopen = jQuery("ul.main-drop > ul").hasClass("dropopen");

				if (isopen) {
					jQuery("ul.main-drop > ul").hide('slow').removeClass("dropopen");

				} else {
					jQuery("ul.main-drops > ul").hide('slow').removeClass("dropopen");
					jQuery("ul.main-drop > ul").show('slow').addClass("dropopen");
				}
				
			});


			jQuery(".header-dashboard .ontotools").click(function(e){
				e.preventDefault();
				var isopen = jQuery("ul.main-drops > ul").hasClass("dropopen");

				if (isopen) {
					jQuery("ul.main-drops > ul").hide('slow').removeClass("dropopen");

				} else {
					jQuery("ul.main-drop > ul").hide('slow').removeClass("dropopen");
					jQuery("ul.main-drops > ul").show('slow').addClass("dropopen");
				}
				
			});

			jQuery(".add-post .um-activity-new-post .um-activity-head").text('Share your Ideas');
			jQuery(".add-post .um-activity-new-post .um-activity-textarea textarea").attr("placeholder", "Make a post");

			jQuery('.add-params').click(function(e) {
				e.preventDefault();

				var dcondition = jQuery(this).parents('.condition-params').find("#condition-list").val();
				var dnum = jQuery(this).parents('.condition-params').find('#condition_frequency').val();

				if (dcondition != "" && dnum != "") {
					jQuery(this).parents('.condition-params').find('#condition-list option[value='+dcondition+']').hide();
					jQuery(this).parents('.condition-params').find("#condition-list").val('');
					jQuery(this).parents('.condition-params').find('#condition_frequency').val('')

					var dlisk = '<li class="dbaseitem">';
							dlisk += '<div class="dinfodata">';
								dlisk += '<div class="dcondition">';
									dlisk += (dcondition == "entry_price" ? "Entry Price: " : (dcondition == "take_profit_point" ? "Take Profit" : (dcondition == "stop_loss_point" ? "Stop Loss" : ""))) + " " + dnum;
								dlisk += '</div>';
								// dlisk += '<div class="dfreq">';
								// 	dlisk += dnum;
								// dlisk += '</div>';
							dlisk += '</div>';
							dlisk += '<div class="closetab">';
							dlisk += '<input type="hidden" id="dparamcondition" name="dcondition_'+dcondition+'" value="'+dcondition+'">';
							dlisk += '<input type="hidden" id="" name="dconnumber_'+dcondition+'" value="'+dnum+'">';
							dlisk += '<button class="closemebutton"><i class="fa fa-minus-circle"></i></button>';
							dlisk += '</div>';
							dlisk += '<br style="clear:both;">';
						dlisk += "</li>";

					jQuery(".listofinfo").append(dlisk);
				}
			});

			// jQuery('.closemebutton').click(function(e){

			// });

			jQuery('#submitmenow').click(function(e){
				e.preventDefault();
				var isstock = jQuery(this).parents('#add-watchlist-param').find("#dstocknames").val();

				var countli = jQuery(".listofinfo li").length;

				if (countli != 0) {
					if (isstock != "" && jQuery("#add-watchlist-param input:checkbox:checked").length > 0 ) {
						jQuery("#add-watchlist-param").submit();
					}
				}
			});

			jQuery('#canceladd').click(function(e){
				e.preventDefault();
				jQuery(".dtabcontent > div").removeClass('active').hide('slow');
				jQuery(".dtabcontent .watchtab").addClass('active').show('slow');
			});

			jQuery('.optbase ul li').click(function(e){
				var dtabname = jQuery(this).attr('data-toptab');

				jQuery(".dtabcontent > div").removeClass('active').hide('slow');
				jQuery(".dtabcontent ."+dtabname).addClass('active').show('slow');
			});

			jQuery('.addwatch').click(function(e){
				jQuery(".dtabcontent > div").removeClass('active').hide('slow');
				jQuery(".dtabcontent .addwatchtab").addClass('active').show('slow');
			});

			jQuery('.removeItem').click(function(e){
				e.preventDefault();

				Swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.value) {
						Swal.fire(
							'Deleted!',
							'Your Watchlist has been deleted.',
							'success'
						).then((result) => {
							var ditemtoremove = jQuery(this).attr('data-space');
							window.location.href = "/watchlist/?remove="+ditemtoremove;
						});
					}
				});
			});

			jQuery('.editmenow').click(function(e){
				e.preventDefault();
				jQuery("#"+jQuery(this).attr('data-tochange')).submit();

			});

			//FILTER AS PER TIME
			var startTime = '9:00 AM';
		    var endTime = '3:30 PM';

		    var curr_time = getval();

		    if (get24Hr(curr_time) > get24Hr(startTime) && get24Hr(curr_time) < get24Hr(endTime)) {
		      //in between these two times
			 //    jQuery.ajax({
				//  	method: "POST",
				// 	url: "<?php // echo admin_url( 'admin-ajax.php' );?>",
				// 	dataType: 'json',
				// 	data: {
				// 		'action' : 'my_custom_action'
				// 	},
				// 	success: function(data) {
				// 	  	jQuery.each(data, function(mainindex, mainvalue){
				// 	  		jQuery.each(mainvalue.alerts, function(index, value){
				// 		  		if (value == 'entry_price') {
				// 		  			jQuery("#entry_price").attr("data-stock", mainvalue.stock).attr("data-price", mainvalue.current_price).trigger('click');
				// 		  		}

				// 		  		if (value == 'take_profit_point') {
				// 		  			jQuery("#take_profit_point").attr("data-stock", mainvalue.stock).attr("data-price", mainvalue.current_price).trigger('click');
				// 		  		}
						  		
				// 		  		if (value == 'stop_loss_point') {
				// 		  			jQuery("#stop_loss_point").attr("data-stock", mainvalue.stock).attr("data-price", mainvalue.current_price).trigger('click');
				// 		  		}
				// 		  	});
				// 	  	});
				// 	}
				// });

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

			

			// window.setInterval(function(){
			// 	if (get24Hr(curr_time) > get24Hr(startTime) && get24Hr(curr_time) < get24Hr(endTime)) {
			// 		jQuery.ajax({
			// 		 	method: "POST",
			// 			url: "<?php // echo admin_url( 'admin-ajax.php' );?>",
			// 			dataType: 'json',
			// 			data: {
			// 				'action' : 'my_custom_action'
			// 			},
			// 			success: function(data) {
			// 			  // if (!jQuery.isEmptyObject(data.alerts)) {	
			// 			  	jQuery.each(data, function(mainindex, mainvalue){
			// 			  		jQuery.each(mainvalue.alerts, function(index, value){
			// 				  		if (value == 'entry_price') {
			// 				  			jQuery("#entry_price").attr("data-stock", mainvalue.stock).attr("data-price", mainvalue.current_price).trigger('click');
			// 				  		}

			// 				  		if (value == 'take_profit_point') {
			// 				  			jQuery("#take_profit_point").attr("data-stock", mainvalue.stock).attr("data-price", mainvalue.current_price).trigger('click');
			// 				  		}
							  		
			// 				  		if (value == 'stop_loss_point') {
			// 				  			jQuery("#stop_loss_point").attr("data-stock", mainvalue.stock).attr("data-price", mainvalue.current_price).trigger('click');
			// 				  		}
			// 				  	});
			// 			  	});
						  	
						  	
			// 			  // }

			// 			}
			// 		});
			// 	}
			// }, 60000);

			
			jQuery("#entry_price").click(function(e){
				var dmessage = jQuery(this).attr('data-stock');
				var dprice = jQuery(this).attr('data-price');

				Lobibox.notify('success', {
				    size: 'mini',
				    sound: false,
				    delay: (30 * 1000),
	                rounded: true,
	                delayIndicator: false,
	                msg: dmessage+' price is Php'+ dprice +". Buy Now!"
				});
			});

			jQuery("#take_profit_point").click(function(e){
				var dmessage = jQuery(this).attr('data-stock');
				var dprice = jQuery(this).attr('data-price');

				Lobibox.notify('info', {
				    size: 'mini',
				    sound: false,
				    delay: (30 * 1000),
	                rounded: true,
	                delayIndicator: false,
	                msg: dmessage+' price is Php'+ dprice +". Sell Now and be Rewarded!"
				});
			});

			jQuery("#stop_loss_point").click(function(e){
				var dmessage = jQuery(this).attr('data-stock');
				var dprice = jQuery(this).attr('data-price');

				Lobibox.notify('warning', {
				    size: 'mini',
				    sound: false,
				    delay: (30 * 1000),
	                rounded: true,
	                delayIndicator: false,
	                msg: dmessage+' price is Php'+ dprice +". Sell Now and Stop your Loss!"
				});
			});

			jQuery('#myDropdown').click(function(e){
				e.preventDefault();
				if (jQuery(this).hasClass('disopen')) {
					jQuery(this).removeClass('disopen');
					jQuery('.ddropbase').removeClass('opendrop').hide('slow');
				} else {
					jQuery(this).addClass('disopen');
					jQuery('.ddropbase').addClass('opendrop').show('slow');
				}
			});

			jQuery( "#myInput" ).keyup(function(e) {
				e.preventDefault();

				var dtyped = jQuery(this).val();

				jQuery(".listofstocks > a").each(function(index){
					var istock = jQuery(this).attr('data-dstock');
					if (istock.toLowerCase().indexOf(dtyped) >= 0) {
						jQuery(this).show();
					} else {
						jQuery(this).hide();
					}
				});
			});
			var ddatass = jQuery('.to-watch-data').attr("data-dhisto");

		});
	

		jQuery(window).bind("load", function() {
		   jQuery('.messages-page-inner .ifc.ifc-embed #ifc-app .ifc-embed-threads').addClass('here');
		});

		jQuery(document).on('keyup','.um-activity-widget .um-activity-comments .um-activity-commentl.um-activity-comment-area .um-activity-comment-box textarea', function(){
		   if (jQuery(this).val() == "") {
		   		jQuery(this).css('line-height', '30px !important');
				jQuery(this).parents(".um-activity-comments").find(".um-activity-right").hide("slow");
			} else {
				jQuery(this).parents(".um-activity-comments").find(".um-activity-right").show("slow");
				jQuery(this).css('line-height', '1.3em !important');

			}
		});

		jQuery(document).on('click','.closemebutton',function(e){
			var drestore = jQuery(this).parents('.dbaseitem').find('#dparamcondition').val();
			jQuery('#condition-list option[value='+drestore+']').show();
			jQuery(this).parents('.dbaseitem').remove();
		});

	</script>

	<?php /*?><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

		jQuery( "#tableStock tr" ).each(function( index ) {

			var ddata = jQuery(this).attr('data-dhisto'); 
			var dstock = jQuery(this).attr('data-dstock'); 

			google.charts.load('current', {'packages':['corechart']});
	    	google.charts.setOnLoadCallback(drawChart);

		 	function drawChart() {
		    	var data = google.visualization.arrayToDataTable(jQuery.parseJSON(ddata), true);

			var options = {
               legend : { position : 'none' },
               tooltip: {isHtml: false},
               bar: { groupWidth: '60%' },   // Remove space between bars.
               width:80,
               height:100,
               candlestick: {
                  fallingColor: { strokeWidth: 1, stroke: '#EB4D5C', fill: '#EB4D5C' }, // red
                  risingColor: { strokeWidth: 0, stroke: '#53B987', fill: '#53B987' }   // green
               },
	            backgroundColor: 'transparent',
				colors: "#53B987";
			  chartArea: {
		        backgroundColor: {
		          fill: 'transparent',
		          fillOpacity: 0,
		          left:0,
		          top:"-60px",
		          bottom:0,
		          right:0,
		        },
		      },


              hAxis: {
                  title: '',
                  textPosition: 'none'
               },
               vAxis: {
                  title: '',
               },

               vAxes: {
		            0: {
		                textPosition: 'none',
		                gridlines: {
		                    color: 'transparent'
		                },
		                baselineColor: 'transparent'
		            },
		            1: {
		                gridlines: {
		                    color: 'transparent'
		                }
		            }
		        }

            };

			   
		    var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div_'+dstock));
		    google.visualization.events.addListener(chart, 'ready', afterDraw);
			    chart.draw(data, options);
			}

			function afterDraw(){
			    jQuery("rect[stroke-width='1']").addClass("addropes").siblings().attr('fill', '#eb4d5c');
			}

		});

		// jQuery(window).on('load', function() {
		// 	jQuery("rect[stroke-width='1']").addClass("addropes");
		// });

  	</script><?php */?>

 <!--Watchlist graph-->
    <script type="text/javascript">

		jQuery( ".dinnerlist ul li.watchonlist" ).each(function( index ) {

			var ddata = jQuery(this).attr('data-dhisto'); 
			var dstock = jQuery(this).attr('data-dstock'); 

			google.charts.load('current', {'packages':['corechart']});
	    	google.charts.setOnLoadCallback(drawChart);

		 	function drawChart() {
		    	var data = google.visualization.arrayToDataTable(jQuery.parseJSON(ddata), true);

			var options = {
               legend : { position : 'none' },
               tooltip: {isHtml: false},
               bar: { groupWidth: '80%' },   // Remove space between bars.
               width:250,
               height: 150,
               candlestick: {
                  fallingColor: { strokeWidth: 1, stroke: '#EB4D5C', fill: '#EB4D5C' }, // red
                  risingColor: { strokeWidth: 0, stroke: '#53B987', fill: '#53B987' }   // green
               },
	            backgroundColor: 'transparent',
	            colors : ['#53B987'],
              chartArea: {
		        backgroundColor: {
		          fill: 'transparent',
		          fillOpacity: 100,
		          left:0,
		          top:0,
		          bottom:0,
		          right:0,
		        },
		      },


              hAxis: {
                  title: '',
                  textPosition: 'none'
               },
               vAxis: {
                  title: '',
                  textPosition: 'none'
               },

               vAxes: {
		            0: {
		                textPosition: 'none',
		                gridlines: {
		                    color: 'transparent'
		                },
		                baselineColor: 'transparent'
		            },
		            1: {
		                gridlines: {
		                    color: 'transparent'
		                }
		            }
		        }

            };

			   
		    var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div_'+dstock));
		    google.visualization.events.addListener(chart, 'ready', afterDraw);
			    chart.draw(data, options);
			}

			function afterDraw(){
			    jQuery("rect[stroke-width='1']").addClass("addropes").siblings().attr('fill', '#eb4d5c');
			}

		});

		// jQuery(window).on('load', function() {
		// 	jQuery("rect[stroke-width='1']").addClass("addropes");
		// });

  	</script>
</body>
</html>
