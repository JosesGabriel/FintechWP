<?php
/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */
do_action( 'et_after_main_content' );
$profile_id = um_profile_id();

//global $wp_query; 
//$postid = $wp_query->post->ID;

if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>
	<span class="et_pb_scroll_top et-pb-icon"></span>
<?php endif; ?>
	</div> <!-- #page-container -->
	<?php wp_footer(); ?>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

<style>
html {margin-top: 0 !important;}
#wpadminbar {display:none !important;}
body.admin-bar.et_fixed_nav #main-header, body.admin-bar.et_fixed_nav #top-header, body.admin-bar.et_non_fixed_nav.et_transparent_nav #main-header, body.admin-bar.et_non_fixed_nav.et_transparent_nav #top-header {top: 0 !important;}
.et_fixed_nav.et_show_nav #page-container, .et_non_fixed_nav.et_transparent_nav.et_show_nav #page-container {padding-top: 54px;}
</style>
<?php /* temp-disabled
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes' );
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$dwatchinfo = curl_exec($curl);
	curl_close($curl);

	$genstockinfo = json_decode($dwatchinfo);
	$stockinfo = $genstockinfo->data; */
?>
<script src="https://arbitrage.ph/wp-content/plugins/um-friends/assets/js/um-friends.js"></script>
<script type="text/javascript">
		(function($) {
			// jQuery(document).scrollTop(0);
			// jQuery("html,body").animates({ scrollTop: 0 }, "slow");
			
		    jQuery(document).ready(function() {

		    	var postid;
		    	
		    	


		    	jQuery(".um-activity-new-post .um-activity-textarea").append('<div class="tagging_cont"></div>');


				
				jQuery(this).on('keyup', '.um-activity-comment-textarea', function (e) {

					postid = jQuery(this).parents('.um-activity-widget').attr('id').replace('postid-', '');
				
					console.log(postid);

					if($(this).parent().find('.comment_tag_' + postid).length == 0){
						jQuery(this).parents('.um-activity-comment-box').append('<div class="comment_tag_'+postid+'"></div>');
						
						$('<input>').attr({
						    type: 'hidden',
						    value: '',
						    class: 'userlogin',
						}).appendTo('.um-activity-comment-box');
					
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

				// var typingTimer;                //timer identifier
				// var doneTypingInterval = 500;  //time in ms, 5 second for example
				// var $input = $('.um-activity-textarea textarea');

				// $input.on('keyup', function () {
				// 	clearTimeout(typingTimer);
				// 	typingTimer = setTimeout(doneTyping, doneTypingInterval);
				// });

				// //on keydown, clear the countdown 
				// $input.on('keydown', function () {
				// 	clearTimeout(typingTimer);
				// });

				var loopfriends;
				jQuery('.um-activity-textarea textarea').on('keydown', function (e) {
					clearTimeout(loopfriends);
				});



		        jQuery('.um-activity-textarea textarea').on('keyup', function (e) {
					<?php
						/*global $wpdb;
					


						//$profile_id = 7;
						$table = $wpdb->prefix . "um_friends";
						$results = $wpdb->get_results( $wpdb->prepare(
							//"SELECT user_id1, user_id2 FROM {$table} WHERE status = 1 AND ( user_id1 = %d OR user_id2 = %d ) ORDER BY time DESC", $profile_id, $profile_id
							//"SELECT user_id1, user_id2 FROM {$table} WHERE status = 1 AND ( user_id1 = %d ) ORDER BY time DESC"
							"SELECT user_id1, user_id2 FROM {$table} WHERE status = 0 AND ( user_id1 = %d ) ORDER BY time DESC"
						), ARRAY_A ); 
						
						$listoffriends = array();
						foreach ( $results as $page )
							{
							$user_info = get_userdata($page['user_id1']);       
							
							$infoars = [];
							$infoars['id'] = $user_info->ID;
							$infoars['firstname'] = $user_info->first_name;
							$infoars['lastname'] = $user_info->last_name;

							array_push($listoffriends,$infoars);
								
							}*/
							
						$topargs = array(
							'role'          =>  '',
							// 'meta_key'      =>  'account_status',
							// 'meta_value'    =>  'approved'
						);
					
						$users = get_users($topargs);
						$newuserlist = array();
						foreach ($users as $key => $value) {
								$userdetails['id'] = $value->id;
								$userdata = get_userdata($value->id);
								// $userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
								$userdetails['displayname'] = $userdata->first_name .  " " . $userdata->last_name;
								array_push($newuserlist, $userdetails);
							}
						

					?>
		        	var counx = 0;
		        	var dstocks = '<?php echo $dwatchinfo; ?>';
		        	var allstocks = dstocks.data;
					var allprocess = '<?php echo json_encode($listoffriends); ?>';
					var usersall = '<?php echo json_encode($newuserlist); ?>';
					clearInterval(loopfriends);
					// console.log(usersall);
							jQuery(".um-activity-new-post .um-activity-textarea .tagging_cont")
		        	if (e.which == 52) { dauto = true; }
		        	if (e.which == 32) { dauto = false; }

		        	var dcontexttext = jQuery(this).val();
		        	var res = dcontexttext.split(" ");
		        	var dlastitem = res[res.length-1];
		        	var i;
				     //console.log(allprocess);
					 jQuery(".um-activity-new-post .um-activity-textarea .tagging_cont > li").remove();
					if(!(dlastitem.indexOf('@') === -1)){
						dauto = false;
						loopfriends = setInterval(function(){
							console.log(dlastitem);
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
						
				    	// console.log('does not contaun');
				    } else {
				    	dauto = true;
						console.log(dlastitem);
				    	// console.log('contacin');
				    }

				    if (dauto) {
				    	// jQuery(this).parent().find(".popname").remove();

				    	// var dpop = "";
				    	// dpop += '<div class="popname">';
					    // 	dpop += '<ul>';
					    // 	$.each(allstocks, function(index, dfeats){
					    // 		if (index.indexOf(String.fromCharCode(e.which)) >= 0) {
					    // 			// dpop += '<li style="background:'+colors[counx]+';">'+index+'</li>';
					    // 			dpop += '<li style="background-image: linear-gradient(to right, '+colors[counx]+' , '+colors[(counx + 0 >= arraylimit ? 0 : counx + 1)]+');color:#fff;"><span class="inboxc">'+index+'</span></li>';

					    // 			if (counx >= (arraylimit)) {
						//     			counx = 0;
						//     		} else {
						//     			counx++;
						//     		}
					    // 		}


					    // 	});
					    // 	dpop += '</ul>';
				    	// dpop += '</div>';
				    	// jQuery(this).parent().append(dpop);
				    } else {
				    	// jQuery(this).parent().find(".popname").remove();
				    }
				   	 // console.log(dcontexttext);
				});

				


///=======comment tagging area========//
		

		jQuery(this).on('keyup','.um-activity-comment-textarea', function(e){

					
					var comment_id = jQuery(this).attr('data-reply_to');

								
					<?php
						

							
						$topargs = array(
							'role'          =>  '',
							
						);
					
						$users = get_users($topargs);
						$newuserlist = array();
						foreach ($users as $key => $value) {
								$userdetails['id'] = $value->id;
								$userdata = get_userdata($value->id);
								$userdetails['user_login'] = $value->user_login;
								$userdetails['displayname'] = $userdata->first_name .  " " . $userdata->last_name;
								array_push($newuserlist, $userdetails);
							}
						

					?>


		        	var counx = 0;
		        	var dstocks = '<?php echo $dwatchinfo; ?>';
		        	var allstocks = dstocks.data;
					var allprocess = '<?php echo json_encode($listoffriends); ?>';
					var usersall = '<?php echo json_encode($newuserlist); ?>';
					clearInterval(loopfriends);
					
					//jQuery(".um-activity-comment-box .comment_tag_" + postid);
					//jQuery(this).parents(".um-activity-comment-box .comment_tag_" + postid);
				
		        	if (e.which == 52) { dauto = true; }
		        	if (e.which == 32) { dauto = false; }


		        	var dcontexttext = $(this).val();

		        	console.log(dcontexttext);

		        	var res = dcontexttext.split(" ");
		        	var dlastitem = res[res.length-1];
		        	var i;
  	
		        	if(comment_id != 0 ){
							postid = comment_id;
					}
					//jQuery(".um-activity-comment-box .comment_tag_" + postid + " > li").remove();
					$(".um-activity-comment-box .comment_tag_" + postid + " > li").remove();

					if(!(dlastitem.indexOf('@') === -1)){
						dauto = false;
						loopfriends = setInterval(function(){
							//console.log(dlastitem);
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
						console.log("yes");
				    	
				    }

				   
				});


		  $(document).on('click','.cgitem', function(){

		  	//console.log(jQuery(this).text());

		  			var textval = jQuery(this).parents('.um-activity-comment-box').find('textarea').val();

					var did = jQuery(this).attr('data-id');

					var user1 = jQuery(this).parents('.um-activity-comment-box').find('input.userlogin').attr('value');

					userlogin = jQuery(this).attr('user-login') + ' ' + user1;


					console.log(userlogin);

					
					var isname = jQuery(this).text();

					var dtextareas = jQuery(this).parents('.um-activity-comment-box').find('textarea').val();
					
					
					
					var res = dtextareas.split(" ");

					//var dlastitem = res[res.length-1];

					var dfinalname = isname.replace(' ', '_').toLowerCase();

					
					var n = dtextareas.lastIndexOf("@");

					var comm = dtextareas.slice(0, n);

					//var dreplaceditem = dtextareas.replace(dlastitem, '@'+did+'_'+dfinalname);

					var dreplaceditem = comm + '@'+did+'_'+dfinalname;



					console.log(dreplaceditem);
					jQuery(this).parents('.um-activity-comment-box').find('textarea').val(dreplaceditem).focus();
					jQuery(this).parents('.um-activity-comment-box').find('input.userlogin').attr('value', userlogin);

		  });
			

///===========================///


				$(".um-activity-new-post .um-activity-textarea .tagging_cont").on("click", ".cgitem", function(){

									// console.log(jQuery(this).text());
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

					console.log(dreplaceditem);
					jQuery(this).parents('.um-activity-textarea').find('textarea').val(dreplaceditem).focus();


					// var n = textval.lastIndexOf("@");
					// console.log(n);

					// var str = textval.slice(n);

					// if (textval.slice(n + 1) !== null){
					
					// }
					// //var replacement = "!!";
					// //var str = this.substr(0, 2) + replacement + this.substr(2 + replacement.length);
					// console.log(str);




					// 	jQuery(this).parents('.um-activity-textarea').find('textarea').val(str + jQuery(this).text());


				
				});

				jQuery(".um-activity-textarea").on("click", ".popname ul li", function(){
				    // jQuery('.um-activity-textarea textarea').val();

				    var dsaid = jQuery(this).parents('.um-activity-textarea').find('textarea').val();
				    // console.log(dsaid);
				    var res = dsaid.split(" ");
				    console.log(res[res.length-1]);
				    console.log(dsaid);
				    console.log(jQuery(this).text());
				    var newdesc = dsaid.replace(res[res.length-1], '$'+jQuery(this).text());
				    jQuery(this).parents('.um-activity-textarea').find('textarea').val(newdesc);
				    // console.log(newdesc);
				    jQuery(this).parents('.um-activity-textarea').find(".popname").remove();
				});
		    });
	 
		})(jQuery);
	</script>

<?php get_footer('all') ?>
<?php get_footer('sockets') ?>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.4/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#config-web-app -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyD1qzYu4IMXmAkDCwiyIzz5ybYlMpByISY",
    authDomain: "arbitrage-2b99e.firebaseapp.com",
    databaseURL: "https://arbitrage-2b99e.firebaseio.com",
    projectId: "arbitrage-2b99e",
    storageBucket: "arbitrage-2b99e.appspot.com",
    messagingSenderId: "890289614246",
    appId: "1:890289614246:web:09ab58b35d23c549"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
</body>
<script>
 if ('serviceWorker' in navigator) {
    console.log("Will the service worker register?");
    navigator.serviceWorker.register('serworkr.js')
      .then(function(reg){
        console.log("Yes, it did.");
     }).catch(function(err) {
        console.log("No it didn't. This happened:", err)
    });
 }
</script>
</html>
