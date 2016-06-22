jQuery(document).ready(function($) {
	$( document ).ajaxComplete( function( e ) {
		var $content = $( '#reveal-modal-id' );
		if ( $content.find( '.woocommerce').length > 0 ) {
			$content.addClass( 'modal-bigger' );
		} else {
			$content.removeClass( 'modal-bigger' );
		}
	});
});
