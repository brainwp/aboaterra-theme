jQuery(document).ready(function($) {
	$( '.btn-animation-next' ).on( 'click', function(e) {
		e.preventDefault();
		$elem = $( $(this).attr( 'href' ) );
		if ( $elem.length > 0 ) {
			console.log( 'ahoy' );
			$elem.removeClass( 'animated pulse' );
			$( 'html, body' ).animate({ scrollTop: $elem.offset().top - 40 }, 600);
			$elem.addClass( 'animated pulse' );
		}
	} )
} );
