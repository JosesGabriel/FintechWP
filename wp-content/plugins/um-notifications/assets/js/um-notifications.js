/**

 *

 */

function um_load_notifications() {



	jQuery.ajax({

		url: wp.ajax.settings.url,

		type: 'post',

		dataType: 'json',

		data: {

			action: 'um_notification_check_update',

			nonce: um_scripts.nonce

		},

		success: function( data ) {
			console.log(data)
			var um_notification_icon_show = jQuery('.um-notification-b').data('show-always');



			if ( data.refresh_count ) {



				jQuery('.um-notification-b').animate({'bottom' : '25px'}).addClass('has-new');

				um_animate_bubble();

				jQuery('.um-notification-live-count').html( data.refresh_count ).show();



			}



			// We have a new item

			if ( data.unread ) {


				var id_ = jQuery(data.unread).attr('data-notification_id');



				if (jQuery('.um-notification[data-notification_id='+id_+']').length == 0 ) {

					jQuery('.um-notifications-none').hide();

					jQuery('.um-notification-ajax').prepend( data.unread );



					jQuery('.um-notification-b').animate({'bottom': '25px'}).addClass('has-new');

					um_animate_bubble();



				} else {

					jQuery('.um-notification[data-notification_id='+id_+']').removeClass('read').addClass('unread');

					jQuery('.um-notifications-none').hide();



					jQuery('.um-notification-b').animate({'bottom': '25px'}).addClass('has-new');

					um_animate_bubble();

				}



			} else {



				// nothing new

				jQuery('.um-notification-live-count').html( 0 ).hide();



				if( um_notification_icon_show != true ) {

					jQuery('.um-notification-b').animate({'bottom':'-220px'}).removeClass('has-new');

				}

				um_stop_bubble();



			}



			if ( jQuery('.um-notification.unread').length == 0 ) { // there's really no new notifications

				jQuery('.um-notification-live-count').html(0).hide();

				if( um_notification_icon_show != true) {

					jQuery('.um-notification-b').animate({'bottom':'-220px'}).removeClass('has-new');

				}

				um_stop_bubble();

			}



		}

	});

}





/**

 *

 */

function um_animate_bubble(){

	if ( jQuery('.um-notification-b').length ) {

		jQuery('.um-notification-b').addClass('um-effect-pop');

	}

}





/**

 *

 */

function um_stop_bubble() {

	if ( jQuery('.um-notification-b').length ) {

		jQuery('.um-notification-b').removeClass('um-effect-pop');

	}

}





/**

 *

 */

function um_notification_responsive() {

	var dwidth = jQuery(window).width();

	if ( dwidth < 400 ) {

		jQuery('.um-notification-live-feed').css({'width':dwidth + 'px'});

	} else {

		jQuery('.um-notification-live-feed').css({'width':'400px'});

	}

}



jQuery(window).resize(function(){

	um_notification_responsive();

});



// Our code begins here

jQuery(document).ready(function() {



	/* Default photo */

	jQuery('.um-notification-photo').on('error', function() {

		jQuery(this).attr('src', jQuery(this).data('default'));

	});



	/* Close feed window */

	jQuery(document).on('click', '.um-notification-i-close',function(e){

		e.preventDefault();

		var container = jQuery(".um-notification-live-feed");

		container.hide();

		return false;

	});



	um_load_notifications();

	if ( um_notifications.timer ) {

		setInterval( um_load_notifications, um_notifications.timer );

	}



	if ( jQuery('.um-notification-ajax').length ) {



		if ( ! jQuery('.um-notification.unread').length ) { // there's really no new notifications

			jQuery('.um-notification-live-count').html(0).hide();

		}



	}



	jQuery(document.body).on('click', '.um-notification-hide a',function() {
		e.preventDefault();

		var notification_id = jQuery(this).parents('.um-notification').attr('data-notification_id');

		var holder = jQuery(this).parents('.um-notification-live-feed');

		jQuery(this).parents('.um-notification').remove();

		if ( holder.length ) {

			var p = holder.find('.um-notification');

			if ( ! p.length ) {

				holder.find('.um-notification-more').hide();

				holder.find('.um-notifications-none').show();

			}

		}

		jQuery.ajax({

			url: wp.ajax.settings.url,

			type: 'post',

			data: {

				action:'um_notification_delete_log',

				notification_id: notification_id,

				nonce: um_scripts.nonce

			},

			success: function(data){


			}

		});

		return false;

	});




	jQuery(document.body).on('click', '.um-notification:not(.none) a', function() {

		var notification_uri = jQuery(this).attr('data-notification_uri');

		if ( notification_uri ) {

			window.location.href = notification_uri;

		}

	});



	jQuery(document.body).on('mouseenter', '.um-notification:not(.none)',function(e){

		if ( jQuery(this).hasClass('unread') ) { // only if unread



		var notification_id = jQuery(this).attr('data-notification_id');

		jQuery('*[data-notification_id='+notification_id+']').addClass('read').removeClass('unread');

		var notification = jQuery(this);

		notification.addClass('read').removeClass('unread');



		new_live_count = parseInt( jQuery('.um-notification-live-count').html() ) - 1;

		if ( new_live_count < 0 ) {

			new_live_count = 0;

		}



		jQuery('.um-notification-live-count').html( new_live_count );



		// Nothing more to see

		if ( new_live_count == 0 ) {

			jQuery('.um-notification-live-count').html( 0 ).hide();

			um_stop_bubble();

		}



		jQuery.ajax({

			url: wp.ajax.settings.url,

			type: 'post',

			data: {

				action:'um_notification_mark_as_read',

				notification_id: notification_id,

				nonce: um_scripts.nonce

			},

			success: function(data){



			}

		});



		}



	});



	if ( jQuery('.um-notification-live-count').length && parseInt( jQuery('.um-notification-live-count').html() ) > 0 ) {

		jQuery('.um-notification-live-count').show();

	}



	if ( jQuery('.um-notification-b').length ) {



		if ( jQuery('.um-notification-b').hasClass('left') ) {

			jQuery('.um-notification-live-feed').css({

				left: '0'

			});

		} else {

			jQuery('.um-notification-live-feed').css({

				right: '0'

			});

		}



		jQuery( document.body ).on( 'click', '.um-notification-b',function(e){

			e.preventDefault();

			var live_feed = jQuery( '.um-notification-live-feed' );

			if ( live_feed.is(':hidden') ) {

				um_notification_responsive();

				live_feed.show();

			} else {

				live_feed.hide();

			}

			return false;

		});



	}



});