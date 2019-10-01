<?php
/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */
do_action( 'et_after_main_content' );
// $profile_id = um_profile_id();

$users = get_users(['role' => '']);
$newuserlist = array();
foreach ($users as $key => $value) {
	$userdetails['id'] = $value->ID;
	$userdata = get_userdata($value->ID);
	$userdetails['user_login'] = $value->user_login;
	$userdetails['displayname'] = htmlentities($userdata->first_name .  " " . $userdata->last_name, ENT_QUOTES);
	array_push($newuserlist, $userdetails);
}


 
if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>
	<span class="et_pb_scroll_top et-pb-icon"></span>
<?php endif; ?>
	</div> <!-- #page-container -->
	<?php wp_footer(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="/wp-content/plugins/um-friends/assets/js/um-friends.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/parts.js?<?php echo time(); ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/pages.js?<?php echo time(); ?>"></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->
<script>
	window.onload = function() {
		if ( /^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
			$('#vyndue--link').attr("target","_blank");
			$('#vyndue--link').attr("href","https://vyndue.com");
			window.close();
		}
	}
</script>

<script type="text/javascript">
		(function($) {
		    jQuery(document).ready(function() {

		    	var postid;
		    	var usersall = `<?php echo json_encode($newuserlist); ?>`;

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


		        	$.ajax({
				    		url: "https://data-api.arbitrage.ph/api/v1/stocks/list",
							type: 'GET',
							dataType: 'json',
							success: function(response) {
								console.log(response);
							}error: function(xhr, ajaxOptions, thrownError) {  

               				}
				    	});



		        	var string = jQuery(this).val();
		        	var lastChar = string.substr(string.length -1);

		        	if($(this).val().length < 2 || lastChar == '$') {
		        		jQuery(".um-activity-new-post .um-activity-textarea .tagging_cont > li").remove();
		        		jQuery(this).parent().find(".popname").remove();
		        		return;
		        	}


		        	var counx = 0;
					//var usersall = `<?php // echo json_encode($newuserlist); ?>`;
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
				    	var stocks = '["2GO","8990P","AAA","AB","ABA","ABC","ABG","ABS","ABSP","AC","ACE","ACPA","ACPB1","ACPB2","ACR","AEV","AGI","ALCO","ALCPB","ALHI","ALI","ALL","ANI","ANS","AP","APC","APL","APO","APX","AR","ARA","AT","ATI","ATN","ATNB","AUB","BC","BCB","BCOR","BCP","BDO","BEL","BH","BHI","BKR","BLFI","BLOOM","BMM","BPI","BRN","BSC","CA","CAB","CAT","CDC","CEB","CEI","CEU","CHI","CHIB","CHP","CIC","CIP","CLC","CLI","CNPF","COAL","COL","COSCO","CPG","CPM","CPV","CPVB","CROWN","CSB","CYBR","DAVIN","DD","DDPR","DELM","DFNN","DIZ","DMC","DMCP","DMPA1","DMPA2","DMW","DNA","DNL","DTEL","DWC","EAGLE","ECP","EDC","EEI","EG","EIBA","EIBB","ELI","EMP","EURO","EVER","EW","FAF","FB","FBP","FBP2","FDC","FERRO","FEU","FFI","FGEN","FGENF","FGENG","FIN","FJP","FJPB","FLI","FMETF","FNI","FOOD","FPH","FPHP","FPHPC","FPI","FYN","FYNB","GEO","GERI","GLO","GLOPA","GLOPP","GMA7","GMAP","GPH","GREEN","GSMI","GTCAP","GTPPA","GTPPB","H2O","HDG","HI","HLCM","HOUSE","HVN","I","ICT","IDC","IMI","IMP","IND","ION","IPM","IPO","IRC","IS","ISM","JAS","JFC","JGS","JOH","KEP","KPH","KPHB","LAND","LBC","LC","LCB","LFM","LIHC","LMG","LOTO","LPZ","LR","LRP","LRW","LSC","LTG","M-O","MA","MAB","MAC","MACAY","MAH","MAHB","MARC","MAXS","MB","MBC","MBT","MED","MEG","MER","MFC","MFIN","MG","MGH","MHC","MJC","MJIC","MPI","MRC","MRP","MRSGI","MVC","MWC","MWIDE","MWP","NI","NIKL","NOW","NRCP","NXGEN","OM","OPM","OPMB","ORE","OV","PA","PAL","PAX","PBB","PBC","PCOR","PCP","PERC","PGOLD","PHA","PHC","PHEN","PHES","PHN","PIP","PIZZA","PLC","PMPC","PMT","PNB","PNC","PNX","PNX3A","PNX3B","PNXP","POPI","PORT","PPC","PPG","PRC","PRF2A","PRF2B","PRIM","PRMX","PRO","PSB","PSE","PSEI","PTC","PTT","PX","PXP","RCB","RCI","REG","RFM","RLC","RLT","ROCK","ROX","RRHI","RWM","SBS","SCC","SECB","SEVN","SFI","SFIP","SGI","SGP","SHLPH","SHNG","SLF","SLI","SM","SMC","SMC2A","SMC2B","SMC2C","SMC2D","SMC2E","SMC2F","SMC2G","SMC2H","SMC2I","SMCP1","SMPH","SOC","SPC","SPM","SRDC","SSI","SSP","STI","STN","STR","SUN","SVC","T","TBGI","TECB2","TECH","TEL","TFC","TFHI","TLII","TLJJ","TUGS","UBP","UNI","UPM","URC","V","VITA","VLL","VMC","VUL","VVT","WEB","WIN","WLCON","WPI","X","ZHI"]';


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
					//var usersall = `<?php // echo json_encode($newuserlist); ?>`;
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
</script>

<?php get_footer('all') ?>

<?php if ( is_user_logged_in() ) { ?>

	<?php get_footer('sockets') ?>

	<script language="javascript">

	function swipedetect(el, callback){

		var touchsurface = el,
		swipedir,
		startX,
		startY,
		distX,
		distY,
		threshold = 30, //required min distance traveled to be considered swipe
		restraint = 100, // maximum distance allowed at the same time in perpendicular direction
		allowedTime = 300, // maximum time allowed to travel that distance
		elapsedTime,
		startTime,
		handleswipe = callback || function(swipedir){}

		touchsurface.addEventListener('touchstart', function(e){
			var touchobj = e.changedTouches[0]
			swipedir = 'none'
			dist = 0
			startX = touchobj.pageX
			startY = touchobj.pageY
			startTime = new Date().getTime() // record time when finger first makes contact with surface
			e.preventDefault()
		}, false)

		touchsurface.addEventListener('touchmove', function(e){
			e.preventDefault() // prevent scrolling when inside DIV
		}, false)

		touchsurface.addEventListener('touchend', function(e){
			var touchobj = e.changedTouches[0]
			distX = touchobj.pageX - startX // get horizontal dist traveled by finger while in contact with surface
			distY = touchobj.pageY - startY // get vertical dist traveled by finger while in contact with surface
			elapsedTime = new Date().getTime() - startTime // get time elapsed
			if (elapsedTime <= allowedTime){ // first condition for awipe met
				if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){ // 2nd condition for horizontal swipe met
					swipedir = (distX < 0)? 'left' : 'right' // if dist traveled is negative, it indicates left swipe
				}
				else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint){ // 2nd condition for vertical swipe met
					swipedir = (distY < 0)? 'up' : 'down' // if dist traveled is negative, it indicates up swipe
				}
			}
			handleswipe(swipedir)
			e.preventDefault()
		}, false)
	}

	var el = document.getElementById('left-slide-trigger');
	swipedetect(el, function(swipedir){
		if(swipedir == "right"){
			jQuery('.left-dashboard-part').css("left","0");
			jQuery('.slidecloseoverlay').css("display","block");
			jQuery('.left-dashboard-part-overlay').fadeIn("fast");
		}
	});
		
	var el2 = document.getElementById('slidecloseoverlay');
	swipedetect(el2, function(swipedir){
		if (swipedir == "left"){
			jQuery('.left-dashboard-part').css("left","-100%");
			jQuery('.slidecloseoverlay').css("display","none");
			jQuery('.left-dashboard-part-overlay').fadeOut("fast");
		}
	});
		
	jQuery('.top-slide-trigger').click(function(){
		jQuery('.left-dashboard-part').css("left","0");
		jQuery('.slidecloseoverlay').css("display","block");
		jQuery('.left-dashboard-part-overlay').fadeIn("fast");
	});

	jQuery('.right-slider-menu').click(function(){

		if($('#right-menu').hasClass('right-slider-menu1')){
			jQuery('.right-dashboard-part').css("display","block");
			jQuery('.right-dashboard-part').css("right","0%");
			$('#right-slider-icon').attr('src','/wp-content/themes/arbitrage-child/images/cancel.svg');
			$('#right-slider-icon').attr('width','15px');
			$('#right-menu').removeClass();
		}else{
			jQuery('.right-dashboard-part').css("right","-110%");
			$('#right-slider-icon').attr('src','/wp-content/themes/arbitrage-child/images/menu.svg');
			$('#right-slider-icon').attr('width','20px');
			$('#right-menu').addClass('right-slider-menu1');
		}
	});

	 jQuery(window).scroll(function(){
	 		if(jQuery('.um-profile').hasClass('topbannerprofile')){
	 			return;
	 		}else {
	 			jQuery('.dashboard-sidebar-left-inner').addClass('fixed-sidebar');
			}
	 });

	</script>

<?php } ?>


<?php if ( is_user_logged_in() ) { ?>
	<?php if (is_front_page()){ // PWA - Add to homepage ?>
		<script>
		 if ('serviceWorker' in navigator) {
			navigator.serviceWorker.register('serworkr.js')
			  .then(function(reg){

			 }).catch(function(err) {
				
			});
		 }
		</script>
	<?php } ?>
<?php } ?>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/lazyfunc.js?<?php echo time(); ?>"></script>

<div class="left-dashboard-part-overlay" id="left-dashboard-part-overlay"></div>

</body>
</html>
