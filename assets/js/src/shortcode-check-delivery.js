/* my account login page */
jQuery(document).ready(function($) {
	$( '.brasa-check-delivery-container').on( 'submit', function( e ) {
		e.preventDefault();
		var $form = $( this );
		var $elements_div = $( this ).children( '.elements' );
		var $submit_btn = $elements_div.children( 'button' );
		var default_text = $submit_btn.html();
		$submit_btn.html( $submit_btn.attr( 'data-load' ) );
		var data = {
			'action': 'brasa_check_delivery',
			'postcode': $elements_div.children( '[name="check-delivery"]' ).val()
		};
		console.log( data );

		$.post( odin.ajax_url, data, function(response) {
			$elements_div.children( '.response' ).html( response );
			$submit_btn.html( default_text );
		});
	})
} );
