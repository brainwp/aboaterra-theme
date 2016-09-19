/* checkout coupon */
jQuery(document).ready(function($) {
	$( document ).ajaxComplete(function( event, xhr, settings ) {
		if ( settings.url.indexOf( '?wc-ajax=add_to_cart' ) > -1 ) {
			console.log( 'update_cart' );
			var data = {
				'action': 'update_header_cart'
			};
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			$.post(odin.ajax_url, data, function( response ) {
				if ( response !== false ) {
					$( '.woocommerce-infos' ).html( response );
				}
			});
		}
	});
} );
