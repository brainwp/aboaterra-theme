/* my account login page */
jQuery(document).ready(function($) {
	$( '.brasa-check-delivery-container').on( 'submit', function( e ) {
		e.preventDefault();
		var $form = $( this );
		var $submit_btn = $form.children( 'button' );
		var default_text = $submit_btn.html();
		$submit_btn.html( $submit_btn.attr( 'data-load' ) );
		var data = {
			'action': 'brasa_check_delivery',
			'postcode': $form.children( '[name="check-delivery"]' ).val()
		};
		console.log( data );

		$.post( odin.ajax_url, data, function(response) {
			$form.children( '.response' ).html( response );
			$submit_btn.html( default_text );
		});
	})
} );
