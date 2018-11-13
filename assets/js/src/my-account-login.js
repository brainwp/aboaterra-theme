/* my account login page */
jQuery(document).ready(function($) {
	if ( $( '#customer_login' ).length == 0 ) {
		return;
	}
	if ( $( window ).width < 800 ) {
		return;
	}
	var height = $( '.register-form' ).height() + 30 + 'px';
	$( '.login-form' ).css( 'height', height );
} );
