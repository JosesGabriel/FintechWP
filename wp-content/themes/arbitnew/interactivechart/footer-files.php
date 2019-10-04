<script language="javascript">
		$(document).ready(function() {
			
			$(window).load(function() {
				$("#status, #status_txt").fadeOut("fast");
				$("#preloader").delay(400).fadeOut("slow");
			})
			
			function changicotonormal() {
				var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
				link.type = 'image/x-icon';
				link.rel = 'shortcut icon';
				link.href = '/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-32x32.png';
				document.getElementsByTagName('head')[0].appendChild(link);
			}
			$( "body" ).mousemove(function() {
			  changicotonormal();
			});
			$( ".bidaskbar_btn" ).click(function() {
			  $( ".bidaskbar_opt" ).slideToggle("fast");
			});
            $(".bidaskbar_opt ul li a").click(function(e){
                e.preventDefault();
                var dtype = $(this).attr('data-istype');
                $(this).parents(".bidaskbar").find(".arb_bar").hide();
                $(this).parents(".bidaskbar").find("."+dtype).show();
                $(this).parents(".bidaskbar_opt").hide();
            });
		});
    </script>
    <script type="text/javascript">
    	jQuery(document).ready(function(){
			jQuery("ul.main-drops-chart").click(function(e){
                event.stopPropagation();
                var isopen = jQuery("ul.main-drops-chart > ul").hasClass("dropopen");

                if (isopen) {
                    jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
                } else {
                    jQuery("ul.main-drops-chart > ul").show().addClass("dropopen");
                }

            });
			jQuery(document).on("click", function () {
	            jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
	            jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
	            jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
	        });
		});
		jQuery(document).ready(function(){
            jQuery("ul.main-drops-chart > ul li:first-child").on("click", function () {
                event.stopPropagation();
                 var openthis = jQuery("#showplease").hasClass("dropthiss");
                 if ( openthis ) {
                     jQuery("#toghandle").hide().removeClass("dropthiss");
                } else {
                	jQuery("#toghandle").show().addClass("dropthiss");
                }
            });
            jQuery("ul.main-drops-chart > ul li:nth-child(2)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlings").show().addClass("dropthiss");

            });
            jQuery("ul.main-drops-chart > ul li:nth-child(3)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlingers").show().addClass("dropthiss");
            });
        });
        jQuery(document).ready(function(){
            jQuery(".toclassclose").on('click', function(){
                jQuery("#toghandle").hide().removeClass("dropthiss");
            });
            jQuery(".toclassclosess").on('click', function(){
                jQuery("#toghandlings").hide().removeClass("dropthiss");
            });
            jQuery(".toclasscloserss").on('click', function(){
                jQuery("#toghandlingers").hide().removeClass("dropthiss");
            });
        });
	</script>

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script>
	$( function() {
		$('#draggable_buysell').draggable({cancel:false});
	} );
	</script>
	<!--[if lt IE 9]>
		<script src="/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="/assets/crossbrowserjs/respond.min.js"></script>
		<script src="/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="/assets/js/apps.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-numeraljs/2.0.1/angular-numeraljs.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-moment/1.2.0/angular-moment.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/angular-timeago@0.4.6/dist/angular-timeago.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.6/angular-sanitize.min.js"></script>
	<script src="//cdn.rawgit.com/Luegg/angularjs-scroll-glue/master/src/scrollglue.js"></script>
	<script src="/assets/plugins/ng-embed/dist/ng-embed.min.js"></script>
	<script src="/assets/js/jquery.fullscreen-min.js"></script>
	<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/assets/js/aes.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
	<script src="https://platform.twitter.com/widgets.js"></script>
	<script>
		jQuery(".buySell__date-picker").attr('max', moment().format("YYYY-MM-DD"));
		var modalzindex = 10000;
		var nightmode = localStorage.getItem('theme') == 'dark';
        var socket = io.connect('https://dev-socket-api.arbitrage.ph');
		$(document).ready(function() {
			App.init();
		    $( function () {
		        $(".stocks-select2").select2({placeholder:"Stock", width: '100%'})
		    });
		});
		var _stocks     = {};
		var _admin 		= false;
		var _moderator 	= false;
		var _client_id 	= 'arbitrage.ph';
		var _user_id 	= '<?php echo $user->ID; ?>'
		var _symbol 	= '<?php 
		$getcururl = $_SERVER['REQUEST_URI'];
		if ($getcururl == "/chart/"){
			echo "PSEI";
		}else{
			$remchrt = str_replace("/chart/", "", $getcururl);
			$getfsymb = str_replace("/", "", $remchrt);
			echo strtoupper($getfsymb);
		}
		?>';
	</script>
	<script src="/assets/js/angular/functions.js?v=1.220"></script>
	<script src="/assets/js/angular/controllers.js?v=<?php echo time() ?>"></script>
	<script src="/assets/js/angular/directives.js?v=1.218"></script>
	<script src="/assets/js/angular/filters.js?v=1.218"></script>
	<script src="/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
	<script src="/assets/js/datafeed.js?v=2.218"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var x = 0;
			var y = 0;

			function fees(marketval) {
				//commission
				var dpartcommission = marketval * 0.0025;
				var dcommission = (dpartcommission > 20 ? dpartcommission : 20);

				var dtax = dcommission * 0.12;
				var dtransferfee = marketval * 0.00005;
				var dsccp = marketval * 0.0001;

				return dcommission + dtax + dtransferfee + dsccp;
			}
			function format_number(n) {
			return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
			}

			$('.inpt_data_price, .inpt_data_qty').keyup(function() {
				var buyprice = $('.inpt_data_price').val().replace(/[^0-9\.]/g, '');
				var buyquanti = $('.inpt_data_qty').val().replace(/[^0-9\.]/g, '');

				if (parseFloat(buyprice) > 0 && parseFloat(buyquanti) > 0) {
					var marketvalx = parseFloat(buyprice) * parseFloat(buyquanti);
					var dfees = fees(marketvalx);

					var totalcost = marketvalx + dfees;

					$(".inpt_total_cost").val(format_number(totalcost));
				} else {
					$(".inpt_total_cost").val('00.00');
				}
				
			});
		
		$( ".closesidebar a" ).click(function(){
			$( ".mobileinithide" ).addClass("hidesidebar", function(){
				$(".closesidebar").fadeOut("fast", function(){
					$(".opensidebar").fadeIn();
				});
			});
		});
		
		$( ".opensidebar a" ).click(function(){
			$( ".mobileinithide" ).addClass("showsidebar", function(){
				$(".opensidebar").fadeOut("fast", function(){
					$( ".mobileinithide" ).removeClass("hidesidebar");
					$( ".closesidebar" ).fadeIn();
				});
			});
		});
		
		
		$( ".mobileinithide .fa-outdent" ).click(function(){
			$( ".mobileinithide" ).animate({right: "0px"},500, function(){
				$( ".chartlocker" ).fadeIn(500);
				$( ".mobileinithide .fa-outdent" ).fadeOut(500, function(){
					$( ".mobileinithide .fa-indent, .arb_buysell" ).fadeIn();
				});
			});
		});
		$( ".mobileinithide .fa-indent" ).click(function(){
			$( ".mobileinithide" ).animate({right: "-260px"},500, function(){
				$( ".mobileinithide .fa-indent" ).fadeOut(500, function(){
					$( ".mobileinithide .fa-outdent, .arb_buysell" ).fadeIn();
				});
				$( ".chartlocker" ).fadeOut(500);
			});
		});

		var dpathss = window.location.pathname;
		var dstockpath = dpathss.split("/");
		dstockpath = dstockpath.filter(function(el) { return el; });
		dstockpath = dstockpath[(parseInt(dstockpath.length) - 1)];

		jQuery.ajax({
			method: "GET",
			url: "/apipge/?daction=checkifhavestock&symbol="+dstockpath,
			dataType: 'json',
			data: {
				'action' : 'post_sentiment',
				'stock' : dstockpath
			},
			success: function(data) {
				if(data.status == "yes_stock"){
					$("#sellvolume").val(data.data.volume);
					$("#sellavrprice").val(data.data.averageprice);
					$("#tradelogs").val(data.data.tradelog);
					$("#confirmsellparts").show();
				}
			}
		});
			
			$(".bbs_bull").click(function(e){
				e.preventDefault();
				if (!$(this).parents('.bullbearsents').hasClass('clickedthis')) {
					var pathname = window.location.pathname;

					$(this).parents('.bullbearsents').addClass("clickedthis");

					var dbull = $(this).parents('.bullbearsents').attr('data-bull');
					var dbear = $(this).parents('.bullbearsents').attr('data-bear');

					var dclass = $(this).attr('class');

					var dpathl = pathname.split("/");
					dpathl = dpathl.filter(function(el) { return el; });
					dpathl = dpathl[(parseInt(dpathl.length) - 1)];

					jQuery.ajax({
						method: "POST",
						url: "/apipge/?daction=sentimentbull&stock="+dpathl+"&userid=<?php echo $user_id; ?>&dbasebull="+dbull+"&dbasebear="+dbear+"&dbuttonact="+dclass,
						dataType: 'json',
						data: {
							'action' : 'post_sentiment',
							'stock' : dpathl,
							'postid' : '<?php echo get_the_id(); ?>',
							'userid' : '<?php echo $user_id; ?>',
							'dbasebull': dbull,
							'dbasebear': dbear,
							'dbuttonact' : dclass
						},
						success: function(data) {

							$( ".dbaronchart" ).animate({
								width: "70%"
							},500, function(){
								
							});

							$( ".bbs_bear_bar, .bbs_bull_bar" ).fadeIn("fast",function(){
									$( ".bullbearsents_label" ).animate({marginTop: "6px"},"slow");
							});

							$( ".bullbearsents .bbs_bear, .bullbearsents .bbs_bull" ).addClass("bbbutton-sen");

							$( ".bbs_bear_bar" ).animate({
								width: data.dbear+"%"
							},500, function(){
								$( ".bbs_bear_bar span" ).text(data.dbear.toFixed(2)+"%");
								$( ".bbs_bear_bar span" ).fadeIn("fast");
							});

							$( ".bbs_bull_bar" ).animate({
								width: data.dbull+"%"
							},500, function(){
								$( ".bbs_bull_bar span" ).text(data.dbull.toFixed(2)+"%");
								$( ".bbs_bull_bar span" ).fadeIn("fast");
							});

							$(".bullbearsents_label").html("Members sentiments");

						}
					});

				} 
			});

			$(".bbs_bear").click(function(e){
				e.preventDefault();
				if (!$(this).parents('.bullbearsents').hasClass('clickedthis')) {
					var pathname = window.location.pathname;

					$(this).parents('.bullbearsents').addClass("clickedthis");

					var dbull = $(this).parents('.bullbearsents').attr('data-bull');
					var dbear = $(this).parents('.bullbearsents').attr('data-bear');

					var dclass = $(this).attr('class');

					var dpathl = pathname.split("/");
					dpathl = dpathl.filter(function(el) { return el; });
					dpathl = dpathl[(parseInt(dpathl.length) - 1)];

					jQuery.ajax({
						method: "POST",
						url: "/apipge/?daction=sentimentbear&stock="+dpathl+"&userid=<?php echo $user_id; ?>&dbasebull="+dbull+"&dbasebear="+dbear+"&dbuttonact="+dclass,
						dataType: 'json',
						data: {
							'action' : 'post_sentiment',
							'stock' : dpathl,
							'postid' : '<?php echo get_the_id(); ?>',
							'userid' : '<?php echo $user_id; ?>',
							'dbasebull': dbull,
							'dbasebear': dbear,
							'dbuttonact' : dclass
						},
						success: function(data) {

							$( ".dbaronchart" ).animate({
								width: "70%"
							},500, function(){

							});

							$( ".bbs_bear_bar, .bbs_bull_bar" ).fadeIn("fast",function(){
									$( ".bullbearsents_label" ).animate({marginTop: "6px"},"slow");
							});

							$( ".bullbearsents .bbs_bear, .bullbearsents .bbs_bull" ).addClass("bbbutton-sen");

							$( ".bbs_bear_bar" ).animate({
								width: data.dbear+"%"
							},500, function(){
								$( ".bbs_bear_bar span" ).text(data.dbear.toFixed(2)+"%");
								$( ".bbs_bear_bar span" ).fadeIn("fast");
							});

							$( ".bbs_bull_bar" ).animate({
								width: data.dbull+"%"
							},500, function(){
								$( ".bbs_bull_bar span" ).text(data.dbull.toFixed(2)+"%");
								$( ".bbs_bull_bar span" ).fadeIn("fast");
							});

							$(".bullbearsents_label").html("Members sentiments");

						}
					});

				} 
			});

		jQuery('.inpt_data_price').keyup(function(){
			var inputVal = jQuery(this).val().length;
			if(inputVal != 0){
				y = 1
			}
		});
		jQuery('.inpt_data_qty').keyup(function(){
			var inputVal2 = jQuery(this).val().length;
			if(inputVal2 != 0){
				x = 1
			}
		});

		$(".confirmtrd").click(function(e){

			var dbuypower = $(".input_buy_power").attr('data-dbaseval');
			var dpurprice = $(".inpt_data_price").val().replace(/[^0-9\.]/g, '');
			var dpurqty = $(".inpt_data_qty").val().replace(/[^0-9\.]/g, '');		
			
			if (parseFloat(dbuypower) < (parseFloat(dpurprice) * parseFloat(dpurqty))) {
				e.preventDefault();
				$(".derrormes").text('You can only purchase a maximum of '+ numeral(dbuypower / dpurprice).format('0,0.00') +' stocks if the price is ₱'+ numeral(dpurprice).format('0,0.00')  );
			}else {
				if(x == 1 && y == 1){
					$('.chart-loader').css("display","block");
					$(this).hide();
				}
			}
		
		});

        jQuery('input.number').keyup(function (event) {
                // charts
				// skip for arrow keys
				if (event.which >= 37 && event.which <= 40) {
					event.preventDefault();
				}

				var currentVal = jQuery(this).val();
				var testDecimal = testDecimals(currentVal);
				if (testDecimal.length > 1) {
					currentVal = currentVal.slice(0, -1);
				}
				jQuery(this).val(replaceCommas(currentVal));

			});

			function testDecimals(currentVal) {
				var count;
				currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
				return count;
			}

			function replaceCommas(yourNumber) {
				var components = yourNumber.toString().split(".");
				if (components.length === 1) 
					components[0] = yourNumber;
				components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				if (components.length === 2)
					components[1] = components[1].replace(/\D/g, "");
				return components.join(".");
			}

		});
	</script>
