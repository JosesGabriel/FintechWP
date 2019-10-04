<script language="javascript">
		$(document).ready(function() {
			
			$(window).load(function() {
				$("#status, #status_txt").fadeOut("fast");
				$("#preloader").delay(400).fadeOut("slow");
			})
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
		var dpathss = window.location.pathname;
		var dstockpath = dpathss.split("/");
		dstockpath = dstockpath.filter(function(el) { return el; });
		dstockpath = dstockpath[(parseInt(dstockpath.length) - 1)];
		var _stocks     = {};
		var _admin 		= false;
		var _moderator 	= false;
		var _client_id 	= 'arbitrage.ph';
		var _user_id 	= '<?php echo $user->ID; ?>'
		var _symbol 	= dstockpath == 'chart' ? 'PSEI' : dstockpath;
		var _post_id    = '<?php echo get_the_id(); ?>';
	</script>
	<script src="/assets/js/angular/functions.js?v=1.220"></script>
	<script src="/assets/js/angular/controllers.js?v=<?php echo time() ?>"></script>
	<script src="/assets/js/angular/directives.js?v=1.218"></script>
	<script src="/assets/js/angular/filters.js?v=1.218"></script>
	<script src="/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
	<script src="/assets/js/datafeed.js?v=2.218"></script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/interactivechart/interactivecharts-scripts.js?v=<?php echo time(); ?>"></script>