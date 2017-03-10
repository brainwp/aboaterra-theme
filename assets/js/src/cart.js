/**
 Cart scripts
*/
jQuery(document).ready(function($) {
	/**
	 * Box de confirmação antes de deletar todo o cart
	*/
	$( '#cart-empty-link' ).on( 'click', function( e ) {
		if ( ! confirm( $( this ).attr( 'data-confirm' ) ) ) {
			e.preventDefault();
		}
	});
} );
