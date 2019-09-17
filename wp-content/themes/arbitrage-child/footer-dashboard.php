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

<?php endif; ?>
	<div style="display: none;">
		<a id="entry_price">&nbsp;</a>
		<a id="take_profit_point">&nbsp;</a>
		<a id="stop_loss_point">&nbsp;</a>
	</div>
	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js" integrity="sha256-BfIfo/K+ePw1iAn4BFfrfVXmXQPAmKtqeDwVIgCFqTU=" crossorigin="anonymous"></script>
	<script src="https://arbitrage.ph/wp-content/plugins/um-friends/assets/js/um-friends.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
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
							dlisk += '</div>';
							dlisk += '<div class="closetab">';
							dlisk += '<input type="hidden" id="dparamcondition" name="dcondition_'+dcondition+'" value="'+dcondition+'">';
							dlisk += '<input type="hidden" id="" name="dconnumber_'+dcondition+'" value="'+dnum+'">';
							dlisk += '<button class="closemebutton"><i class="fa fa-minus-circle"></i></button>';
							dlisk += '</div>';
							dlisk += '<br style="clear:both;">';
						dlisk += "</li>";

					jQuery(".listofinfo").append(dlisk);
				} else {
				}
			});

			jQuery('.closemebutton').click(function(e){
			});

			jQuery('#submitmenow').click(function(e){
				e.preventDefault();

				var isstock = jQuery(this).parents('#add-watchlist-param').find("#dstockname").val();
				
				//var countli = jQuery(".listofinfo li").length;

				//if (countli != 0) {
					if (isstock != "" && jQuery("#add-watchlist-param input:checkbox:checked").length > 0 ) {
						jQuery("#add-watchlist-param").submit();
						$('.chart-loader').css("display","block");
						$(this).hide();
					}
				//}
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


			<?php /* temp-disabled-start */
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/list");
				//curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
				curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
        		curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec($curl);
				curl_close($curl);

				if ($response !== false) {
					$response = json_decode($response);
					$jsonstocklist = json_encode($response);
				}	
				
			?>
			
			$.ajax({
				url: "https://data-api.arbitrage.ph/api/v1/stocks/list",
				type: 'GET',
				dataType: 'json', // added data type
				success: function(res) {
					console.log(res);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				}
			});
			var stocklist = <?php echo $jsonstocklist; ?> ;	

			<?php // $havemeta = get_user_meta($userID, '_watchlist_instrumental', true); ?>

				var i = 0;

				// TODO Fix: this is causing front end errors
				jQuery.each(stocklist.data, function(index, value) {
					//condition here if stock is in the watchlist, do not append.
					//if('<?php //echo $value['stockname']; ?>' !== value.symbol){
						jQuery('.listofstocks').append('<a class="datastock_' + i + '" href="#" data-dstock="'+value.symbol+'">'+value.symbol+'</a>');
						i++;
					//}	
					

				});	 


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
							window.location.href = "https://arbitrage.ph/watchlist/?remove="+ditemtoremove;
						});
					}
				});
			});

			jQuery('.editmenow').click(function(e){
				e.preventDefault();
				jQuery("#"+jQuery(this).attr('data-tochange')).submit();
				$('.chart-preloader').css("display","block");
				$(this).hide();
			});

			<?php /* temp-disabled-start */
			/*
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/list");
				curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec($curl);
				curl_close($curl);

				if ($response !== false) {
					$response = json_decode($response);
					$jsonstocklist = json_encode($response);
				}	
				
			?>
			var stocklist = <?php echo $jsonstocklist; ?> ;



			<?php $havemeta = get_user_meta($userID, '_watchlist_instrumental', true); ?>
			<?php foreach ($havemeta as $key => $value) { ?>

				var i = 0;
				// TODO Fix: this is causing front end errors
				jQuery.each(stocklist.data, function( index, value ) {
					//condition here if stock is in the watchlist, do not append.
					if('<?php echo $value['stockname']; ?>' !== value.symbol){
						jQuery('.listofstocks').append('<a class="datastock_' + i + '" href="#" data-dstock="'+value.symbol+'">'+value.symbol+'</a>');
						i++;
					}	
					

				});


			 <?php  break; }  */?>
			var startTime = '9:00 AM';
		    var endTime = '3:30 PM';

		    var curr_time = getval();

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

				var dtyped = jQuery(this).val();
				
				//jQuery('.ddropbase').css('display','block');
				if(jQuery(this).val().length < 1){
					jQuery('.ddropbase').removeClass('opendrop').hide('slow');
				}

				if (jQuery(this).hasClass('disopen')) {
					jQuery(this).removeClass('disopen');
					//jQuery('.ddropbase').removeClass('opendrop').hide('slow');
				} else {
					jQuery(this).addClass('disopen');
					jQuery('.ddropbase').addClass('opendrop').show('slow');
				}

			});


			jQuery( "#myDropdown" ).keyup(function(e) {
				e.preventDefault();

				var dtyped = jQuery(this).val();

				//jQuery('.dropdown-content').css("display","block");

				jQuery(".listofstocks > a").each(function(index){
					var istock = jQuery(this).attr('data-dstock');
					if (istock.toLowerCase().indexOf(dtyped) >= 0) {
						jQuery(this).show();
					} else {
						jQuery(this).hide();
					}
				});
			});

			jQuery('input[type="checkbox"]').click(function(){
				if(this.value == "sms-notif"){
					//get phone meta

					var phonenum = "<?php 
					$usercp = get_user_meta(get_current_user_id(), 'cpnum', true);
					if($usercp == ""){
						echo "nocp";
					}else{
						echo $usercp;
					} 
					?>";

					if(phonenum == "nocp"){
						console.log('here');
						$("#modal-phonenum").modal('show'); 
					}
				
				}
			});
			jQuery("#cpsubmitbtn").click(function(){
				var cpnum = $("#txtcpnum").val();
				jQuery.ajax({
					method: "get",
					url: "/watchlist?addcp=" + cpnum,
					success: function(data){
						console.log("Success");
					}
				});
					
				$("#modal-phonenum").modal('hide'); 
			});
			//jQuery('.ddropbase a').click(function(e){
			jQuery(document).on('click','.ddropbase a',function(e){
				e.preventDefault();
				var dstock = jQuery(this).attr('data-dstock');

				jQuery('#myDropdown').val(dstock);
				jQuery('.ddropbase').removeClass('opendrop').hide('slow');

				jQuery(this).parents('.ddropbase').find('#dstockname').val(dstock);

				//jQuery(this).parents('.ddropconts').find('#myDropdown').removeClass('disopen');
				//jQuery(this).parents('.ddropconts').find('.ddropbase').removeClass('opendrop').hide('slow');

				//jQuery(this).parents('.dselectstockname').find(".dselected").html("Stock Selected: <span class='dstock-element'>"+dstock+"</span>");

			});

			jQuery(".dbox .innerbox").click(function(){
				if (jQuery(this).find('.stocknum').hasClass('hidedis')) {
					jQuery(this).find('.stocknum').removeClass('hidedis');
				} else {
					jQuery(this).find('.stocknum').addClass('hidedis');
				}

				if (jQuery(this).find('.stockperc').hasClass('hidedis')) {
					jQuery(this).find('.stockperc').removeClass('hidedis');
				} else {
					jQuery(this).find('.stockperc').addClass('hidedis');
				}
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

	  <?php /* temp-disabled-start */ 
	  include 'watchlist-alert.php'; 
	  /*temp-disabled-end */ ?>

</body>
</html>
